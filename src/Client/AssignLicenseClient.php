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
    public function buildCurlPostFields(License $license): array
    {
        if (!$license->canBeAssigned()) {
            throw new LogicException('License cannot be assigned because neither recipient nor email is set.');
        }

        $curlPostFields = [
            'token' => $license->getApplication()->getToken(),
        ];

        if (null !== $license->getRecipient()) {
            $curlPostFields['user'] = $license->getRecipient()->getUserKey();
        }

        if (null !== $license->getEmail()) {
            $curlPostFields['email'] = $license->getEmail();
        }

        if (null !== $license->getOs()) {
            $curlPostFields['os'] = $license->getOs();
        }

        return $curlPostFields;
    }
}
