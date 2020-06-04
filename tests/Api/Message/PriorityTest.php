<?php

/*
 * This file is part of the Pushover package.
 *
 *  (c) Serhiy Lunak <https://github.com/slunak>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Exception\LogicException;

/**
 * @author Serhiy Lunak
 */
class PriorityTest extends TestCase
{
    public function testCanBeCreatedWithNormalPriority()
    {
        $priority = new Priority(Priority::NORMAL);

        $this->assertInstanceOf(Priority::class, $priority);
    }

    public function testCanBeCreatedWithEmergencyPriority()
    {
        $priority = new Priority(Priority::EMERGENCY, 30, 600);

        $this->assertInstanceOf(Priority::class, $priority);
    }

    public function testCannotBeCreatedWithInvalidPriority()
    {
        $this->expectException(InvalidArgumentException::class);

        new Priority(10);
    }

    public function testEmergencyPriorityRequiresExtraParams()
    {
        $this->expectException(LogicException::class);

        new Priority(Priority::EMERGENCY);
    }
}
