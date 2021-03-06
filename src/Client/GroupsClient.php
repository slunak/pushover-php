<?php

/*
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
    const ACTION_RETRIEVE_GROUP = "retrieve_group";
    const ACTION_ADD_USER = "add_user";
    const ACTION_REMOVE_USER = "delete_user";
    const ACTION_DISABLE_USER = "disable_user";
    const ACTION_ENABLE_USER = "enable_user";
    const ACTION_RENAME_GROUP = "rename";

    /**
     * @var Group
     */
    private $group;

    /**
     * @var string Action that client performs.
     */
    private $action;

    public function __construct(Group $group, string $action)
    {
        if (!$this->isActionValid($action)) {
            throw new InvalidArgumentException("Action argument provided to construct method is invalid.");
        }

        $this->group = $group;
        $this->action = $action;
    }

    /**
     * @inheritDoc
     */
    public function buildApiUrl()
    {
        if ($this->action == self::ACTION_RETRIEVE_GROUP) {
            return Curl::API_BASE_URL."/".Curl::API_VERSION."/groups/".$this->group->getKey().".json?token=".$this->group->getApplication()->getToken();
        }

        return Curl::API_BASE_URL."/".Curl::API_VERSION."/groups/".$this->group->getKey()."/".$this->action.".json?token=".$this->group->getApplication()->getToken();
    }

    /**
     * @param Recipient|null $recipient
     * @return array
     */
    public function buildCurlPostFields(Recipient $recipient = null): array
    {
        $curlPostFields = array(
            "token" => $this->group->getApplication()->getToken(),
        );

        if (
            $this->action == self::ACTION_ADD_USER ||
            $this->action == self::ACTION_REMOVE_USER ||
            $this->action == self::ACTION_DISABLE_USER ||
            $this->action == self::ACTION_ENABLE_USER
        ) {
            $curlPostFields["user"] = $recipient->getUserKey();
        }

        if ($this->action == self::ACTION_ADD_USER) {
            if (!empty($recipient->getDevice())) {
                $curlPostFields["device"] = $recipient->getDevice()[0];
            }

            if (null != $recipient->getMemo()) {
                $curlPostFields["memo"] = $recipient->getMemo();
            }
        }

        if ($this->action == self::ACTION_RENAME_GROUP) {
            $curlPostFields["name"] = $this->group->getName();
        }

        return $curlPostFields;
    }

    /**
     * Checks if action that was provided into construct is valid.
     *
     * @param string $action
     * @return bool
     */
    private function isActionValid(string $action): bool
    {
        $oClass = new \ReflectionClass(__CLASS__);

        if (in_array($action, $oClass->getConstants())) {
            return true;
        }

        return false;
    }
}
