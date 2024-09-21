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

namespace Client;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\MessageClient;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class MessageClientTest extends TestCase
{
    public function testBuildApiUrl(): void
    {
        $client = new MessageClient();

        $this->assertSame('https://api.pushover.net/1/messages.json', $client->buildApiUrl());
    }

    public function testBuildCurlPostFields(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $message = new Message('This is a test message', 'This is a title of the message');
        $message->setUrl('https://www.example.com');
        $message->setUrlTitle('Example.com');
        $message->setPriority(new Priority(Priority::EMERGENCY, 30, 300));
        $message->getPriority()->setCallback('https://callback.example.com');
        $message->setIsHtml(true);
        $message->setTtl(60 * 60 * 24);

        $recipient->addDevice('ios');
        $recipient->addDevice('android');

        $notification = new Notification($application, $recipient, $message);
        $notification->setSound(new Sound(Sound::PUSHOVER));

        $client = new MessageClient();
        $curlPostFields = $client->buildCurlPostFields($notification);

        $this->assertIsArray($curlPostFields);
        $this->assertSame('cccc3333CCCC3333dddd4444DDDD44', $curlPostFields['token']);
        $this->assertSame('aaaa1111AAAA1111bbbb2222BBBB22', $curlPostFields['user']);
        $this->assertSame('This is a test message', $curlPostFields['message']);
        $this->assertSame('ios,android', $curlPostFields['device']);
        $this->assertSame('This is a title of the message', $curlPostFields['title']);
        $this->assertSame('https://www.example.com', $curlPostFields['url']);
        $this->assertSame('Example.com', $curlPostFields['url_title']);
        $this->assertSame(2, $curlPostFields['priority']);
        $this->assertSame(30, $curlPostFields['retry']);
        $this->assertSame(300, $curlPostFields['expire']);
        $this->assertSame('https://callback.example.com', $curlPostFields['callback']);
        $this->assertSame(1, $curlPostFields['html']);
        $this->assertSame(86400, $curlPostFields['ttl']);
        $this->assertSame('pushover', $curlPostFields['sound']);
    }
}
