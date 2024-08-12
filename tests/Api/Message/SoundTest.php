<?php

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
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class SoundTest extends TestCase
{
    public function testCanBeCreated()
    {
        $this->assertInstanceOf(Sound::class, $sound = new Sound(Sound::PUSHOVER));

        return $sound;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetSound(Sound $sound)
    {
        $this->assertEquals('pushover', $sound->getSound());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testAvailableSounds(Sound $sound)
    {
        $availableSounds = new \ReflectionClass(Sound::class);

        $this->assertEquals($availableSounds->getConstants(), $sound->getAvailableSounds());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetSound(Sound $sound)
    {
        $sound->setSound(Sound::ECHO);

        $this->assertEquals('echo', $sound->getSound());

        $this->expectException(InvalidArgumentException::class);

        $sound->setSound('invalid_sound');
    }
}
