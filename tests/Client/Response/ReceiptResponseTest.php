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
        $unSuccessfulCurlResponse = '{"receipt":"not found","errors":["receipt not found; may be invalid or expired"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new ReceiptResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(ReceiptResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());
        $this->assertEquals(array(0 => "receipt not found; may be invalid or expired"), $response->getErrors());
        
        $successfulCurlResponse = '{"status":1,"acknowledged":1,"acknowledged_at":1593975206,"acknowledged_by":"aaaa1111AAAA1111bbbb2222BBBB22","acknowledged_by_device":"test-device-1","last_delivered_at":1593975186,"expired":1,"expires_at":1593975485,"called_back":1,"called_back_at":1593975206,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new ReceiptResponse($successfulCurlResponse);

        $this->assertInstanceOf(ReceiptResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());

        return $response;
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetAcknowledgedBy(ReceiptResponse $response)
    {
        $this->assertInstanceOf(Recipient::class, $response->getAcknowledgedBy());
        $this->assertEquals("aaaa1111AAAA1111bbbb2222BBBB22", $response->getAcknowledgedBy()->getUserKey());
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptResponse $response
     */
    public function testGetAcknowledgedByDevice(ReceiptResponse $response)
    {
        $this->assertEquals("test-device-1", $response->getAcknowledgedByDevice());
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
