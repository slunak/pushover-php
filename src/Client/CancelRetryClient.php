<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Api\Receipts\Receipt;
use Serhiy\Pushover\Client\Curl\Curl;

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
        return Curl::API_BASE_URL."/".Curl::API_VERSION."/receipts/".$this->receipt."/cancel.json";
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
}
