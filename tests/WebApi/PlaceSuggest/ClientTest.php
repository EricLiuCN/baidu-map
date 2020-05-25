<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\Tests\WebApi\PlaceSuggest;

use EricLiuCN\BaiduMap\Kernel\ServiceContainer;
use EricLiuCN\BaiduMap\Tests\TestCase;
use EricLiuCN\BaiduMap\WebApi\PlaceSuggest\Client;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $app = new ServiceContainer();

        $client = $this->mockApiClient(Client::class, [], $app);

        $client->expects()
            ->httpGet('place/v2/suggestion', [
                'query' => 'mock-keyword',
                'region' => 'mock-region',
            ])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->get('mock-keyword', 'mock-region'));
    }
}
