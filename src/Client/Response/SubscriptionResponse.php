<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @author Serhiy Lunak
 */
class SubscriptionResponse extends Response
{
    /**
     * @var string applications that formerly collected Pushover user keys are encouraged to migrate to subscription keys
     */
    private $subscribed_user_key;

    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    public function getSubscribedUserKey(): string
    {
        return $this->subscribed_user_key;
    }

    /**
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() == 1) {
            $this->subscribed_user_key = $decodedCurlResponse->subscribed_user_key;
        }
    }
}
