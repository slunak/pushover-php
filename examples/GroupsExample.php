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

namespace Serhiy\Pushover\Example;

use Serhiy\Pushover\Api\Groups\Group;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\AddUserToGroupResponse;
use Serhiy\Pushover\Client\Response\DisableUserInGroupResponse;
use Serhiy\Pushover\Client\Response\EnableUserInGroupResponse;
use Serhiy\Pushover\Client\Response\RemoveUserFromGroupResponse;
use Serhiy\Pushover\Client\Response\RenameGroupResponse;
use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;
use Serhiy\Pushover\Recipient;

/**
 * Work with groups example.
 *
 * @author Serhiy Lunak
 */
class GroupsExample
{
    public function groupsExample(): void
    {
        // instantiate pushover application and recipient (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // instantiate pushover group (can be injected into service using Dependency Injection)
        $group = new Group('replace_with_pushover_group_key', $application);

        // Use any valid key or placeholder ^[a-zA-Z0-9]{30}$ as group key to create new group
        $createGroupResponse = $group->create('Test');
        $newGroupKey = $createGroupResponse->getGroupKey();

        // Obtain list of all groups
        $listGroupsResponse = $group->list();
        /** @var array<string, string> $groups ['name' => 'key', 'name2' => 'key2'] */
        $groups = $listGroupsResponse->getGroups();

        // Retrieve information about the group from the API and populate the object with it.
        /** @var RetrieveGroupResponse $retrieveGroupResponse */
        $retrieveGroupResponse = $group->retrieveGroupInformation();

        // rename the group
        /** @var RenameGroupResponse $renameGroupResponse */
        $renameGroupResponse = $group->rename('Rename Group Test');

        // add user to the group
        $recipient->setMemo('This is a test memo'); // optional
        $recipient->addDevice('android'); // optional
        /** @var AddUserToGroupResponse $addUserToGroupResponse */
        $addUserToGroupResponse = $group->addUser($recipient);

        // remove user from the group
        /** @var RemoveUserFromGroupResponse $removeUserFromGroupResponse */
        $removeUserFromGroupResponse = $group->removeUser($recipient);

        // enable user
        /** @var EnableUserInGroupResponse $EnableUserInGroupResponse */
        $EnableUserInGroupResponse = $group->enableUser($recipient);

        // disable user
        /** @var DisableUserInGroupResponse $disableUserInGroupResponse */
        $disableUserInGroupResponse = $group->disableUser($recipient);

        // work with responses as usually
    }
}
