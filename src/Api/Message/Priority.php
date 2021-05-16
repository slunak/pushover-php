<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Message;

use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Exception\LogicException;

/**
 * Message Priority.
 * By default, messages have normal priority (a priority of 0).
 * Messages may be sent with a different priority that affects how the message is presented to the user.
 * Please use your best judgement when sending messages to other users and specifying a message priority.
 * Specifying a message priority does not affect queueing or routing priority and only affects how device clients display them.
 * See {@link https://pushover.net/api#priority} for more information.
 *
 * @author Serhiy Lunak
 */
class Priority
{
    /**
     * Lowest priority.
     * When the priority parameter is specified with a value of -2,
     * messages will be considered lowest priority and will not generate any notification.
     * On iOS, the application badge number will be increased.
     */
    const LOWEST = -2;

    /**
     * Low priority.
     * Messages with a priority parameter of -1 will be considered low priority and will not generate any sound or vibration,
     * but will still generate a popup/scrolling notification depending on the client operating system.
     * Messages delivered during a user's quiet hours are sent as though they had a priority of (-1).
     */
    const LOW = -1;

    /**
     * Normal Priority.
     * Messages sent without a priority parameter, or sent with the parameter set to 0, will have the default priority.
     * These messages trigger sound, vibration, and display an alert according to the user's device settings.
     * On iOS, the message will display at the top of the screen or as a modal dialog, as well as in the notification center.
     * On Android, the message will scroll at the top of the screen and appear in the notification center.
     * If a user has quiet hours set and your message is received during those times,
     * your message will be delivered as though it had a priority of -1.
     */
    const NORMAL = 0;

    /**
     * High Priority.
     * Messages sent with a priority of 1 are high priority messages that bypass a user's quiet hours.
     * These messages will always play a sound and vibrate (if the user's device is configured to) regardless of the delivery time.
     * High-priority should only be used when necessary and appropriate.
     * High-priority messages are highlighted in red in the device clients.
     */
    const HIGH = 1;

    /**
     * Emergency Priority.
     * Emergency-priority notifications are similar to high-priority notifications,
     * but they are repeated until the notification is acknowledged by the user.
     * These are designed for dispatching and on-call situations where it is critical that a notification be repeatedly shown to the user
     * (or all users of the group that the message was sent to) until it is acknowledged.
     * The first user in a group to acknowledge a message will cancel retries for all other users in the group.
     *
     * To send an emergency-priority notification, the priority parameter must be set to 2
     * and the "retry" and "expire" parameters must be supplied.
     */
    const EMERGENCY = 2;

    /**
     * Priority of the message.
     *
     * @var int
     */
    private $priority;

    /**
     * Specifies how often (in seconds) the Pushover servers will send the same notification to the user.
     * Used only and required with Emergency Priority.
     *
     * @var int|null
     */
    private $retry;

    /**
     * Specifies how many seconds your notification will continue to be retried for (every "retry" seconds).
     * Used only and required with Emergency Priority.
     * @var int|null
     */
    private $expire;

    /**
     * (Optional) may be supplied with a publicly-accessible URL that our servers will send a request to when the user has acknowledged your notification.
     * Used only but not required with Emergency Priority.
     *
     * @var string|null
     */
    private $callback;

    public function __construct(int $priority = self::NORMAL, int $retry = null, int $expire = null)
    {
        if (!(self::LOWEST <= $priority && $priority <= self::EMERGENCY)) {
            throw new InvalidArgumentException(sprintf('Message priority must be within range -2 and 2. "%s" was given.', $priority));
        }

        $this->priority = $priority;

        if ($priority == self::EMERGENCY) {
            if (null === $retry || null === $expire) {
                throw new LogicException('To send an emergency-priority notification, the retry and expire parameters must be supplied. Either of them was not supplied.');
            }

            $this->setRetry($retry);
            $this->setExpire($expire);
        }
    }

    /**
     * Generates array with all available priorities. Priorities are taken from the constants of this class.
     *
     * @return array<string>
     */
    public static function getAvailablePriorities(): array
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return int|null
     */
    public function getRetry(): ?int
    {
        return $this->retry;
    }

    /**
     * @param int|null $retry
     */
    public function setRetry(?int $retry): void
    {
        if ($retry < 30) {
            throw new InvalidArgumentException(sprintf('Retry parameter must have a value of at least 30 seconds between retries. "%s" was given.', $retry));
        }

        $this->retry = $retry;
    }

    /**
     * @return int|null
     */
    public function getExpire(): ?int
    {
        return $this->expire;
    }

    /**
     * @param int|null $expire
     */
    public function setExpire(?int $expire): void
    {
        if ($expire > 10800) {
            throw new InvalidArgumentException(sprintf('Expire parameter must have a maximum value of at most 10800 seconds (3 hours). "%s" was given.', $expire));
        }

        $this->expire = $expire;
    }

    /**
     * @return string|null
     */
    public function getCallback(): ?string
    {
        return $this->callback;
    }

    /**
     * @param string|null $callback
     */
    public function setCallback(?string $callback): void
    {
        $this->callback = $callback;
    }
}
