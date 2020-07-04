<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient\Receipts;

use Serhiy\Pushover\ApiClient\Response;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class ReceiptResponse extends Response
{
    /**
     * @var bool True or False whether the user has acknowledged the notification.
     */
    private $isAcknowledged = false;

    /**
     * @var \DateTime|null Timestamp of when the user acknowledged, or null.
     */
    private $acknowledgedAt;

    /**
     * @var Recipient User that first acknowledged the notification.
     */
    private $acknowledgedBy;

    /**
     * @var string The device name of the user that first acknowledged the notification.
     */
    private $acknowledgedByDevice;

    /**
     * @var \DateTime|null Timestamp of when the notification was last retried, or null.
     */
    private $lastDeliveredAt;

    /**
     * @var bool True or False whether the expiration date has passed.
     */
    private $isExpired;

    /**
     * @var \DateTime Timestamp of when the notification will stop being retried.
     */
    private $expiresAt;

    /**
     * @var bool True or False whether our server has called back to your callback URL if any.
     */
    private $hasCalledBack = false;

    /**
     * @var \DateTime|null Timestamp of when our server called back, or null.
     */
    private $calledBackAt;

    public function __construct()
    {
    }

    /**
     * @return bool
     */
    public function isAcknowledged(): bool
    {
        return $this->isAcknowledged;
    }

    /**
     * @param bool $isAcknowledged
     */
    public function setIsAcknowledged(bool $isAcknowledged): void
    {
        $this->isAcknowledged = $isAcknowledged;
    }

    /**
     * @return \DateTime|null
     */
    public function getAcknowledgedAt(): ?\DateTime
    {
        return $this->acknowledgedAt;
    }

    /**
     * @param \DateTime $acknowledgedAt
     */
    public function setAcknowledgedAt(\DateTime $acknowledgedAt): void
    {
        $this->acknowledgedAt = $acknowledgedAt;
    }

    /**
     * @return Recipient
     */
    public function getAcknowledgedBy(): Recipient
    {
        return $this->acknowledgedBy;
    }

    /**
     * @param Recipient $acknowledgedBy
     */
    public function setAcknowledgedBy(Recipient $acknowledgedBy): void
    {
        $this->acknowledgedBy = $acknowledgedBy;
    }

    /**
     * @return string
     */
    public function getAcknowledgedByDevice(): string
    {
        return $this->acknowledgedByDevice;
    }

    /**
     * @param string $acknowledgedByDevice
     */
    public function setAcknowledgedByDevice(string $acknowledgedByDevice): void
    {
        $this->acknowledgedByDevice = $acknowledgedByDevice;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastDeliveredAt(): ?\DateTime
    {
        return $this->lastDeliveredAt;
    }

    /**
     * @param \DateTime $lastDeliveredAt
     */
    public function setLastDeliveredAt(\DateTime $lastDeliveredAt): void
    {
        $this->lastDeliveredAt = $lastDeliveredAt;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->isExpired;
    }

    /**
     * @param bool $isExpired
     */
    public function setIsExpired(bool $isExpired): void
    {
        $this->isExpired = $isExpired;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTime $expiresAt
     */
    public function setExpiresAt(\DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return bool
     */
    public function hasCalledBack(): bool
    {
        return $this->hasCalledBack;
    }

    /**
     * @param bool $hasCalledBack
     */
    public function setHasCalledBack(bool $hasCalledBack): void
    {
        $this->hasCalledBack = $hasCalledBack;
    }

    /**
     * @return \DateTime|null
     */
    public function getCalledBackAt(): ?\DateTime
    {
        return $this->calledBackAt;
    }

    /**
     * @param \DateTime $calledBackAt
     */
    public function setCalledBackAt(\DateTime $calledBackAt): void
    {
        $this->calledBackAt = $calledBackAt;
    }
}
