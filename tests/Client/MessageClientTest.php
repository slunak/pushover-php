<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Client\MessageClient;
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

    public function testBuildCurlPostFields()
    {
        $application = new Application("cccc3333CCCC3333dddd4444DDDD44"); // using dummy token
        $recipient = new Recipient("aaaa1111AAAA1111bbbb2222BBBB22"); // using dummy user key
        $message = new Message("This is a test message", "This is a title of the message");
        $message->setUrl("https://www.example.com");
        $message->setUrlTitle("Example.com");
        $message->setPriority(new Priority(Priority::EMERGENCY, 30, 300));
        $message->getPriority()->setCallback("https://callback.example.com");
        $message->setIsHtml(true);
        $message->setTtl(60 * 60 * 24);

        $recipient->addDevice("ios");
        $recipient->addDevice("android");

        $notification = new Notification($application, $recipient, $message);
        $notification->setSound(new Sound(Sound::PUSHOVER));

        $client = new MessageClient();
        $curlPostFields = $client->buildCurlPostFields($notification);

        $this->assertIsArray($curlPostFields);
        $this->assertEquals("cccc3333CCCC3333dddd4444DDDD44", $curlPostFields['token']);
        $this->assertEquals("aaaa1111AAAA1111bbbb2222BBBB22", $curlPostFields['user']);
        $this->assertEquals("This is a test message", $curlPostFields['message']);
        $this->assertEquals("ios,android", $curlPostFields['device']);
        $this->assertEquals("This is a title of the message", $curlPostFields['title']);
        $this->assertEquals("https://www.example.com", $curlPostFields['url']);
        $this->assertEquals("Example.com", $curlPostFields['url_title']);
        $this->assertEquals("2", $curlPostFields['priority']);
        $this->assertEquals("30", $curlPostFields['retry']);
        $this->assertEquals("300", $curlPostFields['expire']);
        $this->assertEquals("https://callback.example.com", $curlPostFields['callback']);
        $this->assertEquals("1", $curlPostFields['html']);
        $this->assertEquals("86400", $curlPostFields['ttl']);
        $this->assertEquals("pushover", $curlPostFields['sound']);
    }
}
