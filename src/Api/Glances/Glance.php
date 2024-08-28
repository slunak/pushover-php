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

namespace Serhiy\Pushover\Api\Glances;

use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\GlancesClient;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\GlancesResponse;
use Serhiy\Pushover\Recipient;

/**
 * Pushover Glances API (Beta).
 * With Pushover's Glances API, you can push small bits of data directly to a constantly-updated screen,
 * referred to as a widget, such as a complication on your smart watch or a widget on your phone's lock screen.
 * Glances API is used for sending short pieces of text or numerical data, such as "Garage door open" in response to an alarm system,
 * or just "30" representing the number of items sold in your store today.
 * These pieces of data should be low-priority since they often cannot get updated in real-time or very frequently,
 * and they must be concise because they are often viewed on small screens such as a watch face.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class Glance
{
    /**
     * Pushover application.
     */
    private Application $application;

    /**
     * Pushover user.
     */
    private ?Recipient $recipient = null;
    private GlanceDataFields $glanceDataFields;

    public function __construct(Application $application, GlanceDataFields $glanceDataFields)
    {
        $this->application = $application;
        $this->glanceDataFields = $glanceDataFields;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(Recipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getGlanceDataFields(): GlanceDataFields
    {
        return $this->glanceDataFields;
    }

    public function setGlanceDataFields(GlanceDataFields $glanceDataFields): void
    {
        $this->glanceDataFields = $glanceDataFields;
    }

    public function hasAtLeastOneField(): bool
    {
        $glanceDataFields = $this->getGlanceDataFields();

        if (null === $glanceDataFields->getTitle()
            && null === $glanceDataFields->getSubtext()
            && null === $glanceDataFields->getCount()
            && null === $glanceDataFields->getPercent()
        ) {
            return false;
        }

        return true;
    }

    public function hasRecipient(): bool
    {
        if (null === $this->recipient) {
            return false;
        }

        return true;
    }

    public function push(): GlancesResponse
    {
        $client = new GlancesClient();
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this));

        $curlResponse = Curl::do($request);

        $response = new GlancesResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
