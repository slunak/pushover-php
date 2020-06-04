<?php

/*
 * This file is part of the Pushover package.
 *
 *  (c) Serhiy Lunak <https://github.com/slunak>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Message;

use Serhiy\Pushover\Api\ApiClient;
use Serhiy\Pushover\Exception\LogicException;

/**
 * Pushover HTTP Client.
 *
 * @author Serhiy Lunak
 */
class Client extends ApiClient
{
    /**
     * The path part of the API URL.
     */
    const API_PATH = 'messages.json';

    public function __construct()
    {
    }

    /**
     * Sends notification.
     *
     * @param Notification $notification
     * @return Response
     */
    public function push(Notification $notification)
    {
        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => self::API_BASE_URL.'/'.self::API_VERSION.'/'.self::API_PATH,
            CURLOPT_POSTFIELDS => $this->buildCurlPostFields($notification),
            CURLOPT_SAFE_UPLOAD => true,
            CURLOPT_RETURNTRANSFER => true,
        ));

        $curlResponse = curl_exec($ch);
        curl_close($ch);

        if (false === $curlResponse) {
            throw new LogicException('Curl request failed.');
        }

        if (true === $curlResponse) {
            throw new LogicException('Curl should return json encoded string because CURLOPT_RETURNTRANSFER is set, "true" returned instead.');
        }

        return $this->processResponse(json_decode($curlResponse));
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
            $curlPostFields['retry'] = $notification->getMessage()->getPriority()->getRetry();
            $curlPostFields['expire'] = $notification->getMessage()->getPriority()->getExpire();
        }

        if (true === $notification->getMessage()->getIsHtml()) {
            $curlPostFields['html'] = 1;
        }

        return $curlPostFields;
    }

    /**
     * Processes curl response and returns Response object.
     *
     * @param mixed $curlResponse
     * @return Response
     */
    private function processResponse($curlResponse)
    {
        $response = new Response($curlResponse->status, $curlResponse->request);

        if ($response->getStatus() != 1) {
            $response->setErrors($curlResponse->errors);
        }

        if (isset($curlResponse->receipt)) {
            $response->setReceipt($curlResponse->receipt);
        }

        return $response;
    }
}
