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

namespace Serhiy\Pushover;

use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * Notification recipient.
 *
 * You'll need the user key and optional device name for each user to which you are pushing notifications.
 * Instead of a user key, a user may supply a group key. When sending notifications to a group key,
 * all active users listed in the group will have the notification delivered to them and the response will look the same.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 *
 * @final since 1.7.0, real final in 2.0
 */
class Recipient
{
    /**
     * Device name.
     * Your user's device name to send the message directly to that device,
     * rather than all of the user's devices (multiple devices may be separated by a comma).
     *
     * @var array<string>
     */
    private array $devices = [];

    /**
     * Used only when sending messages to a Group. If user is disabled in a group, they won't receive messages.
     * However, if sent to the user directly, they will receive messages.
     */
    private bool $isDisabled = false;

    /**
     * Used when managing users in a Group.
     * A free-text memo used to associate data with the user such as their name or e-mail address,
     * viewable through the API and the groups editor on our website (limited to 200 characters).
     */
    private ?string $memo = null;

    /**
     * @param string $userKey User/group key.
     *                        (required) - the user/group key (not e-mail address) of your user (or you),
     *                        viewable when logged into our dashboard (often referred to as USER_KEY in our documentation and code examples).
     */
    public function __construct(
        private readonly string $userKey,
    ) {
        if (1 !== preg_match('/^[a-zA-Z0-9]{30}$/', $userKey)) {
            throw new InvalidArgumentException(sprintf('User and group identifiers are 30 characters long, case-sensitive, and may contain the character set [A-Za-z0-9]. "%s" given with "%s" characters.', $userKey, \strlen($userKey)));
        }
    }

    public function getUserKey(): string
    {
        return $this->userKey;
    }

    /**
     * @return array<string>
     */
    public function getDevice(): array
    {
        trigger_deprecation('serhiy/pushover', '1.7.0', 'Method %s() is deprecated and will be removed in 2.0. Use %s() instead.', __METHOD__, 'getDevices()');

        return $this->getDevices();
    }

    /**
     * @return array<string>
     */
    public function getDevices(): array
    {
        return $this->devices;
    }

    /**
     * Adds device to the devices list / array.
     */
    public function addDevice(string $device): void
    {
        if (1 !== preg_match('/^[a-zA-Z0-9_-]{1,25}$/', $device)) {
            throw new InvalidArgumentException(sprintf('Device names are optional, may be up to 25 characters long, and will contain the character set [A-Za-z0-9_-]. "%s" given with "%s" characters."', $device, \strlen($device)));
        }

        if (!\in_array($device, $this->devices, true)) {
            $this->devices[] = $device;
        }
    }

    /**
     * Converts devices array to comma separated list and returns it.
     */
    public function getDeviceListCommaSeparated(): string
    {
        trigger_deprecation('serhiy/pushover', '1.7.0', 'Method %s() is deprecated and will be removed in 2.0. Use %s() instead.', __METHOD__, 'getDevicesCommaSeparated()');

        return $this->getDevicesCommaSeparated();
    }

    public function getDevicesCommaSeparated(): string
    {
        return implode(',', $this->devices);
    }

    public function isDisabled(): bool
    {
        return $this->isDisabled;
    }

    public function setIsDisabled(bool $isDisabled): void
    {
        $this->isDisabled = $isDisabled;
    }

    public function getMemo(): ?string
    {
        return $this->memo;
    }

    public function setMemo(?string $memo): void
    {
        if (\is_string($memo) && $length = \strlen($memo) > 200) {
            throw new InvalidArgumentException(sprintf('Memo contained %s characters. Memos are limited to 200 characters.', $length));
        }

        $this->memo = $memo;
    }
}
