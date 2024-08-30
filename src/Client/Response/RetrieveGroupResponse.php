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
use Serhiy\Pushover\Recipient;

/**
 * @phpstan-type GroupUser object{user: string, device: null|string, memo: string, disabled: bool}
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 *
 * @final since 1.7.0, real final in 2.0
 */
class RetrieveGroupResponse extends Response
{
    /**
     * Name of the group.
     */
    private string $name;

    /**
     * @var Recipient[] Group users
     */
    private array $users;

    public function __construct(string $curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Recipient[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    private function processCurlResponse(string $curlResponse): void
    {
        /**
         * @var object{status: int, request: string, name: string, users: list<GroupUser>} $decodedCurlResponse
         */
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() === 1) {
            $this->name = $decodedCurlResponse->name;
            $this->users = $this->setUsers($decodedCurlResponse->users);
        }
    }

    /**
     * @param list<GroupUser> $users
     *
     * @return Recipient[]
     */
    private function setUsers(array $users): array
    {
        $recipients = [];

        foreach ($users as $user) {
            $recipient = new Recipient($user->user);

            if (!empty($user->device)) {
                $recipient->addDevice($user->device);
            }

            if (!empty($user->memo)) {
                $recipient->setMemo($user->memo);
            }

            if ($user->disabled) {
                $recipient->setIsDisabled(true);
            }

            $recipients[] = $recipient;
        }

        return $recipients;
    }
}
