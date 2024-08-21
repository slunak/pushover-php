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
    private bool $isGroup;

    /**
     * @var array<string>
     */
    private array $devices;

    /**
     * @var array<string>
     */
    private array $licenses;

    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    public function isGroup(): bool
    {
        return $this->isGroup;
    }

    /**
     * @return array<string>
     */
    public function getDevices(): array
    {
        return $this->devices;
    }

    /**
     * @return array<string>
     */
    public function getLicenses(): array
    {
        return $this->licenses;
    }

    private function setIsGroup(bool $isGroup): void
    {
        $this->isGroup = $isGroup;
    }

    /**
     * @param array<string> $devices
     */
    private function setDevices(array $devices): void
    {
        $this->devices = $devices;
    }

    /**
     * @param array<string> $licenses
     */
    private function setLicenses(array $licenses): void
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
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() == 1) {
            $this->setDevices($decodedCurlResponse->devices);
            $this->setLicenses($decodedCurlResponse->licenses);

            if ($decodedCurlResponse->group == 1) {
                $this->setIsGroup(true);
            }

            if ($decodedCurlResponse->group == 0) {
                $this->setIsGroup(false);
            }
        }
    }
}
