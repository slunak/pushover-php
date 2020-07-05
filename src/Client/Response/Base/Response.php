<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client\Response\Base;

use Serhiy\Pushover\Client\Request\Request;

/**
 * Response represents response object.
 *
 * If your POST request to our API was valid, you will receive an HTTP 200 (OK) status,
 * with a JSON object containing a status code of 1. If any input was invalid, you will receive an HTTP 4xx status,
 * with a JSON object containing a status code of something other than 1, and an errors array detailing which parameters were invalid.
 *
 * @author Serhiy Lunak
 */
class Response
{
    /**
     * True if request was successful, false otherwise. Reflects $requestStatus property.
     *
     * @var bool
     */
    private $isSuccessful;

    /**
     * Either 1 if successful or something other than 1 if unsuccessful. Reflects $isSuccessful property.
     *
     * @var int
     */
    private $requestStatus;

    /**
     * Randomly-generated unique token that we have associated with your request.
     *
     * @var string
     */
    private $requestToken;

    /**
     * Original curl response in json format.
     * Original, unmodified response from curl request.
     *
     * @var mixed
     */
    private $curlResponse;

    /**
     * Array detailing which parameters were invalid.
     *
     * @var array[]
     */
    private $errors = array();

    /**
     * Object that contains original request.
     *
     * @var Request
     */
    private $request;


    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    /**
     * @param bool $isSuccessful
     */
    public function setIsSuccessful(bool $isSuccessful): void
    {
        $this->isSuccessful = $isSuccessful;
    }

    /**
     * @return int
     */
    public function getRequestStatus(): int
    {
        return $this->requestStatus;
    }

    /**
     * @param int $requestStatus
     */
    public function setRequestStatus(int $requestStatus): void
    {
        $this->requestStatus = $requestStatus;
    }

    /**
     * @return string
     */
    public function getRequestToken(): string
    {
        return $this->requestToken;
    }

    /**
     * @param string $requestToken
     */
    public function setRequestToken(string $requestToken): void
    {
        $this->requestToken = $requestToken;
    }

    /**
     * @return array[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array[] $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getCurlResponse()
    {
        return $this->curlResponse;
    }

    /**
     * @param mixed $curlResponse
     */
    public function setCurlResponse($curlResponse): void
    {
        $this->curlResponse = $curlResponse;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
