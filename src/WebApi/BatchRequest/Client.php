<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\WebApi\BatchRequest;

use GuzzleHttp\Exception\GuzzleException;
use EricLiuCN\BaiduMap\Kernel\BaseClient;
use EricLiuCN\BaiduMap\Kernel\Exceptions\InvalidArgumentException;
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
    protected $needSignature = false;

    /**
     * @param array $params
     *
     * @return array|Response|Collection|mixed|object|ResponseInterface
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function get(array $params)
    {
        $ak = $this->app->config->get('ak');

        $params = array_map(function ($value) use ($ak) {
            if (!isset($value['url'])) {
                throw new InvalidArgumentException('The url cannot be empty.');
            }

            $url = parse_url($value['url']);

            if (empty($url['query']) || false === stripos($url['query'], 'ak=')) {
                $value['url'] .= sprintf('%sak=%s', empty($url['query']) ? '?' : '&', $ak);
            }

            return $value;
        }, (array) $params);

        return $this->httpPostJson('batch', ['reqs' => $params]);
    }
}
