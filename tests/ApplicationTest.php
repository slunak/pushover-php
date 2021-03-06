<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Serhiy\Pushover\Application;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Exception\InvalidArgumentException;

class ApplicationTest extends TestCase
{
    /**
     * @return Application
     */
    public function testCanBeCreated(): Application
    {
        $application = new Application("cccc3333CCCC3333dddd4444DDDD44");

        $this->assertInstanceOf(Application::class, $application);

        return $application;
    }

    public function testCannotBeCreated()
    {
        $this->expectException(InvalidArgumentException::class);
        new Application("Lorem ipsum dolor sit amet");
    }

    public function testCannotBeCreatedFromInvalidApiToken(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Application("this-is-invalid-token");
    }

    public function testCannotBeCreatedFromShortApiToken(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Application("token");
    }

    /**
     * @depends testCanBeCreated
     * @param Application $application
     */
    public function testGetToken(Application $application)
    {
        $this->assertEquals("cccc3333CCCC3333dddd4444DDDD44", $application->getToken());
    }
}
