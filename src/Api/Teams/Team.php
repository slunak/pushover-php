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

use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\AddUserToTeamResponse;
use Serhiy\Pushover\Client\Response\RemoveUserFromTeamResponse;
use Serhiy\Pushover\Client\Response\RetrieveTeamResponse;
use Serhiy\Pushover\Client\TeamsClient;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * Pushover Team.
 *
 * Team administrators can make automated changes to team membership through
 * the Teams API using a team API token.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class Team
{
    private ?string $name = null;

    /**
     * @var User[]
     */
    private array $users = [];

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly string $token,
    ) {
        if (1 !== preg_match('/^[a-zA-Z0-9]{30}$/', $token)) {
            throw new InvalidArgumentException(sprintf('Team API tokens are case-sensitive, 30 characters long, and may contain the character set [A-Za-z0-9]. "%s" given with "%s" characters."', $token, \strlen($token)));
        }
    }

    public function getToken(): string
    {
        return $this->token;
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

    /**
     * Retrieves information about the team from the API and populates the object with it.
     */
    public function retrieveTeamInformation(): RetrieveTeamResponse
    {
        $client = new TeamsClient($this, TeamsClient::ACTION_RETRIEVE_TEAM);
        $request = new Request($client->buildApiUrl(), Request::GET);

        $curlResponse = Curl::do($request);

        $response = new RetrieveTeamResponse($curlResponse);
        $response->setRequest($request);

        if ($response->isSuccessful()) {
            $this->name = $response->getName();
            $this->users = $response->getUsers();
        }

        return $response;
    }

    public function addUser(User $user): AddUserToTeamResponse
    {
        $client = new TeamsClient($this, TeamsClient::ACTION_ADD_USER);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($user));

        $curlResponse = Curl::do($request);

        $response = new AddUserToTeamResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    public function removeUser(User $user): RemoveUserFromTeamResponse
    {
        $client = new TeamsClient($this, TeamsClient::ACTION_REMOVE_USER);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($user));

        $curlResponse = Curl::do($request);

        $response = new RemoveUserFromTeamResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
