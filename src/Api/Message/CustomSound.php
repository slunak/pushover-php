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
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class CustomSound
{
    /**
     * Custom Sound Notification
     * Admins can now upload custom sounds through Pushover website and have them played on devices
     * without having to copy sound files to each device. Can only contain letters, numbers, underscores, and dashes,
     * and is limited to 20 characters, such as "warning", "door_open", or "long_siren2". It cannot match the name
     * of any built-in sound and will be specified as the sound parameter through our API when requesting this sound.
     */
    private string $customSound;

    public function __construct(string $customSound)
    {
        $this->setCustomSound($customSound);
    }

    public function getCustomSound(): string
    {
        return $this->customSound;
    }

    public function setCustomSound(string $customSound): void
    {
        if (\in_array($customSound, Sound::getAvailableSounds(), true)) {
            throw new InvalidArgumentException(sprintf('Sound "%s" is not a valid custom sound because it matches the name of a built-in sound.', $customSound));
        }

        if (1 !== preg_match('/^[a-zA-Z0-9_-]{1,20}$/', $customSound)) {
            throw new InvalidArgumentException(sprintf('Sound "%s" is not a valid custom sound. Custom sound name can only contain letters, numbers, underscores, and dashes, and is limited to 20 characters, such as "warning", "door_open", or "long_siren2".', $customSound));
        }

        $this->customSound = $customSound;
    }
}
