<?php

/*
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
 * @author Serhiy Lunak
 */
class CustomSoundTest extends TestCase
{
    public function testCanBeCreated()
    {
        $this->assertInstanceOf(CustomSound::class, $customSound = new CustomSound("door_open"));

        return $customSound;
    }

    /**
     * @depends testCanBeCreated
     * @param CustomSound $customSound
     */
    public function testGetCustomSound(CustomSound $customSound)
    {
        $this->assertEquals('door_open', $customSound->getCustomSound());
    }

    /**
     * @depends testCanBeCreated
     * @param CustomSound $customSound
     */
    public function testSetCustomSound(CustomSound $customSound)
    {
        $customSound->setCustomSound("warning");

        $this->assertEquals('warning', $customSound->getCustomSound());

        $customSound->setCustomSound("door_open");

        $this->assertEquals('door_open', $customSound->getCustomSound());

        $customSound->setCustomSound("bell-sound");

        $this->assertEquals('bell-sound', $customSound->getCustomSound());
    }

    /**
     * @depends testCanBeCreated
     * @param CustomSound $customSound
     */
    public function testSetExistingCustomSound(CustomSound $customSound)
    {
        $this->expectException(InvalidArgumentException::class);

        $customSound->setCustomSound("echo");
    }

    /**
     * @depends testCanBeCreated
     * @param CustomSound $customSound
     */
    public function testSetInvalidCustomSound(CustomSound $customSound)
    {
        $this->expectException(InvalidArgumentException::class);

        $customSound->setCustomSound("warning+door_open");
    }

    /**
     * @depends testCanBeCreated
     * @param CustomSound $customSound
     */
    public function testSetLongCustomSound(CustomSound $customSound)
    {
        $this->expectException(InvalidArgumentException::class);

        $customSound->setCustomSound("warning_door_open_warning_door_open");
    }
}
