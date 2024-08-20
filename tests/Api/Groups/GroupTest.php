<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Groups;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Groups\Group;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\CreateGroupResponse;
use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;
use Serhiy\Pushover\Client\Response\ListGroupsResponse;

/**
 * @author Serhiy Lunak
 */
class GroupTest extends TestCase
{
    public function testCanBeCreated(): Group
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key

        $this->assertInstanceOf(Group::class, $group);

        return $group;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetApplication(Group $group): void
    {
        $this->assertInstanceOf(Application::class, $group->getApplication());
        $this->assertEquals('cccc3333CCCC3333dddd4444DDDD44', $group->getApplication()->getToken());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetKey(Group $group): void
    {
        $this->assertEquals('eeee5555EEEE5555ffff6666FFFF66', $group->getKey());
    }

    /**
     * @group Integration
     */
    public function testRetrieveGroupInformation(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application);

        $response = $group->retrieveGroupInformation();

        $this->assertInstanceOf(RetrieveGroupResponse::class, $response);
    }

    /**
     * @group Integration
     */
    public function testCreate(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application);

        $response = $group->create('unit test '.date('Y-m-d H:i:s'));

        $this->assertInstanceOf(CreateGroupResponse::class, $response);
    }
    
    /**
     * @group Integration
     */
    public function testList()
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application);

        $response = $group->list();

        $this->assertInstanceOf(ListGroupsResponse::class, $response);
    }    
    
}
