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
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class RetrieveGroupResponse extends Response
{
    /**
     * @var string name of the group
     */
    private $name;

    /**
     * @var Recipient[] array of group users of Recipient object
     */
    private $users;

    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
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

    /**
     * Processes curl response.
     *
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() == 1) {
            $this->name = $decodedCurlResponse->name;
            $this->users = $this->setUsers($decodedCurlResponse->users);
        }
    }

    /**
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
