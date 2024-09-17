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

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\LogicException;
use Serhiy\Pushover\Recipient;

/**
 * @final since 1.7.0, real final in 2.0
 */
class UserGroupValidationClient extends Client implements ClientInterface
{
    public const API_PATH = 'users/validate.json';

    public function buildApiUrl(): string
    {
        return \sprintf(
            '%s/%s/%s',
            Curl::API_BASE_URL,
            Curl::API_VERSION,
            self::API_PATH,
        );
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @return array{token: string, user: string, device?: string}
     */
    public function buildCurlPostFields(Application $application, Recipient $recipient): array
    {
        $curlPostFields = [
            'token' => $application->getToken(),
            'user' => $recipient->getUserKey(),
        ];

        if (!empty($recipient->getDevices())) {
            if (\count($recipient->getDevices()) > 1) {
                throw new LogicException(sprintf('API can validate only 1 device at a time. "%s" devices provided.', \count($recipient->getDevices())));
            }

            $curlPostFields['device'] = $recipient->getDevicesCommaSeparated();
        }

        return $curlPostFields;
    }
}
