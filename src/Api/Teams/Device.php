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

namespace Serhiy\Pushover\Api\Teams;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final readonly class Device
{
    public function __construct(
        private string $name,
        private string $os,
        private string $osVersion,
        private bool $enabled,
        private bool $administrativelyDisabled,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOs(): string
    {
        return $this->os;
    }

    public function getOsVersion(): string
    {
        return $this->osVersion;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function isAdministrativelyDisabled(): bool
    {
        return $this->administrativelyDisabled;
    }
}
