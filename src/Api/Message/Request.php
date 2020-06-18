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

/**
 * Request object.
 *
 * Holds curl and other request data.
 *
 * @author Serhiy Lunak
 */
class Request
{
    /**
     * @var string
     */
    private $api_base_url;
    /**
     * @var string
     */
    private $api_version;
    /**
     * @var string
     */
    private $api_path;

    /**
     * CURLOPT_POSTFIELDS.
     *
     * Array for CURLOPT_POSTFIELDS curl argument.
     *
     * @var array
     */
    private $curlPostFields;

    /**
     * Object that contains notification.
     *
     * @var Notification
     */
    private $notification;

    public function __construct(string $api_base_url, string $api_version, string $api_path)
    {
        $this->api_base_url = $api_base_url;
        $this->api_version = $api_version;
        $this->api_path = $api_path;
    }

    /**
     * Builds API URL
     *
     * @return string
     */
    public function getFullUrl()
    {
        return $this->api_base_url.'/'.$this->api_version.'/'.$this->api_path;
    }

    /**
     * @return array
     */
    public function getCurlPostFields(): array
    {
        return $this->curlPostFields;
    }

    /**
     * @param Notification $notification
     */
    public function setCurlPostFields(Notification $notification): void
    {
        $this->curlPostFields = $this->buildCurlPostFields($notification);
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     */
    public function setNotification(Notification $notification): void
    {
        $this->notification = $notification;
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @param Notification $notification
     * @return array
     */
    private function buildCurlPostFields(Notification $notification)
    {
        $curlPostFields = array(
            "token" => $notification->getApplication()->getToken(),
            "user" => $notification->getRecipient()->getUserKey(),
            "message" => $notification->getMessage()->getMessage(),
            "timestamp" => $notification->getMessage()->getTimestamp(),
        );

        if (null !== $notification->getRecipient()->getDevice()) {
            $curlPostFields['device'] = $notification->getRecipient()->getDeviceListCommaSeparated();
        }

        if (null !== $notification->getMessage()->getTitle()) {
            $curlPostFields['title'] = $notification->getMessage()->getTitle();
        }

        if (null !== $notification->getMessage()->getUrl()) {
            $curlPostFields['url'] = $notification->getMessage()->getUrl();
        }

        if (null !== $notification->getMessage()->getUrlTitle()) {
            $curlPostFields['url_title'] = $notification->getMessage()->getUrlTitle();
        }

        if (null !== $notification->getMessage()->getPriority()) {
            $curlPostFields['priority'] = $notification->getMessage()->getPriority()->getPriority();

            if (Priority::EMERGENCY == $notification->getMessage()->getPriority()->getPriority()) {
                $curlPostFields['retry'] = $notification->getMessage()->getPriority()->getRetry();
                $curlPostFields['expire'] = $notification->getMessage()->getPriority()->getExpire();
            }
        }

        if (true === $notification->getMessage()->getIsHtml()) {
            $curlPostFields['html'] = 1;
        }

        if (null !== $notification->getSound()) {
            $curlPostFields['sound'] = $notification->getSound()->getSound();
        }

        return $curlPostFields;
    }
}
