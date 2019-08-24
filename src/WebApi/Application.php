<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace HerCat\BaiduMap\WebApi;

use HerCat\BaiduMap\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author her-cat <i@her-cat.com>
 *
 * @property StaticMap\Client               $static_map
 * @property Timezone\Client                $timezone
 * @property IpLocate\Client                $ip_locate
 * @property Geocode\Client                 $geocode
 * @property Geocode\ReverseClient          $reverse_geocode
 * @property RoadTraffic\Client             $road_traffic
 * @property PlaceSuggest\Client            $place_suggest
 * @property PlaceSuggest\AbroadClient      $abroad_place_suggest
 */
class Application extends ServiceContainer
{
    protected $providers = [
        StaticMap\ServiceProvider::class,
        Timezone\ServiceProvider::class,
        IpLocate\ServiceProvider::class,
        Geocode\ServiceProvider::class,
        RoadTraffic\ServiceProvider::class,
        PlaceSuggest\ServiceProvider::class,
    ];
}
