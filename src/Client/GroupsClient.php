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
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 *
 * @final since 1.7.0, real final in 2.0
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

    /**
     * @param self::ACTION_* $action Action that client performs
     */
    public function __construct(
        private readonly Group $group,
        private readonly string $action,
    ) {
        $this->validateAction($action);
    }

    public function buildApiUrl(): string
    {
        return match ($this->action) {
            self::ACTION_CREATE_GROUP => sprintf('%s/%s/groups.json', Curl::API_BASE_URL, Curl::API_VERSION),
            self::ACTION_LIST_GROUPS => sprintf('%s/%s/groups.json?token=%s', Curl::API_BASE_URL, Curl::API_VERSION, $this->group->getApplication()->getToken()),
            self::ACTION_RETRIEVE_GROUP => sprintf('%s/%s/groups/%s.json?token=%s', Curl::API_BASE_URL, Curl::API_VERSION, $this->group->getKey(), $this->group->getApplication()->getToken()),
            default => sprintf('%s/%s/groups/%s/%s.json?token=%s', Curl::API_BASE_URL, Curl::API_VERSION, $this->group->getKey(), $this->action, $this->group->getApplication()->getToken()),
        };
    }

    /**
     * @return array<string, string>
     */
    public function buildCurlPostFields(?Recipient $recipient = null): array
    {
        $curlPostFields = [
            'token' => $this->group->getApplication()->getToken(),
        ];

        if (\in_array($this->action, [self::ACTION_ADD_USER, self::ACTION_REMOVE_USER, self::ACTION_DISABLE_USER, self::ACTION_ENABLE_USER], true)) {
            if (!$recipient instanceof Recipient) {
                throw new \LogicException('Recipient object must be provided for this action.');
            }

            $curlPostFields['user'] = $recipient->getUserKey();

            if ($this->action === self::ACTION_ADD_USER) {
                if (!empty($recipient->getDevice())) {
                    $curlPostFields['device'] = $recipient->getDevice()[0];
                }

                if (null !== $recipient->getMemo()) {
                    $curlPostFields['memo'] = $recipient->getMemo();
                }
            }
        }

        if (\in_array($this->action, [self::ACTION_RENAME_GROUP, self::ACTION_CREATE_GROUP], true)) {
            $curlPostFields['name'] = $this->group->getName();
        }

        return $curlPostFields;
    }

    /**
     * Checks if action that was provided into construct is valid.
     */
    private function validateAction(string $action): void
    {
        $oClass = new \ReflectionClass(self::class);

        if (!\in_array($action, $oClass->getConstants(), true)) {
            throw new InvalidArgumentException('Action argument provided to construct method is invalid.');
        }
    }
}
