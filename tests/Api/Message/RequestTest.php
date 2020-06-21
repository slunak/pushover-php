<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Application;
use Serhiy\Pushover\Api\Message\Attachment;
use Serhiy\Pushover\Api\Message\Client;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Recipient;
use Serhiy\Pushover\Api\Message\Request;
use Serhiy\Pushover\Exception\LogicException;

/**
 * @author Serhiy Lunak
 */
class RequestTest extends TestCase
{
    /**
     * @return Request
     */
    public function testCanBeCrated()
    {
        $request = new Request(Client::API_BASE_URL, Client::API_VERSION, Client::API_PATH);

        $this->assertInstanceOf(Request::class, $request);

        return $request;
    }

    /**
     * @depends testCanBeCrated
     * @param Request $request
     */
    public function testGetFullUrl(Request $request)
    {
        $this->assertEquals(Client::API_BASE_URL.'/'.Client::API_VERSION.'/'.Client::API_PATH, $request->getFullUrl());
    }

    /**
     * @depends testCanBeCrated
     * @param Request $request
     * @return Request
     */
    public function testNotification(Request $request)
    {
        $application = new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $message = new Message("This is a test message", "This is a title of the message");
        $notification = new Notification($application, $recipient, $message);

        $request->setNotification($notification);

        $this->assertInstanceOf(Notification::class, $request->getNotification());
        $this->assertEquals("azGDORePK8gMaC0QOYAMyEEuzJnyUi", $request->getNotification()->getApplication()->getToken());
        $this->assertEquals("uQiRzpo4DXghDmr9QzzfQu27cmVRsG", $request->getNotification()->getRecipient()->getUserKey());
        $this->assertEquals("This is a test message", $request->getNotification()->getMessage()->getMessage());
        $this->assertEquals("This is a title of the message", $request->getNotification()->getMessage()->getTitle());

        return $request;
    }

    /**
     * @depends testNotification
     * @param Request $request
     */
    public function testBuildCurlPostFields(Request $request)
    {
        $request->setCurlPostFields($request->getNotification());
        $curlPostFields = $request->getCurlPostFields();

        $this->assertIsArray($curlPostFields);
        $this->assertEquals("azGDORePK8gMaC0QOYAMyEEuzJnyUi", $curlPostFields["token"]);
        $this->assertEquals("uQiRzpo4DXghDmr9QzzfQu27cmVRsG", $curlPostFields["user"]);
        $this->assertEquals("This is a test message", $curlPostFields["message"]);
        $this->assertEquals("This is a title of the message", $curlPostFields["title"]);
    }

    /**
     * Necessary to test logic exception when file does not exist or is not readable.
     *
     * @depends testNotification
     * @param Request $request
     */
    public function testAttachment(Request $request)
    {
        $notification = $request->getNotification();
        $notification->setAttachment(new Attachment("/path/to/file.jpg", Attachment::MIME_TYPE_JPEG));

        $this->expectException(LogicException::class);
        $request->setCurlPostFields($notification);
    }
}
