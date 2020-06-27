<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient\UserGroupValidation;

use Serhiy\Pushover\ApiClient\ClientInterface;
use Serhiy\Pushover\ApiClient\CurlHelper;
use Serhiy\Pushover\ApiClient\Request;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Exception\LogicException;
use Serhiy\Pushover\Recipient;

class UserGroupValidationClient implements ClientInterface
{
    const API_PATH = "users/validate.json";

    /**
     * @inheritDoc
     */
    public function buildApiUrl()
    {
        return CurlHelper::API_BASE_URL."/".CurlHelper::API_VERSION."/".self::API_PATH;
    }

    /**
     * @inheritDoc
     * @return UserGroupValidationResponse
     */
    public function send(Request $request): UserGroupValidationResponse
    {
        $curlResponse = CurlHelper::post($request);

        $response = $this->processCurlResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @param Application $application
     * @param Recipient $recipient
     * @return array
     */
    public function buildCurlPostFields(Application $application, Recipient $recipient)
    {
        $curlPostFields = array(
            "token" => $application->getToken(),
            "user" => $recipient->getUserKey(),
        );

        if (null !== $recipient->getDevice()) {
            if (count($recipient->getDevice()) > 1) {
                throw new LogicException(sprintf('Api can validate only 1 device at a time. "%s" devices provided.', count($recipient->getDevice())));
            }

            $curlPostFields['device'] = $recipient->getDeviceListCommaSeparated();
        }

        return $curlPostFields;
    }

    /**
     * Processes curl response.
     *
     * @param mixed $curlResponse
     * @return UserGroupValidationResponse
     */
    private function processCurlResponse($curlResponse): UserGroupValidationResponse
    {
        $response = new UserGroupValidationResponse();

        $decodedCurlResponse = json_decode($curlResponse);

        $response->setRequestStatus($decodedCurlResponse->status);
        $response->setRequestToken($decodedCurlResponse->request);
        $response->setCurlResponse($curlResponse);

        if ($response->getRequestStatus() == 1) {
            $response->setIsSuccessful(true);
            $response->setDevices($decodedCurlResponse->devices);
            $response->setLicenses($decodedCurlResponse->licenses);
        }

        if ($response->getRequestStatus() != 1) {
            $response->setErrors($decodedCurlResponse->errors);
            $response->setIsSuccessful(false);
        }

        return $response;
    }
}
