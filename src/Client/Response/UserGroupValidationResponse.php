<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @author Serhiy Lunak
 */
class UserGroupValidationResponse extends Response
{
    /**
     * @var array<string>
     */
    private $devices;

    /**
     * @var array<string>
     */
    private $licenses;

    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    /**
     * @return array<string>
     */
    public function getDevices(): array
    {
        return $this->devices;
    }

    /**
     * @param array<string> $devices
     */
    public function setDevices(array $devices): void
    {
        $this->devices = $devices;
    }

    /**
     * @return array<string>
     */
    public function getLicenses(): array
    {
        return $this->licenses;
    }

    /**
     * @param array<string> $licenses
     */
    public function setLicenses(array $licenses): void
    {
        $this->licenses = $licenses;
    }

    /**
     * Processes curl response.
     *
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $decodedCurlResponse = json_decode($curlResponse);

        $this->setRequestStatus($decodedCurlResponse->status);
        $this->setRequestToken($decodedCurlResponse->request);
        $this->setCurlResponse($curlResponse);

        if ($this->getRequestStatus() == 1) {
            $this->setIsSuccessful(true);
            $this->setDevices($decodedCurlResponse->devices);
            $this->setLicenses($decodedCurlResponse->licenses);
        }

        if ($this->getRequestStatus() != 1) {
            $this->setErrors($decodedCurlResponse->errors);
            $this->setIsSuccessful(false);
        }
    }
}
