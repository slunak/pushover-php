<?php

/*
 * This file is part of the Pushover package.
 *
 *  (c) Serhiy Lunak <https://github.com/slunak>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Priority;

/**
 * @author Serhiy Lunak
 */
class MessageTest extends TestCase
{
    public function testMessageCreation()
    {
        $message = new Message("This is a test message", "This is a title of the message");
        $message->setUrl("https://www.example.com");
        $message->setUrlTitle("Example URL");
        $message->setisHtml(false);
        // assign priority to the notification
        $message->setPriority(new Priority(Priority::NORMAL));

        $datetime = new \DateTime();
        $message->setTimestamp($datetime);

        $this->assertInstanceOf(Message::class, $message);

        $this->assertEquals("This is a test message", $message->getMessage());

        $this->assertEquals("This is a title of the message", $message->getTitle());

        $this->assertEquals("https://www.example.com", $message->getUrl());

        $this->assertEquals("Example URL", $message->getUrlTitle());

        $this->assertFalse($message->getIsHtml());

        $this->assertInstanceOf(Priority::class, $message->getPriority());

        $this->assertEquals($datetime->getTimestamp(), $message->getTimestamp());
    }
}
