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

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class ReceiptResponse extends Response
{
    /**
     * True or False whether the user has acknowledged the notification.
     */
    private bool $isAcknowledged = false;

    /**
     * Timestamp of when the user acknowledged, or null.
     */
    private ?\DateTime $acknowledgedAt;

    /**
     * User that first acknowledged the notification.
     */
    private Recipient $acknowledgedBy;

    /**
     * The device name of the user that first acknowledged the notification.
     */
    private string $acknowledgedByDevice;

    /**
     * Timestamp of when the notification was last retried, or null.
     */
    private ?\DateTime $lastDeliveredAt;

    /**
     * True or False whether the expiration date has passed.
     */
    private bool $isExpired;

    /**
     * Timestamp of when the notification will stop being retried.
     */
    private \DateTime $expiresAt;

    /**
     * True or False whether our server has called back to your callback URL if any.
     */
    private bool $hasCalledBack = false;

    /**
     * Timestamp of when our server called back, or null.
     */
    private ?\DateTime $calledBackAt;

    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    public function isAcknowledged(): bool
    {
        return $this->isAcknowledged;
    }

    public function getAcknowledgedAt(): ?\DateTime
    {
        return $this->acknowledgedAt;
    }

    public function getAcknowledgedBy(): Recipient
    {
        return $this->acknowledgedBy;
    }

    public function getAcknowledgedByDevice(): string
    {
        return $this->acknowledgedByDevice;
    }

    public function getLastDeliveredAt(): ?\DateTime
    {
        return $this->lastDeliveredAt;
    }

    public function isExpired(): bool
    {
        return $this->isExpired;
    }

    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    public function hasCalledBack(): bool
    {
        return $this->hasCalledBack;
    }

    public function getCalledBackAt(): ?\DateTime
    {
        return $this->calledBackAt;
    }

    private function setIsAcknowledged(bool $isAcknowledged): void
    {
        $this->isAcknowledged = $isAcknowledged;
    }

    private function setAcknowledgedAt(\DateTime $acknowledgedAt): void
    {
        $this->acknowledgedAt = $acknowledgedAt;
    }

    private function setAcknowledgedBy(Recipient $acknowledgedBy): void
    {
        $this->acknowledgedBy = $acknowledgedBy;
    }

    private function setAcknowledgedByDevice(string $acknowledgedByDevice): void
    {
        $this->acknowledgedByDevice = $acknowledgedByDevice;
    }

    private function setLastDeliveredAt(\DateTime $lastDeliveredAt): void
    {
        $this->lastDeliveredAt = $lastDeliveredAt;
    }

    private function setIsExpired(bool $isExpired): void
    {
        $this->isExpired = $isExpired;
    }

    private function setExpiresAt(\DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    private function setHasCalledBack(bool $hasCalledBack): void
    {
        $this->hasCalledBack = $hasCalledBack;
    }

    private function setCalledBackAt(\DateTime $calledBackAt): void
    {
        $this->calledBackAt = $calledBackAt;
    }

    /**
     * Processes curl response.
     *
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() === 1) {
            if ($decodedCurlResponse->acknowledged === 1) {
                $this->setIsAcknowledged(true);
                $this->setAcknowledgedAt(new \DateTime('@'.$decodedCurlResponse->acknowledged_at));

                $recipient = new Recipient($decodedCurlResponse->acknowledged_by);
                $recipient->addDevice($decodedCurlResponse->acknowledged_by_device);
                $this->setAcknowledgedBy($recipient);
                $this->setAcknowledgedByDevice($recipient->getDeviceListCommaSeparated());
            }

            $this->setLastDeliveredAt(new \DateTime('@'.$decodedCurlResponse->last_delivered_at));

            if ($decodedCurlResponse->expired === 1) {
                $this->setIsExpired(true);
            } else {
                $this->setIsExpired(false);
            }

            $this->setExpiresAt(new \DateTime('@'.$decodedCurlResponse->expires_at));

            if ($decodedCurlResponse->called_back === 1) {
                $this->setHasCalledBack(true);
                $this->setCalledBackAt(new \DateTime('@'.$decodedCurlResponse->called_back_at));
            }
        }
    }
}
