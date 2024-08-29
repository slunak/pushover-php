<?php

declare(strict_types=1);

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class MessageResponse extends Response
{
    /**
     * Receipt.
     * When your application sends an emergency-priority notification, our API will respond with a receipt value
     * that can be used to get information about whether the notification has been acknowledged.
     * See {@link https://pushover.net/api/receipts} for more information.
     */
    private string $receipt;

    public function __construct(string $curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    public function getReceipt(): string
    {
        return $this->receipt;
    }

    private function processCurlResponse(string $curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if (isset($decodedCurlResponse->receipt)) {
            $this->receipt = $decodedCurlResponse->receipt;
        }
    }
}
