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
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class AttachmentTest extends TestCase
{
    public function testCanBeConstructed(): Attachment
    {
        $attachment = new Attachment('/images/test.jpeg', Attachment::MIME_TYPE_JPEG);
        $this->assertInstanceOf(Attachment::class, $attachment);

        return $attachment;
    }

    public function testCannotBeConstructedWithInvalidMimeType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Attachment('/images/test.jpeg', 'image/invalid');
    }

    public function testCannotBeConstructedWithInvalidExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Attachment('/images/test.invalid', Attachment::MIME_TYPE_JPEG);
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testGetMimeType(Attachment $attachment): void
    {
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testGetFilename(Attachment $attachment): void
    {
        $this->assertEquals('/images/test.jpeg', $attachment->getFilename());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetMimeType(Attachment $attachment): void
    {
        $attachment->setMimeType(Attachment::MIME_TYPE_JPEG);
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());

        $this->expectException(InvalidArgumentException::class);
        $attachment->setMimeType('image/invalid');
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testSetFilename(Attachment $attachment): void
    {
        $attachment->setMimeType(Attachment::MIME_TYPE_JPEG);
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());

        $this->expectException(InvalidArgumentException::class);
        $attachment->setMimeType('image/invalid');
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testGetSupportedAttachmentTypes(Attachment $attachment): void
    {
        $supportedAttachmentsTypes = new \ReflectionClass(Attachment::class);

        $this->assertEquals($supportedAttachmentsTypes->getConstants(), $attachment->getSupportedAttachmentTypes());
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testGetSupportedAttachmentExtensions(Attachment $attachment): void
    {
        $supportedAttachmentExtensions = [
            'bmp', 'gif', 'ico', 'jpeg', 'jpg', 'png', 'svg', 'tif', 'tiff', 'webp',
        ];

        $this->assertEquals($supportedAttachmentExtensions, $attachment->getSupportedAttachmentExtensions());
    }
}
