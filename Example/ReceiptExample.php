<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Example;

use Serhiy\Pushover\Api\Receipts\Receipt;

use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\CancelRetryResponse;
use Serhiy\Pushover\Client\Response\ReceiptResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class ReceiptExample
{
    public function queryEmergencyNotificationReceiptExample()
    {
        // instantiate pushover application and receipt (can be injected into service using Dependency Injection)
        $application = new Application("replace_with_pushover_application_api_token");
        $receipt = new Receipt($application);

        // query emergency notification receipt
        /** @var ReceiptResponse $response */
        $response = $receipt->query("replace_with_receipt");

        // work with response
        if ($response->isSuccessful()) {
            // True or False whether the user has acknowledged the notification
            if ($response->isAcknowledged()) {
                /** @var \DateTime $dateTime Timestamp of when the user acknowledged, or null */
                $acknowledgedAt = $response->getAcknowledgedAt();

                /** @var Recipient $recipient User that first acknowledged the notification */
                $acknowledgedBy = $response->getAcknowledgedBy();

                /** @var string $device The device name of the user that first acknowledged the notification */
                $acknowledgedByDevice = $response->getAcknowledgedByDevice();
            }

            /** @var \DateTime $lastDeliveredAt Timestamp of when the notification was last retried, or null */
            $lastDeliveredAt = $response->getLastDeliveredAt();

            /** @var bool $isExpired True or False whether the expiration date has passed */
            $isExpired = $response->isExpired();

            /** @var \DateTime $expiresAt Timestamp of when the notification will stop being retried */
            $expiresAt = $response->getExpiresAt();

            /** @var bool $hasCalledBack True or False whether our server has called back to your callback URL if any */
            $hasCalledBack = $response->hasCalledBack();

            /** @var \DateTime $calledBackAt Timestamp of when our server called back, or null */
            $calledBackAt = $response->getCalledBackAt();
        }
    }

    public function cancelEmergencyNotificationRetryExample()
    {
        // instantiate pushover application and receipt (can be injected into service using Dependency Injection)
        $application = new Application("replace_with_pushover_application_api_token");
        $receipt = new Receipt($application);

        // cancel emergency notification retry
        /** @var CancelRetryResponse $response */
        $response = $receipt->cancelRetry("replace_with_receipt");

        // work with response
        if ($response->isSuccessful()) {
            // ...
        }
    }
}
