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
use Serhiy\Pushover\Api\Message\Attachment;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class AttachmentTest extends TestCase
{
    public function testCanBeCreated()
    {
        $attachment = new Attachment('/images/test.jpeg', Attachment::MIME_TYPE_JPEG);
        $this->assertInstanceOf(Attachment::class, $attachment);

        return $attachment;
    }

    public function testCannotBeCreatedWithInvalidMimeType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Attachment('/images/test.jpeg', 'image/invalid');
    }

    public function testCannotBeCreatedWithInvalidExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Attachment('/images/test.invalid', Attachment::MIME_TYPE_JPEG);
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetMimeType(Attachment $attachment): void
    {
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetFilename(Attachment $attachment): void
    {
        $this->assertEquals('/images/test.jpeg', $attachment->getFilename());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetMimeType(Attachment $attachment): void
    {
        $attachment->setMimeType(Attachment::MIME_TYPE_JPEG);
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());

        $this->expectException(InvalidArgumentException::class);
        $attachment->setMimeType('image/invalid');
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetFilename(Attachment $attachment): void
    {
        $attachment->setMimeType(Attachment::MIME_TYPE_JPEG);
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());

        $this->expectException(InvalidArgumentException::class);
        $attachment->setMimeType('image/invalid');
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetSupportedAttachmentTypes(Attachment $attachment): void
    {
        $supportedAttachmentsTypes = new \ReflectionClass(Attachment::class);

        $this->assertEquals($supportedAttachmentsTypes->getConstants(), $attachment->getSupportedAttachmentTypes());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetSupportedAttachmentExtensions(Attachment $attachment): void
    {
        $supportedAttachmentExtensions = [
            'bmp', 'gif', 'ico', 'jpeg', 'jpg', 'png', 'svg', 'tif', 'tiff', 'webp',
        ];

        $this->assertEquals($supportedAttachmentExtensions, $attachment->getSupportedAttachmentExtensions());
    }
}
