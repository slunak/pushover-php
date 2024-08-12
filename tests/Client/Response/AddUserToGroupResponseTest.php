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

use Serhiy\Pushover\Client\Response\AddUserToGroupResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Serhiy Lunak
 */
class AddUserToGroupResponseTest extends TestCase
{
    public function testCenBeCreated()
    {
        $successfulCurlResponse = '{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new AddUserToGroupResponse($successfulCurlResponse);

        $this->assertInstanceOf(AddUserToGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"user":"invalid","errors":["user is already a member of this group"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new AddUserToGroupResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(AddUserToGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'user is already a member of this group'], $response->getErrors());
    }
}
