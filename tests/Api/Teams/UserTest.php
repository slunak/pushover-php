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
use Serhiy\Pushover\Api\Teams\User;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class UserTest extends TestCase
{
    public function testCanBeConstructed(): User
    {
        $user = new User('[email protected]');
        $user->setId('da901fb83e6ce7a46a3f7a6de95cef');
        $user->setName('Team User');
        $user->setPassword('secret');
        $user->setInstant(true);
        $user->setIsAdministrator(true);
        $user->setGroup('Operations');
        $user->addDevice(new Device('iphone', 'iOS', '26', true, false));

        $this->assertInstanceOf(User::class, $user);

        return $user;
    }

    public function testGetEmail(): void
    {
        $user = new User('[email protected]');

        $this->assertSame('[email protected]', $user->getEmail());
    }

    public function testGetId(): void
    {
        $user = new User('[email protected]');
        $user->setId('da901fb83e6ce7a46a3f7a6de95cef');

        $this->assertSame('da901fb83e6ce7a46a3f7a6de95cef', $user->getId());
    }

    public function testGetName(): void
    {
        $user = new User('[email protected]');
        $user->setName('Team User');

        $this->assertSame('Team User', $user->getName());
    }

    public function testGetPassword(): void
    {
        $user = new User('[email protected]');
        $user->setPassword('secret');

        $this->assertSame('secret', $user->getPassword());
    }

    public function testIsInstant(): void
    {
        $user = new User('[email protected]');
        $user->setInstant(true);

        $this->assertTrue($user->isInstant());
    }

    public function testIsAdministrator(): void
    {
        $user = new User('[email protected]');
        $user->setIsAdministrator(true);

        $this->assertTrue($user->isAdministrator());
    }

    public function testGetGroup(): void
    {
        $user = new User('[email protected]');
        $user->setGroup('Operations');

        $this->assertSame('Operations', $user->getGroup());
    }

    public function testGetDevices(): void
    {
        $user = new User('[email protected]');
        $device = new Device('iphone', 'iOS', '26', true, false);
        $user->addDevice($device);

        $this->assertSame([$device], $user->getDevices());
    }
}
