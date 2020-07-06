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
     *
     * @var string
     */
    private $message;

    /**
     * Your message's title, otherwise your app's name is used.
     *
     * @var string|null
     */
    private $title;

    /**
     * A supplementary URL to show with your message.
     *
     * @var string|null
     */
    private $url;

    /**
     * A title for your supplementary URL, otherwise just the URL is shown.
     *
     * @var string|null
     */
    private $urlTitle;

    /**
     * Message Priority.
     * Send as -2 to generate no notification/alert, -1 to always send as a quiet notification,
     * 1 to display as high-priority and bypass the user's quiet hours,
     * or 2 to also require confirmation from the user.
     * See {@link https://pushover.net/api#priority} for more information.
     *
     * @var Priority|null
     */
    private $priority;

    /**
     * HTML Message.
     * As of version 2.3 of our device clients, messages can be formatted with HTML tags.
     * See {@link https://pushover.net/api#html} for more information.
     *
     * @var bool|null
     */
    private $isHtml = false;

    /**
     * Message Time.
     * Messages are stored on the Pushover servers with a timestamp of when they were initially received through the API.
     * This timestamp is shown to the user, and messages are listed in order of their timestamps. In most cases, this default timestamp is acceptable.
     * In some cases, such as when messages have been queued on a remote server before reaching the Pushover servers,
     * or delivered to Pushover out of order, this default timestamping may cause a confusing order of messages when viewed on the user's device.
     * For these scenarios, your app may send messages to the API with the timestamp parameter set to the Unix timestamp of the original message.
     *
     * @var \DateTime
     */
    private $timestamp;


    public function __construct(string $message, string $title = null)
    {
        $this->setMessage($message);

        if (null !== $title) {
            $this->setTitle($title);
        }

        $this->timestamp = new \DateTime();
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        if (strlen($message) > 1024) {
            throw new InvalidArgumentException('Message contained ' . strlen($message) . ' characters. Messages are limited to 1024 4-byte UTF-8 characters.');
        }

        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        if (strlen($title) > 250) {
            throw new InvalidArgumentException('Title contained ' . strlen($title) . ' characters. Titles are limited to 250 characters.');
        }

        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        if (strlen($url) > 512) {
            throw new InvalidArgumentException('Supplementary URL contained ' . strlen($url) . ' characters. Supplementary URLs are limited to 512 characters.');
        }

        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getUrlTitle(): ?string
    {
        return $this->urlTitle;
    }

    /**
     * @param string $urlTitle
     */
    public function setUrlTitle(string $urlTitle): void
    {
        if (strlen($urlTitle) > 100) {
            throw new InvalidArgumentException('URL title contained ' . strlen($urlTitle) . ' characters. URL titles are limited to 100 characters.');
        }

        $this->urlTitle = $urlTitle;
    }

    /**
     * @return Priority|null
     */
    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    /**
     * @param Priority|null $priority
     */
    public function setPriority(?Priority $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return bool|null
     */
    public function getIsHtml(): ?bool
    {
        return $this->isHtml;
    }

    /**
     * @param bool|null $isHtml
     */
    public function setIsHtml(?bool $isHtml): void
    {
        $this->isHtml = $isHtml;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp->getTimestamp();
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setTimestamp(\DateTime $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
