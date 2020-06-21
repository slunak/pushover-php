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

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {
        $this->request = new Request(self::API_BASE_URL, self::API_VERSION, self::API_PATH);
        $this->response = new Response();
    }

    /**
     * Sends notification and returns Response object.
     *
     * @param Notification $notification
     * @return Response
     */
    public function push(Notification $notification)
    {
        $this->request->setCurlPostFields($notification);
        $this->request->setNotification($notification);

        $curlResponse = $this->doCurl();

        $this->processCurlResponse($curlResponse);

        $this->response->setRequest($this->request);

        return $this->response;
    }

    /**
     * @return mixed
     */
    private function doCurl()
    {
        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => $this->request->getFullUrl(),
            CURLOPT_POSTFIELDS => $this->request->getCurlPostFields(),
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

        return $curlResponse;
    }

    /**
     * Processes curl response.
     *
     * @param mixed $curlResponse
     * @return void
     */
    private function processCurlResponse($curlResponse)
    {
        $decodedCurlResponse = json_decode($curlResponse);

        $this->response->setRequestStatus($decodedCurlResponse->status);
        $this->response->setRequestToken($decodedCurlResponse->request);
        $this->response->setCurlResponse($curlResponse);

        if ($this->response->getRequestStatus() == 1) {
            $this->response->setIsSuccessful(true);
        }

        if ($this->response->getRequestStatus() != 1) {
            $this->response->setErrors($decodedCurlResponse->errors);
            $this->response->setIsSuccessful(false);
        }

        if (isset($decodedCurlResponse->receipt)) {
            $this->response->setReceipt($curlResponse->receipt);
        }

        return;
    }
}
