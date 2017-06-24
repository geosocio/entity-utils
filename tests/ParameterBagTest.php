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

    public function testSet()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $bag->set('key2', 'value2');

        $this->assertEquals('value2', $bag->get('key2'));
    }

    public function testHas()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $this->assertTrue($bag->has('key'));
        $this->assertFalse($bag->has('nokey'));
    }

    public function testRemove()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $this->assertTrue($bag->has('key'));

        $bag->remove('key');

        $this->assertFalse($bag->has('key'));
    }
}
