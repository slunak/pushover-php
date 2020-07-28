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

use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Recipient;

class RetrieveGroupResponseTest extends TestCase
{
    /**
     * @return RetrieveGroupResponse
     */
    public function testCanBeCreated(): RetrieveGroupResponse
    {
        $curlResponse = '{"name":"Test Group","users":[{"user":"uQiRzpo4DXghDmr9QzzfQu27cmVRsG","device":"iphone","memo":"This is a test memo","disabled":false}],"status":1,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new RetrieveGroupResponse($curlResponse);

        $this->assertInstanceOf(RetrieveGroupResponse::class, $response);

        return $response;
    }

    /**
     * @depends testCanBeCreated
     * @param RetrieveGroupResponse $response
     */
    public function testGetName(RetrieveGroupResponse $response)
    {
        $this->assertEquals("Test Group", $response->getName());
    }

    /**
     * @depends testCanBeCreated
     * @param RetrieveGroupResponse $response
     */
    public function testGetUsers(RetrieveGroupResponse $response)
    {
        $recipient = $response->getUsers()[0];

        $this->assertInstanceOf(Recipient::class, $recipient);
        $this->assertEquals("uQiRzpo4DXghDmr9QzzfQu27cmVRsG", $recipient->getUserKey());
        $this->assertFalse($recipient->isDisabled());
        $this->assertEquals("This is a test memo", $recipient->getMemo());
        $this->assertEquals(array("iphone"), $recipient->getDevice());
    }
}
