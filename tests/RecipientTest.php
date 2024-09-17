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

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class RecipientTest extends TestCase
{
    public function testCanBeConstructed(): Recipient
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->setIsDisabled(false);
        $recipient->addDevice('test-device-1');
        $recipient->addDevice('test-device-2');
        $recipient->setMemo('This is test memo');

        $this->assertInstanceOf(Recipient::class, $recipient);

        return $recipient;
    }

    public function testCannotBeConstructedWithInvalidUserKey(): void
    {
        $userKey = 'Lorem ipsum dolor sit amet';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'User and group identifiers are 30 characters long, case-sensitive, and may contain the character set [A-Za-z0-9]. "%s" given with "%s" characters.',
            $userKey,
            \strlen($userKey),
        ));
        new Recipient($userKey);
    }

    public function testGetUserKey(): void
    {
        $recipient = new Recipient($userKey = 'aaaa1111AAAA1111bbbb2222BBBB22');

        $this->assertSame($userKey, $recipient->getUserKey());
    }

    /**
     * @group legacy
     */
    public function testGetDevice(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->addDevice('test-device-1');
        $recipient->addDevice('test-device-2');

        $this->assertSame(['test-device-1', 'test-device-2'], $recipient->getDevice());
    }

    public function testGetDevices(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->addDevice('test-device-1');
        $recipient->addDevice('test-device-2');

        $this->assertSame(['test-device-1', 'test-device-2'], $recipient->getDevices());
    }

    /**
     * @group legacy
     */
    public function testGetDeviceListCommaSeparated(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->addDevice('test-device-1');
        $recipient->addDevice('test-device-2');

        $this->assertSame('test-device-1,test-device-2', $recipient->getDeviceListCommaSeparated());
    }

    public function testGetDevicesCommaSeparated(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->addDevice('test-device-1');
        $recipient->addDevice('test-device-2');

        $this->assertSame('test-device-1,test-device-2', $recipient->getDevicesCommaSeparated());
    }

    public function testIsDisabledReturnsFalse(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->setIsDisabled(false);

        $this->assertFalse($recipient->isDisabled());
    }

    public function testIsDisabledReturnsTrue(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->setIsDisabled(true);

        $this->assertTrue($recipient->isDisabled());
    }

    public function testGetMemo(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');
        $recipient->setMemo('This is test memo');

        $this->assertSame('This is test memo', $recipient->getMemo());
    }

    public function testSetMemoThrowsInvalidArgumentExceptionIfMemoIsLongerThan200Characters(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');

        $this->expectException(InvalidArgumentException::class);

        $recipient->setMemo(str_repeat('a', 201));
    }

    public function testAddDeviceThrowsInvalidArgumentExceptionIfDeviceNameIsInvalid(): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22');

        $this->expectException(InvalidArgumentException::class);

        $recipient->addDevice('Lorem-ipsum-dolor-sit-amet');
    }
}
