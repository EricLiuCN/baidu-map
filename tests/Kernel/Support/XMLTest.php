<?php

/*
 * This file is part of the her-cat/baidu-map.
 *
 * (c) her-cat <i@her-cat.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EricLiuCN\BaiduMap\Tests\Kernel\Support;

use EricLiuCN\BaiduMap\Kernel\Support\XML;
use EricLiuCN\BaiduMap\Tests\TestCase;

class XMLTest extends TestCase
{
    public function testParse()
    {
        $xml = '<root>
                  <name>mock-name</name>
                  <age>18</age>
                  <foo>1</foo>
                  <foo>2</foo>
                  <foo>3</foo>
                </root>';

        $this->assertSame(['name' => 'mock-name', 'age' => '18', 'foo' => ['1', '2', '3']], XML::parse($xml));
    }

    public function testNormalize()
    {
        $this->assertSame(18, XML::normalize(18));
        $this->assertSame('foo', XML::normalize('foo'));

        $this->assertSame(['name' => 'mock-name'], XML::normalize(['name' => 'mock-name']));

        $man = new \stdClass();
        $man->name = 'mock-name';

        $obj = new \stdClass();
        $obj->foo = 'bar';
        $obj->products = [
            [
                'name' => 'product-1',
            ],
            [
                'name' => 'product-2',
            ],
        ];
        $obj->man = $man;

        $this->assertSame([
            'foo' => 'bar',
            'products' => [
                [
                    'name' => 'product-1',
                ],
                [
                    'name' => 'product-2',
                ],
            ],
            'man' => [
                'name' => 'mock-name',
            ],
        ], XML::normalize($obj));
    }

    public function testSanitize()
    {
        $content_template = '1%s%s%s234%s测试%sabcd?*_^%s@#%s';

        $valid_chars = str_replace('%s', '', $content_template);
        $invalid_chars = sprintf($content_template, "\x1", "\x02", "\3", "\xe", "\xF", "\xC", "\10");

        if (substr(PHP_VERSION, 0, 3) > 7.0) {
            $invalid_chars = sprintf("{$invalid_chars}%s%s", "\u{05}", "\u{00FFFF}");
        }

        $xml_template = '<xml><foo>We shall filter out invalid chars</foo><bar>%s</bar></xml>';

        $element = 'SimpleXMLElement';
        $option = LIBXML_COMPACT | LIBXML_NOCDATA | LIBXML_NOBLANKS;

        $invalid_xml = sprintf($xml_template, $invalid_chars);
        libxml_use_internal_errors(true);
        $this->assertFalse(simplexml_load_string($invalid_xml, $element, $option));
        libxml_use_internal_errors(false);

        $valid_xml = sprintf($xml_template, $valid_chars);

        $this->assertSame(
            (array) simplexml_load_string($valid_xml, $element, $option),
            (array) simplexml_load_string(XML::sanitize($invalid_xml), $element, $option)
        );
    }
}
