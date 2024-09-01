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

use ReflectionClass;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class SoundTest extends TestCase
{
    public function testCanBeConstructed(): Sound
    {
        $this->assertInstanceOf(Sound::class, $sound = new Sound(Sound::PUSHOVER));

        return $sound;
    }

    #[Depends('testCanBeConstructed')]
    public function testGetSound(Sound $sound): void
    {
        $this->assertSame('pushover', $sound->getSound());
    }

    #[Depends('testCanBeConstructed')]
    public function testAvailableSounds(Sound $sound): void
    {
        $availableSounds = new ReflectionClass(Sound::class);

        $this->assertEquals($availableSounds->getConstants(), $sound->getAvailableSounds());
    }

    #[Depends('testCanBeConstructed')]
    public function testSetSound(Sound $sound): void
    {
        $sound->setSound(Sound::ECHO);

        $this->assertSame('echo', $sound->getSound());

        $this->expectException(InvalidArgumentException::class);

        $sound->setSound('invalid_sound');
    }
}
