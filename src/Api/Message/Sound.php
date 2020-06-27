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

/**
 * @author Serhiy Lunak
 */
class Sound
{
    /** Pushover (default) */
    const PUSHOVER = 'pushover';

    /** Bike */
    const BIKE = 'bike';

    /** Bugle  */
    const BUGLE = 'bugle';

    /** Cash Register */
    const CASHREGISTER = 'cashregister';

    /** Classical */
    const CLASSICAL = 'classical';

    /** Cosmic */
    const COSMIC = 'cosmic';

    /** Falling */
    const FALLING = 'falling';

    /** Gamelan  */
    const GAMELAN = 'gamelan';

    /** Incoming  */
    const INCOMING = 'incoming';

    /** Intermission  */
    const INTERMISSION = 'intermission';

    /** Magic */
    const MAGIC = 'magic';

    /** Mechanical  */
    const MECHANICAL = 'mechanical';

    /** Piano Bar  */
    const PIANOBAR = 'pianobar';

    /** Siren */
    const SIREN = 'siren';

    /** Space Alarm  */
    const SPACEALARM = 'spacealarm';

    /** Tug Boat  */
    const TUGBOAT = 'tugboat';

    /** Alien Alarm (long)  */
    const ALIEN = 'alien';

    /** Climb (long) */
    const CLIMB = 'climb';

    /** Persistent (long)  */
    const PERSISTENT = 'persistent';

    /** Pushover Echo (long) */
    const ECHO = 'echo';

    /** Up Down (long) */
    const UPDOWN = 'updown';

    /** Vibrate Only */
    const VIBRATE = 'vibrate';

    /** None (silent) */
    const NONE = 'none';

    /**
     * Notification Sound
     * Users can choose from 22 different default sounds to play when receiving notifications, rather than our standard Pushover tone.
     * Applications can override a user's default tone choice on a per-notification basis.
     *
     * @var string
     */
    private $sound;

    public function __construct(string $sound)
    {
        $this->setSound($sound);
    }

    /**
     * Generates array with all available sounds. Sounds are taken from the constants of this class.
     *
     * @return array
     */
    static function getAvailableSounds(): array
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    /**
     * @return string
     */
    public function getSound(): string
    {
        return $this->sound;
    }

    /**
     * @param string $sound
     */
    public function setSound(string $sound): void
    {
        if (!in_array($sound, $this->getAvailableSounds())) {
            throw new InvalidArgumentException(sprintf('Sound "%s" is not available.', $sound));
        }

        $this->sound = $sound;
    }
}
