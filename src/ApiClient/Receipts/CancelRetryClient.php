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

use Serhiy\Pushover\Api\Receipts\Receipt;
use Serhiy\Pushover\ApiClient\Client;
use Serhiy\Pushover\ApiClient\ClientInterface;
use Serhiy\Pushover\ApiClient\CurlHelper;

/**
 * @author Serhiy Lunak
 */
class CancelRetryClient extends Client implements ClientInterface
{
    /**
     * @var string 30 character string.
     */
    private $receipt;

    public function __construct(string $receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * @inheritDoc
     */
    public function buildApiUrl(): string
    {
        return CurlHelper::API_BASE_URL."/".CurlHelper::API_VERSION."/receipts/".$this->receipt."/cancel.json";
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @param Receipt $receipt
     * @return array[]
     */
    public function buildCurlPostFields(Receipt $receipt): array
    {
        return array(
            'token' => $receipt->getApplication()->getToken(),
        );
    }

    /**
     * @param mixed $curlResponse
     * @return CancelRetryResponse
     */
    protected function processCurlResponse($curlResponse): CancelRetryResponse
    {
        $response = new CancelRetryResponse();

        $decodedCurlResponse = json_decode($curlResponse);

        $response->setRequestStatus($decodedCurlResponse->status);
        $response->setCurlResponse($curlResponse);

        if ($response->getRequestStatus() == 1) {
            $response->setIsSuccessful(true);
            $response->setRequestToken($decodedCurlResponse->request);
        }

        if ($response->getRequestStatus() != 1) {
            $response->setErrors($decodedCurlResponse->errors);
            $response->setIsSuccessful(false);
        }

        return $response;
    }
}
