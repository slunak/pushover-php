<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Licensing;

use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\AssignLicenseClient;
use Serhiy\Pushover\Client\CheckLicenseClient;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\LicenseResponse;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class License
{
    /**
     * License for Android devices
     */
    public const OS_ANDROID = 'Android';

    /**
     * License for iOS devices
     */
    public const OS_IOS = 'iOS';

    /**
     * License for Desktop devices
     */
    public const OS_DESKTOP = 'Desktop';

    /**
     * License for any device type
     */
    public const OS_ANY = null;
    private Application $application;

    /**
     * (required unless email supplied) - the user's Pushover user key
     */
    private ?Recipient $recipient;

    /**
     * (required unless user supplied) - the user's e-mail address
     */
    private ?string $email;

    /**
     * Can be left blank, or one of Android, iOS, or Desktop
     */
    private ?string $os;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getRecipient(): ?Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(?Recipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(?string $os): void
    {
        if (!\in_array($os, $this->getAvailableOsTypes(), true)) {
            throw new InvalidArgumentException(sprintf('OS type "%s" is not available.', $os));
        }

        $this->os = $os;
    }

    /**
     * Checks if license is ready to be assigned.
     */
    public function canBeAssigned(): bool
    {
        if (null !== $this->recipient) {
            return true;
        }

        if (null !== $this->email) {
            return true;
        }

        return false;
    }

    /**
     * Generates array with all available OS types. OS types are taken from the constants of this class.
     *
     * @return array<string>
     */
    public static function getAvailableOsTypes(): array
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }

    /**
     * Check remaining credits.
     *
     * An API call can be made to return the number of license credits remaining without assigning one.
     */
    public function checkCredits(): LicenseResponse
    {
        $client = new CheckLicenseClient($this);
        $request = new Request($client->buildApiUrl(), Request::GET);

        $curlResponse = Curl::do($request);

        $response = new LicenseResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }

    /**
     * Assign License.
     *
     * Once your application has at least one license credit available,
     * you can assign it to a Pushover user by their Pushover account e-mail address or their Pushover user key if known.
     */
    public function assign(): LicenseResponse
    {
        $client = new AssignLicenseClient();
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this));

        $curlResponse = Curl::do($request);

        $response = new LicenseResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
