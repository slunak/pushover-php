<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient;

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
     * @var string Full API URL
     */
    private $apiUrl;

    /**
     * CURLOPT_POSTFIELDS.
     *
     * Array for CURLOPT_POSTFIELDS curl argument.
     *
     * @var array
     */
    private $curlPostFields;

    public function __construct(string $apiUrl, array $curlPostFields)
    {
        $this->apiUrl = $apiUrl;
        $this->curlPostFields = $curlPostFields;
    }

    /**
     * Returns API URL
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @return array
     */
    public function getCurlPostFields(): array
    {
        return $this->curlPostFields;
    }
}
