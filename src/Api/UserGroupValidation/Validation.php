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

use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\UserGroupValidationResponse;
use Serhiy\Pushover\Client\UserGroupValidationClient;
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

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * Validates recipient and its device, and returns Response object.
     *
     * @param Recipient $recipient
     * @return UserGroupValidationResponse
     */
    public function validate(Recipient $recipient): UserGroupValidationResponse
    {
        $client = new UserGroupValidationClient();
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this->application, $recipient));

        $curlResponse = Curl::do($request);

        $response = new UserGroupValidationResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
