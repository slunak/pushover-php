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

namespace Serhiy\Pushover\Example;

use Serhiy\Pushover\Api\Glances\Glance;
use Serhiy\Pushover\Api\Glances\GlanceDataFields;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\GlancesResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class GlancesExample
{
    public function glancesExample(): void
    {
        // instantiate pushover application and recipient (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // create glance data fields
        $glanceDataFields = new GlanceDataFields();
        $glanceDataFields
            ->setTitle('Title')
            ->setText('Text')
            ->setSubtext('Subtext')
            ->setCount(1)
            ->setPercent(99);

        // instantiate glance
        $glance = new Glance($application, $glanceDataFields);

        // set recipient
        $glance->setRecipient($recipient);

        // push it
        /** @var GlancesResponse $response */
        $response = $glance->push();

        // or loop over recipients
        $recipients = []; // array of Recipient objects

        foreach ($recipients as $recipient) {
            $glance->setRecipient($recipient);
            $response = $glance->push();
        }

        // work with response
        if ($response->isSuccessful()) {
            // ...
        }
    }
}
