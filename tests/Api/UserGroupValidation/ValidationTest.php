<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\UserGroupValidation;

use Serhiy\Pushover\Api\UserGroupValidation\Validation;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\UserGroupValidationResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class ValidationTest extends TestCase
{
    /**
     * @return Validation
     */
    public function testCanBeCreated(): Validation
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $validation = new Validation($application);

        $this->assertInstanceOf(Validation::class, $validation);

        return $validation;
    }

    /**
     * @depends testCanBeCreated
     * @param Validation $validation
     */
    public function testGetApplication(Validation $validation)
    {
        $this->assertInstanceOf(Application::class, $validation->getApplication());
        $this->assertEquals("zaGDORePK8gMaC0QOYAMyEEuzJnyUi", $validation->getApplication()->getToken());
    }

    /**
     * @depends testCanBeCreated
     * @param Validation $validation
     */
    public function testValidateRecipient(Validation $validation)
    {
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $response = $validation->validate($recipient);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
    }
}
