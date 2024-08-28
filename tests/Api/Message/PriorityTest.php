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
    public function testCanBeCreated(): Priority
    {
        $priority = new Priority();

        $this->assertInstanceOf(Priority::class, $priority);

        return $priority;
    }

    public function testCanBeCreatedWithNormalPriority(): void
    {
        $priority = new Priority(Priority::NORMAL);

        $this->assertInstanceOf(Priority::class, $priority);
    }

    public function testCanBeCreatedWithEmergencyPriority(): Priority
    {
        $priority = new Priority(Priority::EMERGENCY, 30, 600);

        $this->assertInstanceOf(Priority::class, $priority);

        return $priority;
    }

    public function testCannotBeCreatedWithInvalidPriority(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Priority(10);
    }

    public function testEmergencyPriorityRequiresExtraParams(): void
    {
        $this->expectException(LogicException::class);

        new Priority(Priority::EMERGENCY);
    }

    /**
     * @depends testCanBeCreatedWithEmergencyPriority
     */
    public function testSetCallback(Priority $priority): Priority
    {
        $priority->setCallback('https://callback.example.com');

        $this->assertInstanceOf(Priority::class, $priority);

        return $priority;
    }

    /**
     * @depends testSetCallback
     */
    public function testGetCallback(Priority $priority): void
    {
        $this->assertSame('https://callback.example.com', $priority->getCallback());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testAvailablePriorities(Priority $priority): void
    {
        $availablePriorities = new \ReflectionClass(Priority::class);

        $this->assertEquals($availablePriorities->getConstants(), $priority->getAvailablePriorities());
    }
}
