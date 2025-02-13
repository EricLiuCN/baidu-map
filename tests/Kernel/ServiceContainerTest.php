<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\Tests\Kernel;

use GuzzleHttp\Client;
use EricLiuCN\BaiduMap\Kernel\Config;
use EricLiuCN\BaiduMap\Kernel\ServiceContainer;
use EricLiuCN\BaiduMap\Tests\TestCase;
use Monolog\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceContainerTest extends TestCase
{
    public function testBasicFeature()
    {
        $config = [
            'ak' => 'mock-ak',
            'response_type' => 'array',
        ];

        $container = new ServiceContainer($config);

        $this->assertInstanceOf(Container::class, $container);

        $this->assertNotEmpty($container->getProviders());

        $this->assertInstanceOf(Config::class, $container['config']);
        $this->assertInstanceOf(Config::class, $container->config);

        $this->assertInstanceOf(Logger::class, $container['logger']);
        $this->assertInstanceOf(Client::class, $container['http_client']);

        $container['foo'] = 'bar';
        $this->assertSame('bar', $container->foo);

        $container->bar = 'foo';
        $this->assertSame('foo', $container['bar']);

        $this->assertSame('mock-ak', $container->config->get('ak'));
        $this->assertSame('array', $container->config->get('response_type'));
    }

    public function testRegisterProviders()
    {
        $config = [
            'ak' => 'mock-ak',
            'response_type' => 'array',
        ];

        $fooService = new FooServiceContainerTest($config);

        $this->assertInstanceOf(ServiceContainer::class, $fooService);
        $this->assertSame('bar', $fooService['foo']);

        $this->assertSame('mock-ak', $fooService->config->get('ak'));
        $this->assertSame('mock-base-uri', $fooService->config->get('http.base_uri'));
    }
}

class FooServiceContainerTest extends ServiceContainer
{
    protected $providers = [
        FooServiceProviderTest::class,
    ];

    protected $defaultConfig = [
        'http' => [
            'base_uri' => 'mock-base-uri',
        ],
    ];
}

class FooServiceProviderTest implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['foo'] = function () {
            return 'bar';
        };
    }
}
