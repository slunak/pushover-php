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

namespace Serhiy\Pushover\Client\Curl;

use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Exception\LogicException;

/**
 * Contains API related constants and performs curl request.
 *
 * @author Serhiy Lunak
 */
class Curl
{
    public const API_BASE_URL = 'https://api.pushover.net';

    public const API_VERSION = '1';

    /**
     * Performs curl request.
     *
     * @return false|string
     */
    public static function do(Request $request)
    {
        $curlOptions = [
            \CURLOPT_URL => $request->getApiUrl(),
            \CURLOPT_RETURNTRANSFER => true,
        ];

        if (null !== $request->getCurlPostFields()) {
            $curlOptions[\CURLOPT_POSTFIELDS] = $request->getCurlPostFields();
        }

        curl_setopt_array($ch = curl_init(), $curlOptions);

        $curlResponse = curl_exec($ch);

        if (false === $curlResponse) {
            throw new LogicException('Curl request failed. Curl error: '.curl_error($ch));
        }

        if (true === $curlResponse) {
            throw new LogicException('Curl should return json encoded string because CURLOPT_RETURNTRANSFER is set, "true" returned instead.');
        }

        curl_close($ch);

        return $curlResponse;
    }
}
