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
        $successfulCurlResponse = '{"subscribed_user_key":"aaaa1111AAAA1111bbbb2222BBBB22","status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new SubscriptionResponse($successfulCurlResponse);

        $this->assertInstanceOf(SubscriptionResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"subscription":"invalid","errors":["subscription code is invalid"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new SubscriptionResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(SubscriptionResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());
        $this->assertEquals(array(0 => "subscription code is invalid"), $response->getErrors());
    }

    public function testGetSubscribedUserKey()
    {
        $curlResponse = '{"subscribed_user_key":"aaaa1111AAAA1111bbbb2222BBBB22","status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';

        $response = new SubscriptionResponse($curlResponse);

        $this->assertEquals("aaaa1111AAAA1111bbbb2222BBBB22", $response->getSubscribedUserKey());
    }
}
