<?php

/*
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
use Serhiy\Pushover\Client\Response\RemoveUserFromGroupResponse;
use Serhiy\Pushover\Client\Response\RenameGroupResponse;
use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

/**
 * Pushover Delivery Group.
 *
 * Delivery Groups allow broadcasting the same Pushover message to a number of different users at once with just a single group token,
 * used in place of a user token (or in place of specifying multiple user keys in every request). For situations where subscriptions are not appropriate,
 * or where automated manipulation of group members is required, such as changing an on-call notification group,
 * or syncing with an external directory system, our Groups API is available.
 *
 * @author Serhiy Lunak
 */
class Group
{
    /**
     * @var string Group key.
     */
    private $key;

    /**
     * @var Application Pushover application this group belongs to.
     */
    private $application;

    /**
     * @var string Name of the group.
     */
    private $name;

    /**
     * @var Recipient[] Group users.
     */
    private $users;

    /**
     * @param string $key Group key. (Use any valid key or placeholder e.g. str_repeat('0', 30) if you are creating a group)
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $key, Application $application)
    {
        if (1 != preg_match("/^[a-zA-Z0-9]{30}$/", $key)) {
            throw new InvalidArgumentException(sprintf('Group identifiers are 30 characters long, case-sensitive, and may contain the character set [A-Za-z0-9]. "%s" given."', $key));
        }

        $this->key = $key;
        $this->application = $application;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return Application
     */
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieves information about the group from the API and populates the object with it.
     *
     * @return RetrieveGroupResponse
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

    /**
     * Create a group.
     */
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

    /**
     * Adds an existing Pushover user to your Delivery Group.
     *
     * @param Recipient $recipient
     * @return AddUserToGroupResponse
     */
    public function addUser(Recipient $recipient)
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
     *
     * @param Recipient $recipient
     * @return RemoveUserFromGroupResponse
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
     *
     * @param Recipient $recipient
     * @return EnableUserInGroupResponse
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
     *
     * @param Recipient $recipient
     * @return DisableUserInGroupResponse
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

    /**
     * Renames the group. Reflected in the API and in the group editor on our website.
     *
     * @param string $name
     * @return RenameGroupResponse
     */
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
