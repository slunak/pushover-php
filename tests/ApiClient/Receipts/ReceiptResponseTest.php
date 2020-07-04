<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiClient\Receipts;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\ApiClient\Receipts\ReceiptResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class ReceiptResponseTest extends TestCase
{
    /**
     * @return ReceiptResponse
     */
    public function testCanBeCreated(): ReceiptResponse
    {
        $response = new ReceiptResponse();

        $this->assertInstanceOf(ReceiptResponse::class, $response);

        $response->setIsAcknowledged(true);
        $response->setAcknowledgedAt(new \DateTime());
        $response->setAcknowledgedBy(new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"));
        $response->setAcknowledgedByDevice("my-device");
        $response->setLastDeliveredAt(new \DateTime());
        $response->setIsExpired(false);
        $response->setExpiresAt(new \DateTime());
        $response->setHasCalledBack(true);
        $response->setCalledBackAt(new \DateTime());

        return $response;
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetAcknowledgedBy(ReceiptResponse $response)
    {
        $this->assertInstanceOf(Recipient::class, $response->getAcknowledgedBy());
        $this->assertEquals("uQiRzpo4DXghDmr9QzzfQu27cmVRsG", $response->getAcknowledgedBy()->getUserKey());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetAcknowledgedByDevice(ReceiptResponse $response)
    {
        $this->assertEquals("my-device", $response->getAcknowledgedByDevice());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetExpiresAt(ReceiptResponse $response)
    {
        $this->assertInstanceOf(\DateTime::class, $response->getExpiresAt());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetLastDeliveredAt(ReceiptResponse $response)
    {
        $this->assertInstanceOf(\DateTime::class, $response->getLastDeliveredAt());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testIsAcknowledged(ReceiptResponse $response)
    {
        $this->assertTrue($response->isAcknowledged());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetCalledBackAt(ReceiptResponse $response)
    {
        $this->assertInstanceOf(\DateTime::class, $response->getCalledBackAt());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetAcknowledgedAt(ReceiptResponse $response)
    {
        $this->assertInstanceOf(\DateTime::class, $response->getAcknowledgedAt());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testHasCalledBack(ReceiptResponse $response)
    {
        $this->assertTrue($response->hasCalledBack());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testIsExpired(ReceiptResponse $response)
    {
        $this->assertFalse($response->isExpired());
    }
}
