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
 */
class Response
{
    /**
     * Either 1 if successful or something other than 1 if unsuccessful.
     *
     * @var int
     */
    private $status;

    /**
     * Randomly-generated unique token that we have associated with your request.
     *
     * @var string
     */
    private $request;

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
     * Array detailing which parameters were invalid.
     *
     * @var array
     */
    private $errors;

    public function __construct(int $status, string $request)
    {
        $this->status = $status;
        $this->request = $request;
        $this->errors = array();
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
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
}
