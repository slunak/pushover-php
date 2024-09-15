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

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 *
 * @final since 1.7.0, real final in 2.0
 */
class UserGroupValidationResponse extends Response
{
    private ?bool $isGroup = null;

    /**
     * @var array<string>
     */
    private array $devices = [];

    /**
     * @var array<string>
     */
    private array $licenses = [];

    public function __construct(string $curlResponse)
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

    private function processCurlResponse(string $curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() === 1) {
            $this->devices = $decodedCurlResponse->devices;
            $this->licenses = $decodedCurlResponse->licenses;

            if ($decodedCurlResponse->group === 1) {
                $this->isGroup = true;
            }

            if ($decodedCurlResponse->group === 0) {
                $this->isGroup = false;
            }
        }
    }
}
