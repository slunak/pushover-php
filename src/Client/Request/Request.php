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

namespace Serhiy\Pushover\Client\Request;

/**
 * Holds curl and other request data.
 *
 * @author Serhiy Lunak
 */
class Request implements RequestInterface
{
    /**
     * HTTP GET method.
     */
    public const GET = 'GET';

    /**
     * HTTP POST method.
     */
    public const POST = 'POST';

    /**
     * @param string                     $apiUrl         Full API URL
     * @param string                     $method         Either GET or POST
     * @param null|array<string, string> $curlPostFields array for CURLOPT_POSTFIELDS curl argument
     */
    public function __construct(
        private readonly string $apiUrl,
        private readonly string $method,
        private readonly ?array $curlPostFields = null,
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @return null|array<string, string>
     */
    public function getCurlPostFields(): ?array
    {
        return $this->curlPostFields;
    }
}
