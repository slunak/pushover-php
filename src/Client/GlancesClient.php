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

use Serhiy\Pushover\Api\Glances\Glance;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\LogicException;

/**
 * @author Serhiy Lunak
 */
class GlancesClient extends Client implements ClientInterface
{
    public const API_PATH = 'glances.json';

    public function buildApiUrl(): string
    {
        return Curl::API_BASE_URL.'/'.Curl::API_VERSION.'/'.self::API_PATH;
    }

    /**
     * Builds array for CURLOPT_POSTFIELDS curl argument.
     *
     * @return array<string, string>
     */
    public function buildCurlPostFields(Glance $glance)
    {
        if (!$glance->hasRecipient()) {
            throw new LogicException('Glance recipient is not set.');
        }

        if (!$glance->hasAtLeastOneField()) {
            throw new LogicException('At least one of the data fields must be supplied. To clear a previously-updated field, send the field with a blank (empty string) value.');
        }

        $curlPostFields = [
            'token' => $glance->getApplication()->getToken(),
            'user' => $glance->getRecipient()->getUserKey(),
        ];

        if (!empty($glance->getRecipient()->getDevice())) {
            if (\count($glance->getRecipient()->getDevice()) > 1) {
                throw new LogicException(sprintf('Glance can be pushed to only one device. "%s" devices provided.', \count($glance->getRecipient()->getDevice())));
            }

            $curlPostFields['device'] = $glance->getRecipient()->getDeviceListCommaSeparated();
        }

        $title = $glance->getGlanceDataFields()->getTitle();

        if (null !== $title) {
            $curlPostFields['title'] = $title;
        }

        $text = $glance->getGlanceDataFields()->getText();

        if (null !== $text) {
            $curlPostFields['text'] = $text;
        }

        $subtext = $glance->getGlanceDataFields()->getSubtext();

        if (null !== $subtext) {
            $curlPostFields['subtext'] = $subtext;
        }

        $count = $glance->getGlanceDataFields()->getCount();

        if (null !== $count) {
            $curlPostFields['count'] = (string) $count;
        }

        $percent = $glance->getGlanceDataFields()->getPercent();

        if (null !== $percent) {
            $curlPostFields['percent'] = (string) $percent;
        }

        return $curlPostFields;
    }
}
