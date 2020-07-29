<?php

/*
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
 * @author Serhiy Lunak
 */
class Glance
{
    /**
     * @var Application Pushover application.
     */
    private $application;

    /**
     * @var Recipient Pushover user.
     */
    private $recipient;

    /**
     * @var GlanceDataFields Glance Data Fields.
     */
    private $glanceDataFields;

    public function __construct(Application $application, GlanceDataFields $glanceDataFields)
    {
        $this->application = $application;
        $this->glanceDataFields = $glanceDataFields;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    /**
     * @return Recipient
     */
    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    /**
     * @param Recipient $recipient
     */
    public function setRecipient(Recipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return GlanceDataFields
     */
    public function getGlanceDataFields(): GlanceDataFields
    {
        return $this->glanceDataFields;
    }

    /**
     * @param GlanceDataFields $glanceDataFields
     */
    public function setGlanceDataFields(GlanceDataFields $glanceDataFields): void
    {
        $this->glanceDataFields = $glanceDataFields;
    }

    /**
     * @return bool
     */
    public function hasAtLeastOneField(): bool
    {
        if (null === $this->getGlanceDataFields()->getTitle() &&
            null === $this->getGlanceDataFields()->getSubtext() &&
            null === $this->getGlanceDataFields()->getCount() &&
            null === $this->getGlanceDataFields()->getPercent()
        ) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function hasRecipient(): bool
    {
        if (null === $this->recipient) {
            return false;
        }

        return true;
    }

    /**
     * Push glance.
     *
     * @return GlancesResponse
     */
    public function push()
    {
        $client = new GlancesClient();
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this));

        $curlResponse = Curl::do($request);

        $response = new GlancesResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
