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
use Serhiy\Pushover\Api\Message\Attachment;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\MessageResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class NotificationTest extends TestCase
{
    public function testCanBeCreated()
    {
        $application = new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key

        $message = new Message("This is a test message", "This is a title of the message");

        $notification = new Notification($application, $recipient, $message);

        $this->assertInstanceOf(Notification::class, $notification);

        return $notification;
    }

    /**
     * @depends testCanBeCreated
     * @param Notification $notification
     */
    public function testNotificationSound(Notification $notification)
    {
        $notification->setSound(new Sound(Sound::PUSHOVER));

        $this->assertEquals('pushover', $notification->getSound()->getSound());
    }

    /**
     * @depends testCanBeCreated
     * @param Notification $notification
     */
    public function testNoSound(Notification $notification)
    {
        $notification->setSound(null);

        $this->assertNull($notification->getSound());
    }

    /**
     * @depends testCanBeCreated
     * @param Notification $notification
     */
    public function testNotificationAttachment(Notification $notification)
    {
        $notification->setAttachment(new Attachment("/path/to/file.jpg", Attachment::MIME_TYPE_JPEG));

        $this->assertEquals('/path/to/file.jpg', $notification->getAttachment()->getFilename());
        $this->assertEquals('image/jpeg', $notification->getAttachment()->getMimeType());
    }

    /**
     * @depends testCanBeCreated
     * @param Notification $notification
     */
    public function testNoAttachment(Notification $notification)
    {
        $notification->setAttachment(null);

        $this->assertNull($notification->getAttachment());
    }

    public function testPush()
    {
        $application = new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $message = new Message("This is a test message", "This is a title of the message");
        $notification = new Notification($application, $recipient, $message);
        $response = $notification->push();

        $this->assertInstanceOf(MessageResponse::class, $response);
    }
}
