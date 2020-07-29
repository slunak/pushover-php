<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Api\Glances\Glance;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\LogicException;

/**
 * @author Serhiy Lunak
 */
class GlancesClient extends Client implements ClientInterface
{
    const API_PATH = "glances.json";

    /**
     * @inheritDoc
     */
    public function buildApiUrl()
    {
        return Curl::API_BASE_URL."/".Curl::API_VERSION."/".self::API_PATH;
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @param Glance $glance
     * @return array[]
     */
    public function buildCurlPostFields(Glance $glance)
    {
        if (!$glance->hasRecipient()) {
            throw new LogicException(sprintf('Glance recipient is not set.'));
        }

        if (!$glance->hasAtLeastOneField()) {
            throw new LogicException(sprintf('At least one of the data fields must be supplied. To clear a previously-updated field, send the field with a blank (empty string) value.'));
        }

        $curlPostFields = array(
            "token" => $glance->getApplication()->getToken(),
            "user" => $glance->getRecipient()->getUserKey(),
        );

        if (! empty($glance->getRecipient()->getDevice())) {
            if (count($glance->getRecipient()->getDevice()) > 1) {
                throw new LogicException(sprintf('Glance can be pushed to only one device. "%s" devices provided.', count($glance->getRecipient()->getDevice())));
            }

            $curlPostFields['device'] = $glance->getRecipient()->getDeviceListCommaSeparated();
        }

        if (null !== $glance->getGlanceDataFields()->getTitle()) {
            $curlPostFields['title'] = $glance->getGlanceDataFields()->getTitle();
        }
        if (null !== $glance->getGlanceDataFields()->getText()) {
            $curlPostFields['text'] = $glance->getGlanceDataFields()->getText();
        }
        if (null !== $glance->getGlanceDataFields()->getSubtext()) {
            $curlPostFields['subtext'] = $glance->getGlanceDataFields()->getSubtext();
        }
        if (null !== $glance->getGlanceDataFields()->getCount()) {
            $curlPostFields['count'] = $glance->getGlanceDataFields()->getCount();
        }
        if (null !== $glance->getGlanceDataFields()->getPercent()) {
            $curlPostFields['percent'] = $glance->getGlanceDataFields()->getPercent();
        }

        return $curlPostFields;
    }
}
