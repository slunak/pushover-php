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

use Serhiy\Pushover\Api\Message\Attachment;
use PHPUnit\Framework\TestCase;
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

    public function testCannotBeCreatedWithInvalidMimeType()
    {
        $this->expectException(InvalidArgumentException::class);

        new Attachment('/images/test.jpeg', 'image/invalid');
    }

    public function testCannotBeCreatedWithInvalidExtension()
    {
        $this->expectException(InvalidArgumentException::class);

        new Attachment('/images/test.invalid', Attachment::MIME_TYPE_JPEG);
    }

    /**
     * @depends testCanBeCreated
     * @param Attachment $attachment
     */
    public function testGetMimeType(Attachment $attachment)
    {
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());
    }

    /**
     * @depends testCanBeCreated
     * @param Attachment $attachment
     */
    public function testGetFilename(Attachment $attachment)
    {
        $this->assertEquals('/images/test.jpeg', $attachment->getFilename());
    }

    /**
     * @depends testCanBeCreated
     * @param Attachment $attachment
     */
    public function testSetMimeType(Attachment $attachment)
    {
        $attachment->setMimeType(Attachment::MIME_TYPE_JPEG);
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());

        $this->expectException(InvalidArgumentException::class);
        $attachment->setMimeType('image/invalid');
    }

    /**
     * @depends testCanBeCreated
     * @param Attachment $attachment
     */
    public function testSetFilename(Attachment $attachment)
    {
        $attachment->setMimeType(Attachment::MIME_TYPE_JPEG);
        $this->assertEquals(Attachment::MIME_TYPE_JPEG, $attachment->getMimeType());

        $this->expectException(InvalidArgumentException::class);
        $attachment->setMimeType('image/invalid');
    }

    /**
     * @depends testCanBeCreated
     * @param Attachment $attachment
     */
    public function testSupportedAttachmentTypes(Attachment $attachment)
    {
        $supportedAttachmentsTypes = new \ReflectionClass(Attachment::class);

        $this->assertEquals($supportedAttachmentsTypes->getConstants(), $attachment->getSupportedAttachmentTypes());
    }

    /**
     * @depends testCanBeCreated
     * @param Attachment $attachment
     */
    public function testSupportedAttachmentExtensions(Attachment $attachment)
    {
        $supportedAttachmentExtensions = array(
            'bmp', 'gif', 'ico', 'jpeg', 'jpg', 'png', 'svg', 'tif', 'tiff', 'webp'
        );

        $this->assertEquals($supportedAttachmentExtensions, $attachment->getSupportedAttachmentExtensions());
    }
}
