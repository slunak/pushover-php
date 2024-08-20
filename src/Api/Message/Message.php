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
 * Pushover Message.
 *
 * Messages must contain a message parameter that contains the message body and an optional title parameter.
 * If the title is not specified, the application's name will be shown by default.
 * See {@link https://pushover.net/api#messages} for more information.
 *
 * @author Serhiy Lunak
 */
class Message
{
    /**
     * (required) - your message.
     */
    private string $message;

    /**
     * Your message's title, otherwise your app's name is used.
     */
    private ?string $title;

    /**
     * A supplementary URL to show with your message.
     */
    private ?string $url;

    /**
     * A title for your supplementary URL, otherwise just the URL is shown.
     */
    private ?string $urlTitle;

    /**
     * Message Priority.
     * Send as -2 to generate no notification/alert, -1 to always send as a quiet notification,
     * 1 to display as high-priority and bypass the user's quiet hours,
     * or 2 to also require confirmation from the user.
     * See {@link https://pushover.net/api#priority} for more information.
     */
    private ?Priority $priority;

    /**
     * HTML Message.
     * As of version 2.3 of our device clients, messages can be formatted with HTML tags.
     * See {@link https://pushover.net/api#html} for more information.
     */
    private ?bool $isHtml = false;

    /**
     * Message Time.
     * Messages are stored on the Pushover servers with a timestamp of when they were initially received through the API.
     * This timestamp is shown to the user, and messages are listed in order of their timestamps. In most cases, this default timestamp is acceptable.
     * In some cases, such as when messages have been queued on a remote server before reaching the Pushover servers,
     * or delivered to Pushover out of order, this default timestamping may cause a confusing order of messages when viewed on the user's device.
     * For these scenarios, your app may send messages to the API with the timestamp parameter set to the Unix timestamp of the original message.
     */
    private \DateTime $timestamp;

    /**
     * Normally a message delivered to a device is retained on the device until it is deleted by the user,
     * or is automatically deleted when the number of messages on the device exceeds the user's configured message limit.
     * The ttl parameter specifies a Time to Live in seconds, after which the message will be automatically deleted from the devices it was delivered to.
     * This can be useful for unimportant messages that have a limited usefulness after a short amount of time.
     *
     * The ttl parameter is ignored for messages with a priority value of 2.
     *
     * The ttl value must be a positive number of seconds, and is counted from the time the message is received by our API.
     */
    private ?int $ttl;

    public function __construct(string $message, string $title = null)
    {
        $this->setMessage($message);

        if (null !== $title) {
            $this->setTitle($title);
        }

        $this->timestamp = new \DateTime();
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        if (\strlen($message) > 1024) {
            throw new InvalidArgumentException('Message contained '.\strlen($message).' characters. Messages are limited to 1024 4-byte UTF-8 characters.');
        }

        $this->message = $message;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        if (\strlen($title) > 250) {
            throw new InvalidArgumentException('Title contained '.\strlen($title).' characters. Titles are limited to 250 characters.');
        }

        $this->title = $title;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        if (\strlen($url) > 512) {
            throw new InvalidArgumentException('Supplementary URL contained '.\strlen($url).' characters. Supplementary URLs are limited to 512 characters.');
        }

        $this->url = $url;
    }

    public function getUrlTitle(): ?string
    {
        return $this->urlTitle;
    }

    public function setUrlTitle(string $urlTitle): void
    {
        if (\strlen($urlTitle) > 100) {
            throw new InvalidArgumentException('URL title contained '.\strlen($urlTitle).' characters. URL titles are limited to 100 characters.');
        }

        $this->urlTitle = $urlTitle;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): void
    {
        $this->priority = $priority;
    }

    public function getIsHtml(): ?bool
    {
        return $this->isHtml;
    }

    public function setIsHtml(?bool $isHtml): void
    {
        $this->isHtml = $isHtml;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp->getTimestamp();
    }

    public function setTimestamp(\DateTime $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    public function setTtl(?int $ttl): void
    {
        if ($ttl <= 0 && null !== $ttl) {
            throw new InvalidArgumentException('The ttl value of '.$ttl.' is invalid. The ttl value must be a positive number of seconds.');
        }

        $this->ttl = $ttl;
    }
}
