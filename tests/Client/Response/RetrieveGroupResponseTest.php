<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Response;

use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Recipient;

class RetrieveGroupResponseTest extends TestCase
{
    public function testCanBeCreated(): RetrieveGroupResponse
    {
        $unSuccessfulCurlResponse = '{"group":"not found","errors":["group not found or you are not authorized to edit it"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new RetrieveGroupResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(RetrieveGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'group not found or you are not authorized to edit it'], $response->getErrors());

        $successfulCurlResponse = '{"name":"Test Group","users":[{"user":"aaaa1111AAAA1111bbbb2222BBBB22","device":"test-device-1","memo":"This is a test memo","disabled":false}],"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new RetrieveGroupResponse($successfulCurlResponse);

        $this->assertInstanceOf(RetrieveGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetName(RetrieveGroupResponse $response): void
    {
        $this->assertEquals('Test Group', $response->getName());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetUsers(RetrieveGroupResponse $response): void
    {
        $recipient = $response->getUsers()[0];

        $this->assertInstanceOf(Recipient::class, $recipient);
        $this->assertEquals('aaaa1111AAAA1111bbbb2222BBBB22', $recipient->getUserKey());
        $this->assertFalse($recipient->isDisabled());
        $this->assertEquals('This is a test memo', $recipient->getMemo());
        $this->assertEquals(['test-device-1'], $recipient->getDevice());
    }
}
