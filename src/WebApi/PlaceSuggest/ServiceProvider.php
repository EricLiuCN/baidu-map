<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\WebApi\PlaceSuggest;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 *
 * @author her-cat <i@her-cat.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['place_suggest'] = function ($app) {
            return new Client($app);
        };

        $app['abroad_place_suggest'] = function ($app) {
            return new AbroadClient($app);
        };
    }
}
