<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class ApplicationTest extends TestCase
{
    public function testCanBeCreatedFromValidApiToken(): void
    {
        $this->assertInstanceOf(
            Application::class,
            new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi")
        );
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
}
