<?php

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
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\Exception\InvalidArgumentException;

class MessageTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $message = new Message('This is a test message', 'This is a title of the message');

        $this->assertInstanceOf(Message::class, $message);
    }

    public function testSetMessage(): void
    {
        $message = new Message('This is a test message');
        $message->setMessage('This is a test message');

        $this->expectException(InvalidArgumentException::class);

        $message->setMessage(
            <<<'EOD'
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
EOD
        );
    }

    public function testGetMessage(): void
    {
        $message = new Message('This is a test message');

        $this->assertEquals('This is a test message', $message->getMessage());
    }

    public function testSetTitle(): void
    {
        $message = new Message('This is a test message');
        $message->setTitle('This is a title of the message');

        $this->expectException(InvalidArgumentException::class);

        $message->setTitle(
            <<<'EOD'
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
EOD
        );
    }

    public function testGetTitle(): void
    {
        $message = new Message('This is a test message', 'This is a title of the message');

        $this->assertEquals('This is a title of the message', $message->getTitle());
    }

    public function testSetUrl(): void
    {
        $message = new Message('This is a test message');
        $message->setUrl('https://www.example.com');

        $this->expectException(InvalidArgumentException::class);

        $message->setUrl(
            <<<'EOD'
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
EOD
        );
    }

    public function testGetUrl(): void
    {
        $message = new Message('This is a test message');
        $message->setUrl('https://www.example.com');

        $this->assertEquals('https://www.example.com', $message->getUrl());
    }

    public function testSetUrlTitle(): void
    {
        $message = new Message('This is a test message');
        $message->setUrlTitle('Example URL');

        $this->expectException(InvalidArgumentException::class);

        $message->setUrlTitle(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        );
    }

    public function testGetUrlTitle(): void
    {
        $message = new Message('This is a test message');
        $message->setUrlTitle('Example URL');

        $this->assertEquals('Example URL', $message->getUrlTitle());
    }

    public function testSetPriority(): void
    {
        $message = new Message('This is a test message');
        $message->setPriority(null);

        $this->assertNull($message->getPriority());
    }

    public function testGetPriority(): void
    {
        $message = new Message('This is a test message');
        $message->setPriority(new Priority(Priority::NORMAL));

        $this->assertInstanceOf(Priority::class, $message->getPriority());
    }

    public function testSetIsHtml(): void
    {
        $message = new Message('This is a test message');
        $message->setIsHtml(null);

        $this->assertNull($message->getIsHtml());
    }

    public function testGetIsHtml(): void
    {
        $message = new Message('This is a test message');
        $message->setIsHtml(true);

        $this->assertTrue($message->getIsHtml());
    }

    public function testGetTimestamp(): void
    {
        $message = new Message('This is a test message');

        $datetime = new \DateTime();
        $message->setTimestamp($datetime);

        $this->assertEquals($datetime->getTimestamp(), $message->getTimestamp());
    }

    public function testSetAndGetTtl(): void
    {
        $message = new Message('This is a test message');

        $this->assertNull($message->getTtl());

        $message->setTtl(3600);

        $this->assertEquals(3600, $message->getTtl());

        $message->setTtl(null);

        $this->assertNull($message->getTtl());
    }

    public function testSetNegativeTtl(): void
    {
        $message = new Message('This is a test message');

        $this->expectException(InvalidArgumentException::class);

        $message->setTtl(-1);
    }

    public function testSetZeroTtl(): void
    {
        $message = new Message('This is a test message');

        $this->expectException(InvalidArgumentException::class);

        $message->setTtl(0);
    }
}
