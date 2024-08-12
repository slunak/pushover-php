<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Api\Subscription\Subscription;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\LogicException;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class SubscriptionClient extends Client implements ClientInterface
{
    public const API_PATH = 'subscriptions/migrate.json';

    /**
     * {@inheritDoc}
     */
    public function buildApiUrl()
    {
        return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/'.self::API_PATH;
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @return array[]
     */
    public function buildCurlPostFields(Subscription $subscription, Recipient $recipient, Sound $sound = null): array
    {
        $curlPostFields = [
            'token' => $subscription->getApplication()->getToken(),
            'subscription' => $subscription->getSubscriptionCode(),
            'user' => $recipient->getUserKey(),
        ];

        if (!empty($recipient->getDevice())) {
            if (\count($recipient->getDevice()) > 1) {
                throw new LogicException(sprintf('Only one device is supported. "%s" devices provided.', \count($recipient->getDevice())));
            }

            $curlPostFields['device_name'] = $recipient->getDeviceListCommaSeparated();
        }

        if (null !== $sound) {
            $curlPostFields['sound'] = $sound->getSound();
        }

        return $curlPostFields;
    }
}
