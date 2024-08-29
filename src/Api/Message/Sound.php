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

namespace Serhiy\Pushover\Api\Message;

use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class Sound
{
    /**
     * Pushover (default).
     */
    public const PUSHOVER = 'pushover';

    /**
     * Bike.
     */
    public const BIKE = 'bike';

    /**
     * Bugle.
     */
    public const BUGLE = 'bugle';

    /**
     * Cash Register.
     */
    public const CASHREGISTER = 'cashregister';

    /**
     * Classical.
     */
    public const CLASSICAL = 'classical';

    /**
     * Cosmic.
     */
    public const COSMIC = 'cosmic';

    /**
     * Falling.
     */
    public const FALLING = 'falling';

    /**
     * Gamelan.
     */
    public const GAMELAN = 'gamelan';

    /**
     * Incoming.
     */
    public const INCOMING = 'incoming';

    /**
     * Intermission.
     */
    public const INTERMISSION = 'intermission';

    /**
     * Magic.
     */
    public const MAGIC = 'magic';

    /**
     * Mechanical.
     */
    public const MECHANICAL = 'mechanical';

    /**
     * Piano Bar.
     */
    public const PIANOBAR = 'pianobar';

    /**
     * Siren.
     */
    public const SIREN = 'siren';

    /**
     * Space Alarm.
     */
    public const SPACEALARM = 'spacealarm';

    /**
     * Tug Boat.
     */
    public const TUGBOAT = 'tugboat';

    /**
     * Alien Alarm (long).
     */
    public const ALIEN = 'alien';

    /**
     * Climb (long).
     */
    public const CLIMB = 'climb';

    /**
     * Persistent (long).
     */
    public const PERSISTENT = 'persistent';

    /**
     * Pushover Echo (long).
     */
    public const ECHO = 'echo';

    /**
     * Up Down (long).
     */
    public const UPDOWN = 'updown';

    /**
     * Vibrate Only.
     */
    public const VIBRATE = 'vibrate';

    /**
     * None (silent).
     */
    public const NONE = 'none';

    /**
     * @param string $sound Users can choose from 22 different default sounds to play when receiving notifications, rather than our standard Pushover tone.
     *                      Applications can override a user's default tone choice on a per-notification basis.
     */
    public function __construct(
        private string $sound,
    ) {
        $this->setSound($sound);
    }

    /**
     * Generates array with all available sounds. Sounds are taken from the constants of this class.
     *
     * @return array<string>
     */
    public static function getAvailableSounds(): array
    {
        $oClass = new \ReflectionClass(self::class);

        return $oClass->getConstants();
    }

    public function getSound(): string
    {
        return $this->sound;
    }

    public function setSound(string $sound): void
    {
        if (!\in_array($sound, static::getAvailableSounds(), true)) {
            throw new InvalidArgumentException(sprintf('Sound "%s" is not available.', $sound));
        }

        $this->sound = $sound;
    }
}
