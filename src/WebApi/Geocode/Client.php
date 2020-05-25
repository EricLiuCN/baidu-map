<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\WebApi\Geocode;

use GuzzleHttp\Exception\GuzzleException;
use EricLiuCN\BaiduMap\Kernel\BaseClient;
use EricLiuCN\BaiduMap\Kernel\Exceptions\InvalidConfigException;
use EricLiuCN\BaiduMap\Kernel\Http\Response;
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
     * @param string $address
     * @param array  $options
     *
     * @return array|Response|Collection|mixed|object|ResponseInterface
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function get($address, array $options = [])
    {
        $options = array_merge(['address' => $address], $options);

        return $this->httpGet('geocoding/v3', $options);
    }
}
