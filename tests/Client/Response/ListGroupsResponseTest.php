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

namespace Client\Response;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Response\ListGroupsResponse;

final class ListGroupsResponseTest extends TestCase
{
    public function testCanBeCreated(): ListGroupsResponse
    {
        $successfulCurlResponse = '{"groups":[{"group":"111111111111111111111111111111","name":"Group1"},{"group":"222222222222222222222222222222","name":"group2"},{"group":"333333333333333333333333333333","name":"Group 3"}],"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new ListGroupsResponse($successfulCurlResponse);

        $this->assertInstanceOf(ListGroupsResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetGroups(ListGroupsResponse $response): void
    {
        $groups = $response->getGroups();
        $this->assertSame($groups, ['Group1' => '111111111111111111111111111111', 'group2' => '222222222222222222222222222222', 'Group 3' => '333333333333333333333333333333']);
    }
}
