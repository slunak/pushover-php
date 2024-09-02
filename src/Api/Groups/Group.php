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

namespace Serhiy\Pushover\Api\Groups;

use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\GroupsClient;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\AddUserToGroupResponse;
use Serhiy\Pushover\Client\Response\CreateGroupResponse;
use Serhiy\Pushover\Client\Response\DisableUserInGroupResponse;
use Serhiy\Pushover\Client\Response\EnableUserInGroupResponse;
use Serhiy\Pushover\Client\Response\ListGroupsResponse;
use Serhiy\Pushover\Client\Response\RemoveUserFromGroupResponse;
use Serhiy\Pushover\Client\Response\RenameGroupResponse;
use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

/**
 * Pushover Delivery Group.
 *
 * Delivery Groups allow broadcasting the same Pushover message to a number of
 * different users at once with just a single group token, used in place of a
 * user token (or in place of specifying multiple user keys in every request).
 * For situations where subscriptions are not appropriate, or where automated
 * manipulation of group members is required, such as changing an on-call
 * notification group, or syncing with an external directory system, our Groups
 * API is available.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 *
 * @final since 1.7.0, real final in 2.0
 */
class Group
{
    /**
     * Name of the group.
     */
    private string $name;

    /**
     * @var Recipient[] group users
     */
    private array $users;

    /**
     * @param string $key Group key. (Use any valid key or placeholder e.g. str_repeat('0', 30) if you are creating a group)
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly string $key,
        private readonly Application $application,
    ) {
        if (1 !== preg_match('/^[a-zA-Z0-9]{30}$/', $key)) {
            throw new InvalidArgumentException(sprintf('Group identifiers are 30 characters long, case-sensitive, and may contain the character set [A-Za-z0-9]. "%s" given."', $key));
        }
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @return Recipient[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieves information about the group from the API and populates the object with it.
     */
    public function retrieveGroupInformation(): RetrieveGroupResponse
    {
        $client = new GroupsClient($this, GroupsClient::ACTION_RETRIEVE_GROUP);
        $request = new Request($client->buildApiUrl(), Request::GET);

        $curlResponse = Curl::do($request);

        $response = new RetrieveGroupResponse($curlResponse);
        $response->setRequest($request);

        if ($response->isSuccessful()) {
            $this->name = $response->getName();
            $this->users = $response->getUsers();
        }

        return $response;
    }

    public function create(string $name): CreateGroupResponse
    {
        $this->name = $name;

        $client = new GroupsClient($this, GroupsClient::ACTION_CREATE_GROUP);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields());

        $curlResponse = Curl::do($request);

        $response = new CreateGroupResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    public function list(): ListGroupsResponse
    {
        $client = new GroupsClient($this, GroupsClient::ACTION_LIST_GROUPS);
        $request = new Request($client->buildApiUrl(), Request::GET);

        $curlResponse = Curl::do($request);

        $response = new ListGroupsResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Adds an existing Pushover user to your Delivery Group.
     */
    public function addUser(Recipient $recipient): AddUserToGroupResponse
    {
        $client = new GroupsClient($this, GroupsClient::ACTION_ADD_USER);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($recipient));

        $curlResponse = Curl::do($request);

        $response = new AddUserToGroupResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Removes user to from Delivery Group.
     */
    public function removeUser(Recipient $recipient): RemoveUserFromGroupResponse
    {
        $client = new GroupsClient($this, GroupsClient::ACTION_REMOVE_USER);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($recipient));

        $curlResponse = Curl::do($request);

        $response = new RemoveUserFromGroupResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Enables user in Delivery Group.
     */
    public function enableUser(Recipient $recipient): EnableUserInGroupResponse
    {
        $client = new GroupsClient($this, GroupsClient::ACTION_ENABLE_USER);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($recipient));

        $curlResponse = Curl::do($request);

        $response = new EnableUserInGroupResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Disables user in Delivery Group.
     */
    public function disableUser(Recipient $recipient): DisableUserInGroupResponse
    {
        $client = new GroupsClient($this, GroupsClient::ACTION_DISABLE_USER);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($recipient));

        $curlResponse = Curl::do($request);

        $response = new DisableUserInGroupResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    public function rename(string $name): RenameGroupResponse
    {
        $this->name = $name;

        $client = new GroupsClient($this, GroupsClient::ACTION_RENAME_GROUP);
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields());

        $curlResponse = Curl::do($request);

        $response = new RenameGroupResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
