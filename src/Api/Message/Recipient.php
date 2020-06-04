<?php

/*
 * This file is part of the Pushover package.
 *
 *  (c) Serhiy Lunak <https://github.com/slunak>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Message;

use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * Notification recipient.
 *
 * You'll need the user key and optional device name for each user to which you are pushing notifications.
 * Instead of a user key, a user may supply a group key. When sending notifications to a group key,
 * all active users listed in the group will have the notification delivered to them and the response will look the same.
 *
 * @author Serhiy Lunak
 */
class Recipient
{
    /**
     * User/group key.
     * (required) - the user/group key (not e-mail address) of your user (or you),
     * viewable when logged into our dashboard (often referred to as USER_KEY in our documentation and code examples).
     *
     * @var string
     */
    private $userKey;

    /**
     * Device name.
     * Your user's device name to send the message directly to that device,
     * rather than all of the user's devices (multiple devices may be separated by a comma).
     *
     * @var array
     */
    private $device;

    public function __construct(string $userKey)
    {
        if (1 != preg_match("/^[a-zA-Z0-9]+$/", $userKey)) {
            throw new InvalidArgumentException(sprintf('User and group identifiers are 30 characters long, case-sensitive, and may contain the character set [A-Za-z0-9]. "%s" given."', $userKey));
        }

        if (30 != strlen($userKey)) {
            throw new InvalidArgumentException(sprintf('User and group identifiers are 30 characters long. "%s" characters identifier provided.', strlen($userKey)));
        }

        $this->userKey = $userKey;

        $this->device = array();
    }

    /**
     * @return string
     */
    public function getUserKey(): string
    {
        return $this->userKey;
    }

    /**
     * @return array
     */
    public function getDevice(): array
    {
        return $this->device;
    }

    /**
     * Adds device to the device list / array.
     *
     * @param string $device
     */
    public function addDevice($device): void
    {
        if (1 != preg_match("/^[a-zA-Z0-9_-]{1,25}$/", $device)) {
            throw new InvalidArgumentException(sprintf('Device names are optional, may be up to 25 characters long, and will contain the character set [A-Za-z0-9_-]. "%s" given with "%s" characters."', $device, strlen($device)));
        }

        if (!in_array($device, $this->device)) {
            array_push($this->device, $device);
        }
    }

    /**
     * Converts device array to comma separated list and returns it.
     *
     * @return string
     */
    public function getDeviceListCommaSeparated(): string
    {
        return implode(',', $this->device);
    }
}
