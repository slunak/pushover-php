<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Message;

use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * Pushover messages can include an image attachment.
 * When received by a device, it will attempt to download the image and display it with the notification.
 * If this fails or takes too long, the notification will be displayed without it and the image download can be retried inside the Pushover app.
 * Note that, like messages, once attachments are downloaded by the device, they are deleted from our servers and only stored on the device going forward.
 * Attachments uploaded for devices that are not running at least version 3.0 of our apps will be discarded as they cannot be displayed by those devices.
 *
 * @author Serhiy Lunak
 */
class Attachment
{
    /**
     * Windows OS/2 Bitmap Graphics.
     */
    const MIME_TYPE_JPEG = 'image/jpeg';

    /**
     * Portable Network Graphics.
     */
    const MIME_TYPE_PNG = 'image/png';

    /**
     * Graphics Interchange Format (GIF).
     */
    const MIME_TYPE_GIF = 'image/gif';

    /**
     * Windows OS/2 Bitmap Graphics
     */
    const MIME_TYPE_BMP = 'image/bmp';

    /**
     * Icon format
     */
    const MIME_TYPE_ICO = 'image/vnd.microsoft.icon';

    /**
     * Scalable Vector Graphics (SVG)
     */
    const MIME_TYPE_SVG = 'image/svg+xml';

    /**
     * Tagged Image File Format (TIFF)
     */
    const MIME_TYPE_TIFF = 'image/tiff';

    /**
     * WEBP image
     */
    const MIME_TYPE_WEBP = 'image/webp';

    /**
     * MIME type.
     * A media type (also known as a Multipurpose Internet Mail Extensions or MIME type) is a standard
     * that indicates the nature and format of a document, file, or assortment of bytes.
     * In case of Pushover attachment only image MIME type is accepted.
     *
     * @var string
     */
    private $mimeType;

    /**
     * Path to the file.
     * Path and filename of the image file to be sent with notification.
     *
     * @var string
     */
    private $filename;

    public function __construct(string $filename, string $mimeType)
    {
        $this->setMimeType($mimeType);
        $this->setFilename($filename);
    }

    /**
     * Generates array with all supported attachment types. Attachment types are taken from the constants of this class.
     *
     * @return array
     */
    public function getSupportedAttachmentTypes(): array
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    /**
     * Supported extensions.
     * Returns array of supported extensions.
     *
     * @return array
     */
    public function getSupportedAttachmentExtensions(): array
    {
        return array(
            'bmp', 'gif', 'ico', 'jpeg', 'jpg', 'png', 'svg', 'tif', 'tiff', 'webp'
        );
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType): void
    {
        if (!in_array($mimeType, $this->getSupportedAttachmentTypes())) {
            throw new InvalidArgumentException(sprintf('Attachment type "%s" is not supported.', $mimeType));
        }
        
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        if (!in_array(pathinfo($filename, PATHINFO_EXTENSION), $this->getSupportedAttachmentExtensions())) {
            throw new InvalidArgumentException(sprintf('Attachment extension "%s" is not supported.', pathinfo($filename, PATHINFO_EXTENSION)));
        }

        $this->filename = $filename;
    }
}
