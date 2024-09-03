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

namespace Client;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Licensing\License;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\CheckLicenseClient;

final class CheckLicenseClientTest extends TestCase
{
    public function testBuildApiUrl(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $license = new License($application);

        $client = new CheckLicenseClient($license);

        $this->assertInstanceOf(CheckLicenseClient::class, $client);

        $this->assertSame('https://api.pushover.net/1/licenses.json?token=cccc3333CCCC3333dddd4444DDDD44', $client->buildApiUrl());
    }
}
