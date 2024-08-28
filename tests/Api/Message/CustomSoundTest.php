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

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\CustomSound;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class CustomSoundTest extends TestCase
{
    public function testCanBeConstructed(): CustomSound
    {
        $this->assertInstanceOf(CustomSound::class, $customSound = new CustomSound('door_open'));

        return $customSound;
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testGetCustomSound(CustomSound $customSound): void
    {
        $this->assertEquals('door_open', $customSound->getCustomSound());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetCustomSound(CustomSound $customSound): void
    {
        $customSound->setCustomSound('warning');

        $this->assertEquals('warning', $customSound->getCustomSound());

        $customSound->setCustomSound('door_open');

        $this->assertEquals('door_open', $customSound->getCustomSound());

        $customSound->setCustomSound('bell-sound');

        $this->assertEquals('bell-sound', $customSound->getCustomSound());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetExistingCustomSound(CustomSound $customSound): void
    {
        $this->expectException(InvalidArgumentException::class);

        $customSound->setCustomSound('echo');
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetInvalidCustomSound(CustomSound $customSound): void
    {
        $this->expectException(InvalidArgumentException::class);

        $customSound->setCustomSound('warning+door_open');
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetLongCustomSound(CustomSound $customSound): void
    {
        $this->expectException(InvalidArgumentException::class);

        $customSound->setCustomSound('warning_door_open_warning_door_open');
    }
}
