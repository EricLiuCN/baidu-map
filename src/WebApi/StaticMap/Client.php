<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\WebApi\StaticMap;

use GuzzleHttp\Exception\GuzzleException;
use EricLiuCN\BaiduMap\Kernel\BaseClient;
use EricLiuCN\BaiduMap\Kernel\Exceptions\InvalidConfigException;
use EricLiuCN\BaiduMap\Kernel\Http\Response;
use EricLiuCN\BaiduMap\Kernel\Http\StreamResponse;
use EricLiuCN\BaiduMap\Kernel\Support\Collection;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client.
 *
 * @author her-cat <i@her-cat.com>
 */
class Client extends BaseClient
{
    /**
     * @param string|float $longitude
     * @param string|float $latitude
     * @param array        $options
     *
     * @return array|Response|StreamResponse|Collection|object|ResponseInterface
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function get($longitude, $latitude, $options = [])
    {
        $options = array_merge([
            'center' => sprintf('%s,%s', $longitude, $latitude),
        ], $options);

        return $this->httpGetStream('staticimage/v2', 'GET', $options);
    }
}
