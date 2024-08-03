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

use Serhiy\Pushover\Api\Groups\Group;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\RetrieveGroupResponse;

/**
 * @author Serhiy Lunak
 */
class GroupTest extends TestCase
{
    /**
     * @return Group
     */
    public function testCanBeCreated(): Group
    {
        $application = new Application("cccc3333CCCC3333dddd4444DDDD44"); // using dummy token
        $group = new Group("eeee5555EEEE5555ffff6666FFFF66", $application); // using dummy group key

        $this->assertInstanceOf(Group::class, $group);

        return $group;
    }

    /**
     * @depends testCanBeCreated
     * @param Group $group
     */
    public function testGetApplication(Group $group)
    {
        $this->assertInstanceOf(Application::class, $group->getApplication());
        $this->assertEquals("cccc3333CCCC3333dddd4444DDDD44", $group->getApplication()->getToken());
    }

    /**
     * @depends testCanBeCreated
     * @param Group $group
     */
    public function testGetKey(Group $group)
    {
        $this->assertEquals("eeee5555EEEE5555ffff6666FFFF66", $group->getKey());
    }

    /**
     * @group Integration
     */
    public function testRetrieveGroupInformation()
    {
        $application = new Application("cccc3333CCCC3333dddd4444DDDD44"); // using dummy token
        $group = new Group("eeee5555EEEE5555ffff6666FFFF66", $application);

        $response = $group->retrieveGroupInformation();

        $this->assertInstanceOf(RetrieveGroupResponse::class, $response);
    }
    
    /**
     * 
     */
    public function testCreate() {
        $application = new Application("cccc3333CCCC3333dddd4444DDDD44"); // using dummy token
        $group = new Group("eeee5555EEEE5555ffff6666FFFF66", $application);

        $response = $group->create('test');

        $this->assertInstanceOf(CreateGroupResponse::class, $response);
    }
    
}
