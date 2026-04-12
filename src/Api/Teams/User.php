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
final class User
{
    private ?string $id = null;
    private ?string $name = null;
    private ?string $password = null;
    private bool $instant = false;
    private bool $administrator = false;
    private ?string $group = null;

    /**
     * @var Device[]
     */
    private array $devices = [];

    public function __construct(
        private readonly string $email,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function isInstant(): bool
    {
        return $this->instant;
    }

    public function setInstant(bool $instant): void
    {
        $this->instant = $instant;
    }

    public function isAdministrator(): bool
    {
        return $this->administrator;
    }

    public function setIsAdministrator(bool $administrator): void
    {
        $this->administrator = $administrator;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function setGroup(?string $group): void
    {
        $this->group = $group;
    }

    /**
     * @return Device[]
     */
    public function getDevices(): array
    {
        return $this->devices;
    }

    public function addDevice(Device $device): void
    {
        $this->devices[] = $device;
    }
}
