<?php

declare(strict_types=1);

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Api\Groups\Group;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class GroupsClient extends Client implements ClientInterface
{
    public const ACTION_RETRIEVE_GROUP = 'retrieve_group';
    public const ACTION_ADD_USER = 'add_user';
    public const ACTION_REMOVE_USER = 'delete_user';
    public const ACTION_DISABLE_USER = 'disable_user';
    public const ACTION_ENABLE_USER = 'enable_user';
    public const ACTION_RENAME_GROUP = 'rename';
    public const ACTION_CREATE_GROUP = 'create';
    public const ACTION_LIST_GROUPS = 'list';

    private Group $group;

    /**
     * Action that client performs.
     */
    private string $action;

    public function __construct(Group $group, string $action)
    {
        if (!$this->isActionValid($action)) {
            throw new InvalidArgumentException('Action argument provided to construct method is invalid.');
        }

        $this->group = $group;
        $this->action = $action;
    }

    public function buildApiUrl(): string
    {
        if ($this->action === self::ACTION_CREATE_GROUP) {
            return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/groups.json';
        }

        if ($this->action == self::ACTION_LIST_GROUPS) {
            return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/groups.json?token='.$this->group->getApplication()->getToken();
        }
        
        if ($this->action === self::ACTION_RETRIEVE_GROUP) {
            return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/groups/'.$this->group->getKey().'.json?token='.$this->group->getApplication()->getToken();
        }

        return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/groups/'.$this->group->getKey().'/'.$this->action.'.json?token='.$this->group->getApplication()->getToken();
    }

    public function buildCurlPostFields(?Recipient $recipient = null): array
    {
        $curlPostFields = [
            'token' => $this->group->getApplication()->getToken(),
        ];

        if (
            $this->action === self::ACTION_ADD_USER
            || $this->action === self::ACTION_REMOVE_USER
            || $this->action === self::ACTION_DISABLE_USER
            || $this->action === self::ACTION_ENABLE_USER
        ) {
            $curlPostFields['user'] = $recipient->getUserKey();
        }

        if ($this->action === self::ACTION_ADD_USER) {
            if (!empty($recipient->getDevice())) {
                $curlPostFields['device'] = $recipient->getDevice()[0];
            }

            if (null !== $recipient->getMemo()) {
                $curlPostFields['memo'] = $recipient->getMemo();
            }
        }

        if ($this->action === self::ACTION_RENAME_GROUP
            || $this->action === self::ACTION_CREATE_GROUP
        ) {
            $curlPostFields['name'] = $this->group->getName();
        }

        return $curlPostFields;
    }

    /**
     * Checks if action that was provided into construct is valid.
     */
    private function isActionValid(string $action): bool
    {
        $oClass = new \ReflectionClass(__CLASS__);

        if (\in_array($action, $oClass->getConstants(), true)) {
            return true;
        }

        return false;
    }
}
