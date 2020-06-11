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
use Serhiy\Pushover\Api\Message\Recipient;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class RecipientTest extends TestCase
{
    public function testCanBeCreatedFromValidUserKey(): Recipient
    {
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG");

        $this->assertInstanceOf(Recipient::class, $recipient);

        return $recipient;
    }

    public function testCannotBeCreatedFromInvalidUserKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Recipient("this-is-invalid-user-key");
    }

    public function testCannotBeCreatedFromShortUserKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Recipient("user-key");
    }

    /**
     * @depends testCanBeCreatedFromValidUserKey
     * @param Recipient $recipient
     */
    public function testAddDevice(Recipient $recipient): void
    {
        $recipient->addDevice('iphone-os');

        $this->assertSame('iphone-os', $recipient->getDeviceListCommaSeparated());
    }

    /**
     * @depends testCanBeCreatedFromValidUserKey
     * @param Recipient $recipient
     */
    public function testAddDeviceWithInvalidName(Recipient $recipient): void
    {
        $this->expectException(InvalidArgumentException::class);
        $recipient->addDevice('iphone+os');
    }

    /**
     * @depends testCanBeCreatedFromValidUserKey
     * @param Recipient $recipient
     */
    public function testAddDeviceWithLongName(Recipient $recipient): void
    {
        $this->expectException(InvalidArgumentException::class);
        $recipient->addDevice('this-is-name-of-the-device-with-a-name-more-than-25-characters');
    }

    public function testGetDeviceListCommaSeparated(): void
    {
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG");
        $recipient->addDevice('iphone');
        $recipient->addDevice('android');

        $this->assertSame('iphone,android', $recipient->getDeviceListCommaSeparated());
    }
}
