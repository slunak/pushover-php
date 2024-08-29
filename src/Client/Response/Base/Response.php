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

namespace Serhiy\Pushover\Client\Response\Base;

use Serhiy\Pushover\Client\Request\Request;

/**
 * Response represents response object.
 *
 * If your POST request to our API was valid, you will receive an HTTP 200 (OK) status,
 * with a JSON object containing a status code of 1. If any input was invalid, you will receive an HTTP 4xx status,
 * with a JSON object containing a status code of something other than 1, and an errors array detailing which parameters were invalid.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class Response
{
    /**
     * True if request was successful, false otherwise. Reflects $requestStatus property.
     */
    private bool $successful;

    /**
     * Either 1 if successful or something other than 1 if unsuccessful. Reflects $successful property.
     */
    private int $requestStatus;

    /**
     * Randomly generated unique token that we have associated with your request.
     */
    private string $requestToken;

    /**
     * Original curl response in json format.
     * Original, unmodified response from curl request.
     */
    private string $curlResponse;

    /**
     * Array detailing which parameters were invalid.
     *
     * @var array<int, string>
     */
    private array $errors = [];

    /**
     * The original request.
     */
    private Request $request;

    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    public function getRequestStatus(): int
    {
        return $this->requestStatus;
    }

    public function getRequestToken(): string
    {
        return $this->requestToken;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getCurlResponse(): string
    {
        return $this->curlResponse;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * Processes initial curl response, common to all response objects.
     */
    protected function processInitialCurlResponse(string $curlResponse): object
    {
        $this->curlResponse = $curlResponse;

        /** @var object{status: int, request: string, errors: string[]} $decodedCurlResponse */
        $decodedCurlResponse = json_decode($curlResponse);

        $this->requestStatus = $decodedCurlResponse->status;
        $this->requestToken = $decodedCurlResponse->request;

        if ($this->getRequestStatus() === 1) {
            $this->successful = true;
            $this->requestToken = $decodedCurlResponse->request;
        } else {
            $this->errors = $decodedCurlResponse->errors;
            $this->successful = false;
        }

        return $decodedCurlResponse;
    }
}
