<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Subscription;

use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\SubscriptionResponse;
use Serhiy\Pushover\Client\SubscriptionClient;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class Subscription
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var string
     */
    private $subscriptionCode;

    public function __construct(Application $application, string $subscriptionCode)
    {
        $this->application = $application;
        $this->subscriptionCode = $subscriptionCode;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @return string
     */
    public function getSubscriptionCode(): string
    {
        return $this->subscriptionCode;
    }

    /**
     * @param Recipient $recipient
     * @param Sound|null $sound
     * @return SubscriptionResponse
     */
    public function migrate(Recipient $recipient, Sound $sound = null): SubscriptionResponse
    {
        $client = new SubscriptionClient();
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this, $recipient, $sound));

        $curlResponse = Curl::do($request);

        $response = new SubscriptionResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
