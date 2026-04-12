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

use Serhiy\Pushover\Api\Teams\Device;
use Serhiy\Pushover\Api\Teams\User;
use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @phpstan-type TeamDevice object{name: string, os: string, os_version: string, enabled: bool, administratively_disabled: bool}
 * @phpstan-type TeamUser object{id: string, name: string, email: string, administrator: bool, devices: list<TeamDevice>}
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class RetrieveTeamResponse extends Response
{
    private ?string $name = null;

    /**
     * @var User[]
     */
    private array $users = [];

    public function __construct(string $curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    private function processCurlResponse(string $curlResponse): void
    {
        /**
         * @var object{status: int, request: string, name: string, users: list<TeamUser>} $decodedCurlResponse
         */
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() === 1) {
            $this->name = $decodedCurlResponse->name;
            $this->users = $this->setUsers($decodedCurlResponse->users);
        }
    }

    /**
     * @param list<TeamUser> $users
     *
     * @return User[]
     */
    private function setUsers(array $users): array
    {
        $teamUsers = [];

        foreach ($users as $user) {
            $teamUser = new User($user->email);
            $teamUser->setId($user->id);
            $teamUser->setName($user->name);
            $teamUser->setIsAdministrator($user->administrator);

            foreach ($user->devices as $device) {
                $teamUser->addDevice(new Device(
                    $device->name,
                    $device->os,
                    $device->os_version,
                    $device->enabled,
                    $device->administratively_disabled,
                ));
            }

            $teamUsers[] = $teamUser;
        }

        return $teamUsers;
    }
}
