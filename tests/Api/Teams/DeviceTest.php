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

namespace Api\Teams;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Teams\Device;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class DeviceTest extends TestCase
{
    public function testCanBeConstructed(): Device
    {
        $device = new Device('iphone', 'iOS', '26', true, false);

        $this->assertInstanceOf(Device::class, $device);

        return $device;
    }

    public function testGetName(): void
    {
        $device = new Device('iphone', 'iOS', '26', true, false);

        $this->assertSame('iphone', $device->getName());
    }

    public function testGetOs(): void
    {
        $device = new Device('iphone', 'iOS', '26', true, false);

        $this->assertSame('iOS', $device->getOs());
    }

    public function testGetOsVersion(): void
    {
        $device = new Device('iphone', 'iOS', '26', true, false);

        $this->assertSame('26', $device->getOsVersion());
    }

    public function testIsEnabled(): void
    {
        $device = new Device('iphone', 'iOS', '26', true, false);

        $this->assertTrue($device->isEnabled());
    }

    public function testIsAdministrativelyDisabled(): void
    {
        $device = new Device('iphone', 'iOS', '26', true, false);

        $this->assertFalse($device->isAdministrativelyDisabled());
    }
}
