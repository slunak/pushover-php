<?php

/*
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
    const GET = "GET";

    /**
     * HTTP POST method.
     */
    const POST = "POST";

    /**
     * @var string Either GET or POST.
     */
    private $method;

    /**
     * @var string Full API URL.
     */
    private $apiUrl;

    /**
     * CURLOPT_POSTFIELDS.
     *
     * Array for CURLOPT_POSTFIELDS curl argument.
     *
     * @var array[]|null
     */
    private $curlPostFields;

    /**
     * Request constructor.
     * @param string $apiUrl
     * @param string $method
     * @param array[]|null $curlPostFields
     */
    public function __construct(string $apiUrl, string $method, array $curlPostFields = null)
    {
        $this->apiUrl = $apiUrl;
        $this->method = $method;
        $this->curlPostFields = $curlPostFields;
    }

    /**
     * Returns API URL
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @return array[]|null
     */
    public function getCurlPostFields(): ?array
    {
        return $this->curlPostFields;
    }
}
