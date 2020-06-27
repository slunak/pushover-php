<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\UserGroupValidation;

use Serhiy\Pushover\ApiClient\Request;
use Serhiy\Pushover\ApiClient\UserGroupValidation\UserGroupValidationClient;
use Serhiy\Pushover\ApiClient\UserGroupValidation\UserGroupValidationResponse;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

/**
 * As an optional step in collecting user keys for users of your application, you may validate those keys to ensure that
 * a user has copied them properly,that the account is valid, and that there is at least one active device on the account.
 *
 * @author Serhiy Lunak
 */
class Validation
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var Recipient
     */
    private $recipient;

    public function __construct(Application $application, Recipient $recipient)
    {
        $this->application = $application;
        $this->recipient = $recipient;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @return Recipient
     */
    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    /**
     * Validates recipient and its device, and returns Response object.
     *
     * @return UserGroupValidationResponse
     */
    public function validateRecipient(): UserGroupValidationResponse
    {
        $client = new UserGroupValidationClient();
        $request = new Request($client->buildApiUrl(), $client->buildCurlPostFields($this->application, $this->recipient));

        return $client->send($request);
    }
}
