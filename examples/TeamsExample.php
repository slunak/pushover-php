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

use Serhiy\Pushover\Api\Teams\Team;
use Serhiy\Pushover\Api\Teams\User;
use Serhiy\Pushover\Client\Response\AddUserToTeamResponse;
use Serhiy\Pushover\Client\Response\RemoveUserFromTeamResponse;
use Serhiy\Pushover\Client\Response\RetrieveTeamResponse;

/**
 * Working with teams.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class TeamsExample
{
    public function teamsExample(): void
    {
        // instantiate pushover team (can be injected into service using Dependency Injection)
        $team = new Team('replace_with_pushover_team_api_token');

        // retrieve information about the team from the API and populate the object with it
        /** @var RetrieveTeamResponse $retrieveTeamResponse */
        $retrieveTeamResponse = $team->retrieveTeamInformation();

        // add a user to the team
        $user = new User('an email address of the user to add'); // required
        $user->setName('Example User'); // optional
        $user->setPassword('replace_with_password'); // optional
        $user->setInstant(true); // optional
        $user->setIsAdministrator(true); // optional
        $user->setGroup('Operations'); // optional

        /** @var AddUserToTeamResponse $addUserToTeamResponse */
        $addUserToTeamResponse = $team->addUser($user);

        // remove a user from the team
        /** @var RemoveUserFromTeamResponse $removeUserFromTeamResponse */
        $removeUserFromTeamResponse = $team->removeUser($user);

        // work with responses as usually
    }
}
