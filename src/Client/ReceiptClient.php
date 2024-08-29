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

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Curl\Curl;

class ReceiptClient extends Client implements ClientInterface
{
    public function __construct(
        private readonly Application $application,
        private readonly string $receipt,
    ) {
    }

    public function buildApiUrl(): string
    {
        return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/receipts/'.$this->receipt.'.json?token='.$this->application->getToken();
    }
}
