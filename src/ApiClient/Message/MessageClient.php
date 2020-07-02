<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient\Message;

use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\ApiClient\ClientInterface;
use Serhiy\Pushover\ApiClient\CurlHelper;
use Serhiy\Pushover\ApiClient\Request;
use Serhiy\Pushover\Exception\LogicException;

/**
 * Pushover HTTP Client for Message Component.
 *
 * @author Serhiy Lunak
 */
class MessageClient implements ClientInterface
{
    /**
     * The path part of the API URL.
     */
    const API_PATH = 'messages.json';

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     * @return MessageResponse
     */
    public function send(Request $request): MessageResponse
    {
        $curlResponse = CurlHelper::post($request);

        $response = $this->processCurlResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Processes curl response.
     *
     * @param mixed $curlResponse
     * @return MessageResponse
     */
    private function processCurlResponse($curlResponse): MessageResponse
    {
        $response = new MessageResponse();

        $decodedCurlResponse = json_decode($curlResponse);

        $response->setRequestStatus($decodedCurlResponse->status);
        $response->setRequestToken($decodedCurlResponse->request);
        $response->setCurlResponse($curlResponse);

        if ($response->getRequestStatus() == 1) {
            $response->setIsSuccessful(true);
        }

        if ($response->getRequestStatus() != 1) {
            $response->setErrors($decodedCurlResponse->errors);
            $response->setIsSuccessful(false);
        }

        if (isset($decodedCurlResponse->receipt)) {
            $response->setReceipt($decodedCurlResponse->receipt);
        }

        return $response;
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @param Notification $notification
     * @return array[]
     */
    public function buildCurlPostFields(Notification $notification): array
    {
        $curlPostFields = array(
            "token" => $notification->getApplication()->getToken(),
            "user" => $notification->getRecipient()->getUserKey(),
            "message" => $notification->getMessage()->getMessage(),
            "timestamp" => $notification->getMessage()->getTimestamp(),
        );

        if (! empty($notification->getRecipient()->getDevice())) {
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

                if (null !== $notification->getMessage()->getPriority()->getCallback()) {
                    $curlPostFields['callback'] = $notification->getMessage()->getPriority()->getCallback();
                }
            }
        }

        if (true === $notification->getMessage()->getIsHtml()) {
            $curlPostFields['html'] = 1;
        }

        if (null !== $notification->getSound()) {
            $curlPostFields['sound'] = $notification->getSound()->getSound();
        }

        if (null !== $notification->getAttachment()) {
            if (! is_readable($notification->getAttachment()->getFilename())) {
                throw new LogicException(sprintf('File "%s" does not exist or is not readable.', $notification->getAttachment()->getFilename()));
            }

            if (2621440 < filesize($notification->getAttachment()->getFilename())) {
                throw new LogicException(sprintf('Attachments are currently limited to 2621440 bytes (2.5 megabytes). %s bytes attachment provided.', filesize($notification->getAttachment()->getFilename())));
            }

            $curlPostFields['attachment'] = curl_file_create(
                $notification->getAttachment()->getFilename(),
                $notification->getAttachment()->getMimeType()
            );
        }

        return $curlPostFields;
    }

    /**
     * @inheritDoc
     */
    public function buildApiUrl(): string
    {
        return CurlHelper::API_BASE_URL."/".CurlHelper::API_VERSION."/".self::API_PATH;
    }
}
