<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Message;

/**
 * Response object.
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
     * Receipt.
     * When your application sends an emergency-priority notification, our API will respond with a receipt value
     * that can be used to get information about whether the notification has been acknowledged.
     * See {@link https://pushover.net/api/receipts} for more information.
     *
     * @var string
     */
    private $receipt;

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
     * @var array
     */
    private $errors;

    /**
     * Object that contains original request.
     *
     * @var Request
     */
    private $request;

    public function __construct()
    {
        $this->errors = array();
    }

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
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getReceipt(): string
    {
        return $this->receipt;
    }

    /**
     * @param string $receipt
     */
    public function setReceipt(string $receipt): void
    {
        $this->receipt = $receipt;
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
