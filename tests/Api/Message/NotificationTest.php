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

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Attachment;
use Serhiy\Pushover\Api\Message\CustomSound;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\MessageResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class NotificationTest extends TestCase
{
    public function testCanBeConstructed(): Notification
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        $message = new Message('This is a test message', 'This is a title of the message');

        $notification = new Notification($application, $recipient, $message);

        $this->assertInstanceOf(Notification::class, $notification);

        return $notification;
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetSound(Notification $notification): void
    {
        $notification->setSound(new Sound(Sound::PUSHOVER));

        $this->assertSame('pushover', $notification->getSound()->getSound());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetSoundNull(Notification $notification): void
    {
        $notification->setSound(null);

        $this->assertNull($notification->getSound());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetCustomSound(Notification $notification): void
    {
        $notification->setCustomSound(new CustomSound('door_open'));

        $this->assertSame('door_open', $notification->getCustomSound()->getCustomSound());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetCustomSoundNull(Notification $notification): void
    {
        $notification->setCustomSound(null);

        $this->assertNull($notification->getCustomSound());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetAttachment(Notification $notification): void
    {
        $notification->setAttachment(new Attachment('/path/to/file.jpg', Attachment::MIME_TYPE_JPEG));

        $this->assertSame('/path/to/file.jpg', $notification->getAttachment()->getFilename());
        $this->assertSame('image/jpeg', $notification->getAttachment()->getMimeType());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetAttachmentNull(Notification $notification): void
    {
        $notification->setAttachment(null);

        $this->assertNull($notification->getAttachment());
    }

    /**
     * @group Integration
     */
    public function testPush(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $message = new Message('This is a test message', 'This is a title of the message');
        $notification = new Notification($application, $recipient, $message);
        $response = $notification->push();

        $this->assertInstanceOf(MessageResponse::class, $response);
    }
}
