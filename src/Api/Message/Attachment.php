<?php

/**
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
    public const MIME_TYPE_JPEG = 'image/jpeg';

    /**
     * Portable Network Graphics.
     */
    public const MIME_TYPE_PNG = 'image/png';

    /**
     * Graphics Interchange Format (GIF).
     */
    public const MIME_TYPE_GIF = 'image/gif';

    /**
     * Windows OS/2 Bitmap Graphics
     */
    public const MIME_TYPE_BMP = 'image/bmp';

    /**
     * Icon format
     */
    public const MIME_TYPE_ICO = 'image/vnd.microsoft.icon';

    /**
     * Scalable Vector Graphics (SVG)
     */
    public const MIME_TYPE_SVG = 'image/svg+xml';

    /**
     * Tagged Image File Format (TIFF)
     */
    public const MIME_TYPE_TIFF = 'image/tiff';

    /**
     * WEBP image
     */
    public const MIME_TYPE_WEBP = 'image/webp';

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
     * @return array<string>
     */
    public static function getSupportedAttachmentTypes(): array
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }

    /**
     * Supported extensions.
     * Returns array of supported extensions.
     *
     * @return array<string>
     */
    public static function getSupportedAttachmentExtensions(): array
    {
        return [
            'bmp', 'gif', 'ico', 'jpeg', 'jpg', 'png', 'svg', 'tif', 'tiff', 'webp',
        ];
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): void
    {
        if (!\in_array($mimeType, $this->getSupportedAttachmentTypes(), true)) {
            throw new InvalidArgumentException(sprintf('Attachment type "%s" is not supported.', $mimeType));
        }

        $this->mimeType = $mimeType;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): void
    {
        if (!\in_array(pathinfo($filename, \PATHINFO_EXTENSION), $this->getSupportedAttachmentExtensions(), true)) {
            throw new InvalidArgumentException(sprintf('Attachment extension "%s" is not supported.', pathinfo($filename, \PATHINFO_EXTENSION)));
        }

        $this->filename = $filename;
    }
}
