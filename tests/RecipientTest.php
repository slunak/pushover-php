<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Serhiy\Pushover\Recipient;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class RecipientTest extends TestCase
{
    /**
     * @return Recipient
     */
    public function testCanBeCreated(): Recipient
    {
        $recipient = new Recipient("aaaa1111AAAA1111bbbb2222BBBB22");
        $recipient->setIsDisabled(false);
        $recipient->addDevice("test-device-1");
        $recipient->addDevice("test-device-2");
        $recipient->setMemo("This is test memo");

        $this->assertInstanceOf(Recipient::class, $recipient);

        return $recipient;
    }

    public function testCannotBeCreated()
    {
        $this->expectException(InvalidArgumentException::class);
        new Recipient("Lorem ipsum dolor sit amet");
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testGetUserKey(Recipient $recipient)
    {
        $this->assertEquals("aaaa1111AAAA1111bbbb2222BBBB22", $recipient->getUserKey());
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testGetDevice(Recipient $recipient)
    {
        $this->assertEquals(
            array(
                "test-device-1",
                "test-device-2",
            ),
            $recipient->getDevice()
        );
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testGetDeviceListCommaSeparated(Recipient $recipient)
    {
        $this->assertEquals("test-device-1,test-device-2", $recipient->getDeviceListCommaSeparated());
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testIsDisabled(Recipient $recipient)
    {
        $this->assertFalse($recipient->isDisabled());
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testGetMemo(Recipient $recipient)
    {
        $this->assertEquals("This is test memo", $recipient->getMemo());
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testSetIsDisabled(Recipient $recipient)
    {
        $recipient->setIsDisabled(true);
        $this->assertTrue($recipient->isDisabled());
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testSetMemo(Recipient $recipient)
    {
        $this->expectException(InvalidArgumentException::class);
        $recipient->setMemo("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
    }

    /**
     * @depends testCanBeCreated
     * @param Recipient $recipient
     */
    public function testAddDevice(Recipient $recipient)
    {
        $this->expectException(InvalidArgumentException::class);
        $recipient->addDevice("Lorem-ipsum-dolor-sit-amet");
    }
}
