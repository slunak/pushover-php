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
use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;
use Serhiy\Pushover\Recipient;

final class RetrieveGroupResponseTest extends TestCase
{
    public function testSuccessfulResponse(): RetrieveGroupResponse
    {
        $response = new RetrieveGroupResponse('{"name":"Test Group","users":[{"user":"aaaa1111AAAA1111bbbb2222BBBB22","device":"test-device-1","memo":"This is a test memo","disabled":false}],"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(RetrieveGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    public function testUnsuccessfulResponse(): void
    {
        $response = new RetrieveGroupResponse('{"group":"not found","errors":["group not found or you are not authorized to edit it"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(RetrieveGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'group not found or you are not authorized to edit it'], $response->getErrors());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetName(RetrieveGroupResponse $response): void
    {
        $this->assertSame('Test Group', $response->getName());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetUsers(RetrieveGroupResponse $response): void
    {
        $recipient = $response->getUsers()[0];

        $this->assertInstanceOf(Recipient::class, $recipient);
        $this->assertSame('aaaa1111AAAA1111bbbb2222BBBB22', $recipient->getUserKey());
        $this->assertFalse($recipient->isDisabled());
        $this->assertSame('This is a test memo', $recipient->getMemo());
        $this->assertSame(['test-device-1'], $recipient->getDevices());
    }
}
