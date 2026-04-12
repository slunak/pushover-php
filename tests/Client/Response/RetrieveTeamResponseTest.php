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

namespace Client\Response;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Teams\Device;
use Serhiy\Pushover\Api\Teams\User;
use Serhiy\Pushover\Client\Response\RetrieveTeamResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class RetrieveTeamResponseTest extends TestCase
{
    public function testSuccessfulResponse(): RetrieveTeamResponse
    {
        $response = new RetrieveTeamResponse('{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc","name":"Operations","users":[{"id":"da901fb83e6ce7a46a3f7a6de95cef","name":"Team User","email":"[email protected]","administrator":true,"devices":[{"name":"iphone","os":"iOS","os_version":"26","enabled":true,"administratively_disabled":false}]}]}');

        $this->assertInstanceOf(RetrieveTeamResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    public function testUnsuccessfulResponse(): void
    {
        $response = new RetrieveTeamResponse('{"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc","errors":["team token is invalid"]}');

        $this->assertInstanceOf(RetrieveTeamResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'team token is invalid'], $response->getErrors());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetName(RetrieveTeamResponse $response): void
    {
        $this->assertSame('Operations', $response->getName());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetUsers(RetrieveTeamResponse $response): void
    {
        $user = $response->getUsers()[0];

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('da901fb83e6ce7a46a3f7a6de95cef', $user->getId());
        $this->assertSame('Team User', $user->getName());
        $this->assertSame('[email protected]', $user->getEmail());
        $this->assertTrue($user->isAdministrator());

        $device = $user->getDevices()[0];

        $this->assertInstanceOf(Device::class, $device);
        $this->assertSame('iphone', $device->getName());
        $this->assertSame('iOS', $device->getOs());
        $this->assertSame('26', $device->getOsVersion());
        $this->assertTrue($device->isEnabled());
        $this->assertFalse($device->isAdministrativelyDisabled());
    }
}
