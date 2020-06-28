<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient\UserGroupValidation;

use Serhiy\Pushover\ApiClient\Response;

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

    public function __construct()
    {
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
}
