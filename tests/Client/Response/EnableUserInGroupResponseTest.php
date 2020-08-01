<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Response;

use Serhiy\Pushover\Client\Response\EnableUserInGroupResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Serhiy Lunak
 */
class EnableUserInGroupResponseTest extends TestCase
{
    public function testCenBeCreated()
    {
        $successfulCurlResponse = '{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new EnableUserInGroupResponse($successfulCurlResponse);

        $this->assertInstanceOf(EnableUserInGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"user":"invalid","errors":["user is not a member of this group"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new EnableUserInGroupResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(EnableUserInGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());
        $this->assertEquals(array(0 => "user is not a member of this group"), $response->getErrors());
    }
}
