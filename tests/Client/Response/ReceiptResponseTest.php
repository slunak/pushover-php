<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Response;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Response\ReceiptResponse;
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
        $curlResponse = '{"status":1,"acknowledged":1,"acknowledged_at":1593975206,"acknowledged_by":"uQiRzpo4DXghDmr9QzzfQu27cmVRsG","acknowledged_by_device":"my-device","last_delivered_at":1593975186,"expired":1,"expires_at":1593975485,"called_back":0,"called_back_at":0,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new ReceiptResponse($curlResponse);

        $this->assertInstanceOf(ReceiptResponse::class, $response);

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
        $this->assertTrue($response->isExpired());
    }
}
