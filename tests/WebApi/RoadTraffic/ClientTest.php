<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\Tests\WebApi\RoadTraffic;

use EricLiuCN\BaiduMap\Tests\TestCase;
use EricLiuCN\BaiduMap\WebApi\RoadTraffic\Client;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()
            ->httpGet('traffic/v1/road', ['city' => 'mock-city', 'road_name' => 'mock-road-name'])
            ->andReturn('mock-result');

        $this->assertSame('mock-result', $client->get('mock-city', 'mock-road-name'));
    }
}
