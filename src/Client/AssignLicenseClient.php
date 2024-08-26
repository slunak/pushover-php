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

use Serhiy\Pushover\Api\Licensing\License;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\LogicException;

/**
 * @author Serhiy Lunak
 */
class AssignLicenseClient extends Client implements ClientInterface
{
    public const API_PATH = 'licenses/assign.json';

    public function buildApiUrl(): string
    {
        return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/'.self::API_PATH;
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @return array<string, string>
     */
    public function buildCurlPostFields(License $license): array
    {
        if (!$license->canBeAssigned()) {
            throw new LogicException('License cannot be assigned because neither recipient nor email is set.');
        }

        $curlPostFields = [
            'token' => $license->getApplication()->getToken(),
        ];

        $recipient = $license->getRecipient();

        if (null !== $recipient) {
            $curlPostFields['user'] = $recipient->getUserKey();
        }

        $email = $license->getEmail();

        if (null !== $email) {
            $curlPostFields['email'] = $email;
        }

        $os = $license->getOs();

        if (null !== $os) {
            $curlPostFields['os'] = $os;
        }

        return $curlPostFields;
    }
}
