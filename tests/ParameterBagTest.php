<?php

namespace GeoSocio\Tests\EntityUtils;

use GeoSocio\EntityUtils\ParameterBag;
use PHPUnit\Framework\TestCase;

/**
 * Parameter Bag Test
 */
class ParameterBagTest extends TestCase
{
    public function testAll()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);
        $this->assertEquals($data, $bag->all());
    }

    public function testKeys()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);
        $this->assertEquals(['key'], $bag->keys());
    }

    public function testReplace()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $newData = [
            'newKey' => 'newValue',
        ];
        $bag->replace($newData);

        $this->assertEquals($newData, $bag->all());
    }

    public function testAdd()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $newData = [
            'newKey' => 'newValue',
        ];
        $bag->add($newData);

        $this->assertEquals(array_replace($data, $newData), $bag->all());
    }

    public function testGet()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);
        $this->assertEquals('value', $bag->get('key'));
        $this->assertEquals('default', $bag->get('nokey', 'default'));
    }
}
