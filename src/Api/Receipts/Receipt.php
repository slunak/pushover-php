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

use Serhiy\Pushover\ApiClient\Receipts\CancelRetryClient;
use Serhiy\Pushover\ApiClient\Receipts\CancelRetryResponse;
use Serhiy\Pushover\ApiClient\Receipts\ReceiptClient;
use Serhiy\Pushover\ApiClient\Receipts\ReceiptResponse;
use Serhiy\Pushover\ApiClient\Request;
use Serhiy\Pushover\Application;

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
    public function query(string $receipt)
    {
        $client = new ReceiptClient($this->application, $receipt);

        $request = new Request($client->buildApiUrl(), Request::GET);

        return $client->send($request);
    }

    /**
     * @param string $receipt
     * @return CancelRetryResponse
     */
    public function cancelRetry(string $receipt)
    {
        $client = new CancelRetryClient($receipt);

        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this));

        return $client->send($request);
    }
}
