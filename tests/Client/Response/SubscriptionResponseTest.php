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

use Serhiy\Pushover\Client\Response\SubscriptionResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Serhiy Lunak
 */
class SubscriptionResponseTest extends TestCase
{
    public function testCanBeCreated()
    {
        $successfulCurlResponse = '{"subscribed_user_key":"uQiRzpo4DXghDmr9QzzfQu27cmVRsG","status":1,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new SubscriptionResponse($successfulCurlResponse);

        $this->assertInstanceOf(SubscriptionResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("6g890a90-7943-4at2-b739-4aubi545b508", $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"subscription":"invalid","errors":["subscription code is invalid"],"status":0,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new SubscriptionResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(SubscriptionResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals("6g890a90-7943-4at2-b739-4aubi545b508", $response->getRequestToken());
        $this->assertEquals(array(0 => "subscription code is invalid"), $response->getErrors());
    }

    public function testGetSubscribedUserKey()
    {
        $curlResponse = '{"subscribed_user_key":"uQiRzpo4DXghDmr9QzzfQu27cmVRsG","status":1,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';

        $response = new SubscriptionResponse($curlResponse);

        $this->assertEquals("uQiRzpo4DXghDmr9QzzfQu27cmVRsG", $response->getSubscribedUserKey());
    }
}
