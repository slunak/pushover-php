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
     * @var bool
     */
    private $isGroup;

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

        if (1 == $this->getRequestStatus()) {
            $this->setDevices($decodedCurlResponse->devices);
            $this->setLicenses($decodedCurlResponse->licenses);

            if (1 == $decodedCurlResponse->group) {
                $this->setIsGroup(true);
            }

            if (0 == $decodedCurlResponse->group) {
                $this->setIsGroup(false);
            }
        }
    }
}
