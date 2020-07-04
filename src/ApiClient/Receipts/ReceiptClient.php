<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient\Receipts;

use Serhiy\Pushover\ApiClient\ClientInterface;
use Serhiy\Pushover\ApiClient\CurlHelper;
use Serhiy\Pushover\ApiClient\Request;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

class ReceiptClient implements ClientInterface
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var string
     */
    private $receipt;

    public function __construct(Application $application, string $receipt)
    {
        $this->application = $application;
        $this->receipt = $receipt;
    }

    /**
     * @inheritDoc
     */
    public function buildApiUrl(): string
    {
        return CurlHelper::API_BASE_URL."/".CurlHelper::API_VERSION."/receipts/".$this->receipt.".json?token=".$this->application->getToken();
    }

    /**
     * @inheritDoc
     */
    public function send(Request $request): ReceiptResponse
    {
        $curlResponse = CurlHelper::do($request);
        $response = $this->processCurlResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Processes curl response.
     *
     * @param $curlResponse
     * @return ReceiptResponse
     */
    private function processCurlResponse($curlResponse): ReceiptResponse
    {
        $response = new ReceiptResponse();

        $decodedCurlResponse = json_decode($curlResponse);

        $response->setRequestStatus($decodedCurlResponse->status);
        $response->setRequestToken($decodedCurlResponse->request);
        $response->setCurlResponse($curlResponse);

        if ($response->getRequestStatus() == 1) {
            $response->setIsSuccessful(true);

            if ($decodedCurlResponse->acknowledged == 1) {
                $response->setIsAcknowledged(true);
                $response->setAcknowledgedAt(new \DateTime('@'.$decodedCurlResponse->acknowledged_at));

                $recipient = new Recipient($decodedCurlResponse->acknowledged_by);
                $recipient->addDevice($decodedCurlResponse->acknowledged_by_device);
                $response->setAcknowledgedBy($recipient);
                $response->setAcknowledgedByDevice($recipient->getDeviceListCommaSeparated());
            }

            $response->setLastDeliveredAt(new \DateTime('@'.$decodedCurlResponse->last_delivered_at));

            if ($decodedCurlResponse->expired == 1) {
                $response->setIsExpired(true);
            } else {
                $response->setIsExpired(false);
            }

            $response->setExpiresAt(new \DateTime('@'.$decodedCurlResponse->expires_at));

            if ($decodedCurlResponse->called_back == 1) {
                $response->setHasCalledBack(true);
                $response->setCalledBackAt(new \DateTime('@'.$decodedCurlResponse->called_back_at));
            }
        }

        if ($response->getRequestStatus() != 1) {
            $response->setErrors($decodedCurlResponse->errors);
            $response->setIsSuccessful(false);
        }

        return $response;
    }
}
