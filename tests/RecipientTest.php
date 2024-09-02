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

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class RecipientTest extends TestCase
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

    public function testCannotBeConstructed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Recipient('Lorem ipsum dolor sit amet');
    }

    #[Depends('testCanBeConstructed')]
    public function testGetUserKey(Recipient $recipient): void
    {
        $this->assertSame('aaaa1111AAAA1111bbbb2222BBBB22', $recipient->getUserKey());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetDevice(Recipient $recipient): void
    {
        $this->assertSame(
            [
                'test-device-1',
                'test-device-2',
            ],
            $recipient->getDevice(),
        );
    }

    #[Depends('testCanBeConstructed')]
    public function testGetDeviceListCommaSeparated(Recipient $recipient): void
    {
        $this->assertSame('test-device-1,test-device-2', $recipient->getDeviceListCommaSeparated());
    }

    #[Depends('testCanBeConstructed')]
    public function testIsDisabled(Recipient $recipient): void
    {
        $this->assertFalse($recipient->isDisabled());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetMemo(Recipient $recipient): void
    {
        $this->assertSame('This is test memo', $recipient->getMemo());
    }

    #[Depends('testCanBeConstructed')]
    public function testSetIsDisabled(Recipient $recipient): void
    {
        $recipient->setIsDisabled(true);
        $this->assertTrue($recipient->isDisabled());
    }

    #[Depends('testCanBeConstructed')]
    public function testSetMemo(Recipient $recipient): void
    {
        $this->expectException(InvalidArgumentException::class);
        $recipient->setMemo('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
    }

    #[Depends('testCanBeConstructed')]
    public function testAddDevice(Recipient $recipient): void
    {
        $this->expectException(InvalidArgumentException::class);
        $recipient->addDevice('Lorem-ipsum-dolor-sit-amet');
    }
}
