<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Receipts;

use Serhiy\Pushover\Client\CancelRetryClient;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\ReceiptClient;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\CancelRetryResponse;
use Serhiy\Pushover\Client\Response\ReceiptResponse;

/**
 * Applications sending emergency-priority notifications will receive a receipt parameter from our API when a notification has been queued.
 * This receipt can be used to periodically poll our receipts API to get the status of your notification,
 * up to 1 week after your notification has been received.
 *
 * @author Serhiy Lunak
 */
class Receipt
{
    /**
     * @var Application
     */
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @param string $receipt
     * @return ReceiptResponse
     */
    public function query(string $receipt): ReceiptResponse
    {
        $client = new ReceiptClient($this->application, $receipt);
        $request = new Request($client->buildApiUrl(), Request::GET);

        $curlResponse = Curl::do($request);

        $response = new ReceiptResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * @param string $receipt
     * @return CancelRetryResponse
     */
    public function cancelRetry(string $receipt): CancelRetryResponse
    {
        $client = new CancelRetryClient($receipt);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this));

        $curlResponse = Curl::do($request);

        $response = new CancelRetryResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
