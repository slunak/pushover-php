<?php

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
 * Request object.
 *
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
     * @var string either GET or POST
     */
    private $method;

    /**
     * @var string full API URL
     */
    private $apiUrl;

    /**
     * CURLOPT_POSTFIELDS.
     *
     * Array for CURLOPT_POSTFIELDS curl argument.
     *
     * @var null|array[]
     */
    private $curlPostFields;

    /**
     * Request constructor.
     *
     * @param null|array[] $curlPostFields
     */
    public function __construct(string $apiUrl, string $method, array $curlPostFields = null)
    {
        $this->apiUrl = $apiUrl;
        $this->method = $method;
        $this->curlPostFields = $curlPostFields;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns API URL
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @return null|array[]
     */
    public function getCurlPostFields(): ?array
    {
        return $this->curlPostFields;
    }
}
