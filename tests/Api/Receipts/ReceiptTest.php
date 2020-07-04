<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Receipts;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Receipts\Receipt;
use Serhiy\Pushover\ApiClient\Receipts\CancelRetryResponse;
use Serhiy\Pushover\ApiClient\Receipts\ReceiptResponse;
use Serhiy\Pushover\Application;

/**
 * @author Serhiy Lunak
 */
class ReceiptTest extends TestCase
{
    public function testCanBeCreated()
    {
        $application = new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token

        $receipt = new Receipt($application);

        $this->assertInstanceOf(Receipt::class, $receipt);

        return $receipt;
    }

    /**
     * @depends testCanBeCreated
     * @param Receipt $receipt
     */
    public function testGetApplication(Receipt $receipt)
    {
        $application = $receipt->getApplication();

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals("azGDORePK8gMaC0QOYAMyEEuzJnyUi", $application->getToken());
    }

    /**
     * @depends testCanBeCreated
     * @param Receipt $receipt
     */
    public function testQuery(Receipt $receipt)
    {
        $response = $receipt->query("sraw8swp2qh9bp6o4n7bw6o6cic94j"); // using dummy receipt

        $this->assertInstanceOf(ReceiptResponse::class, $response);
    }

    /**
     * @depends testCanBeCreated
     * @param Receipt $receipt
     */
    public function testCancelRetry(Receipt $receipt)
    {
        $response = $receipt->cancelRetry("sraw8swp2qh9bp6o4n7bw6o6cic94j"); // using dummy receipt

        $this->assertInstanceOf(CancelRetryResponse::class, $response);
    }
}
