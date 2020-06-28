<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient;

use Serhiy\Pushover\Exception\LogicException;

/**
 * Contains API related constants and performs curl request.
 *
 * @author Serhiy Lunak
 */
class CurlHelper
{
    /**
     * API base URL.
     */
    const API_BASE_URL = 'https://api.pushover.net';

    /**
     * API version.
     */
    const API_VERSION = '1';

    /**
     * Performs curl request.
     *
     * @param Request $request
     * @return mixed
     */
    public static function post(Request $request)
    {
        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => $request->getApiUrl(),
            CURLOPT_POSTFIELDS => $request->getCurlPostFields(),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $curlResponse = curl_exec($ch);
        curl_close($ch);

        if (false === $curlResponse) {
            throw new LogicException('Curl request failed.');
        }

        if (true === $curlResponse) {
            throw new LogicException('Curl should return json encoded string because CURLOPT_RETURNTRANSFER is set, "true" returned instead.');
        }

        return $curlResponse;
    }
}
