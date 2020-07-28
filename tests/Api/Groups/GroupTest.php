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
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $group = new Group("uoJCttEFQo8uoZ6REZHMGBjX2pmcdJ", $application); // using dummy group key

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
        $this->assertEquals("zaGDORePK8gMaC0QOYAMyEEuzJnyUi", $group->getApplication()->getToken());
    }

    /**
     * @depends testCanBeCreated
     * @param Group $group
     */
    public function testGetKey(Group $group)
    {
        $this->assertEquals("uoJCttEFQo8uoZ6REZHMGBjX2pmcdJ", $group->getKey());
    }
}
