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
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
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
     * Either GET or POST.
     */
    private string $method;

    /**
     * Full API URL.
     */
    private string $apiUrl;

    /**
     * Array for CURLOPT_POSTFIELDS curl argument.
     *
     * @var null|array<string, string>
     */
    private ?array $curlPostFields;

    /**
     * @param null|array<string, string> $curlPostFields
     */
    public function __construct(string $apiUrl, string $method, ?array $curlPostFields = null)
    {
        $this->apiUrl = $apiUrl;
        $this->method = $method;
        $this->curlPostFields = $curlPostFields;
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
