<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiClient\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\ApiClient\Message\MessageClient;
use Serhiy\Pushover\ApiClient\Message\MessageResponse;
use Serhiy\Pushover\ApiClient\Request;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class MessageClientTest extends TestCase
{
    public function testBuildApiUrl()
    {
        $client = new MessageClient();

        $this->assertEquals("https://api.pushover.net/1/messages.json", $client->buildApiUrl());
    }

    public function testSend()
    {
        $application = new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $message = new Message("This is a test message", "This is a title of the message");
        $notification = new Notification($application, $recipient, $message);

        $client = new MessageClient();
        $request = new Request($client->buildApiUrl(), $client->buildCurlPostFields($notification));

        $response = $client->send($request);

        $this->assertInstanceOf(MessageResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInstanceOf(Request::class, $response->getRequest());

        return $notification;
    }

    /**
     * @depends testSend
     * @param Notification $notification
     */
    public function testBuildCurlPostFields(Notification $notification)
    {
        $client = new MessageClient();
        $curlPostFields = $client->buildCurlPostFields($notification);

        $this->assertIsArray($curlPostFields);
        $this->assertArrayHasKey("message", $curlPostFields);
        $this->assertEquals("This is a test message", $curlPostFields["message"]);
    }
}
