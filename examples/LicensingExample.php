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

use Serhiy\Pushover\Api\Licensing\License;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\LicenseResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class LicensingExample
{
    public function licensingExample(): void
    {
        // instantiate pushover application and recipient (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // create license
        $license = new License($application);

        // check remaining credits
        /** @var LicenseResponse $response */
        $response = $license->checkCredits();

        // work with response
        if ($response->isSuccessful()) {
            var_dump($response->getCredits());
        }

        // assign license
        $license->setRecipient($recipient);
        // OR
        $license->setEmail('dummy@email.com'); // you will need to check email validity yourself
        // you may also specify OS type
        $license->setOs(License::OS_ANDROID);

        /** @var LicenseResponse $response */
        $response = $license->assign();

        // or loop over recipients or emails
        $recipients = []; // array of Recipient objects

        foreach ($recipients as $recipient) {
            $license->setRecipient($recipient);
            $response = $license->assign();
        }

        // work with response
        if ($response->isSuccessful()) {
            // ...
            var_dump($response);
        }
    }
}
