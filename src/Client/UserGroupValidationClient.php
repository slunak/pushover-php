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

use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\LogicException;
use Serhiy\Pushover\Recipient;

class UserGroupValidationClient extends Client implements ClientInterface
{
    public const API_PATH = 'users/validate.json';

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
    public function buildCurlPostFields(Application $application, Recipient $recipient): array
    {
        $curlPostFields = [
            'token' => $application->getToken(),
            'user' => $recipient->getUserKey(),
        ];

        if (!empty($recipient->getDevice())) {
            if (\count($recipient->getDevice()) > 1) {
                throw new LogicException(sprintf('Api can validate only 1 device at a time. "%s" devices provided.', \count($recipient->getDevice())));
            }

            $curlPostFields['device'] = $recipient->getDeviceListCommaSeparated();
        }

        return $curlPostFields;
    }
}
