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

namespace Api\UserGroupValidation;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\UserGroupValidation\Validation;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\UserGroupValidationResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class ValidationTest extends TestCase
{
    public function testCanBeConstructed(): Validation
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $validation = new Validation($application);

        $this->assertInstanceOf(Validation::class, $validation);

        return $validation;
    }

    /**
     * @depends testCanBeConstructed
     */
    public function testGetApplication(Validation $validation): void
    {
        $this->assertInstanceOf(Application::class, $validation->getApplication());
        $this->assertEquals('cccc3333CCCC3333dddd4444DDDD44', $validation->getApplication()->getToken());
    }

    /**
     * @group Integration
     */
    public function testValidate(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $validation = new Validation($application);
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        $response = $validation->validate($recipient);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
    }
}
