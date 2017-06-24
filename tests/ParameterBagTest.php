<?php

namespace GeoSocio\Tests\EntityUtils;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function testGetInit()
    {
        $data = [
            'number' => '12345',
            'bool' => true,
            'int' => 12345,
        ];

        $bag = new ParameterBag($data);

        $this->assertSame(12345, $bag->getInt('int', 0));
        $this->assertSame(0, $bag->getInt('number', 0));
        $this->assertSame(0, $bag->getInt('bool', 0));
        $this->assertSame(0, $bag->getInt('nokey', 0));
    }

    public function testGetBoolean()
    {
        $data = [
            'string' => 'true',
            'int' => 1,
            'bool' => true,
        ];

        $bag = new ParameterBag($data);

        $this->assertSame(true, $bag->getBoolean('bool', false));
        $this->assertSame(false, $bag->getBoolean('int', false));
        $this->assertSame(false, $bag->getBoolean('number', false));
        $this->assertSame(false, $bag->getBoolean('nokey', false));
    }

    public function testGetString()
    {
        $data = [
            'string' => 'abc',
            'int' => 1,
            'bool' => true,
        ];

        $bag = new ParameterBag($data);

        $this->assertSame('abc', $bag->getString('string', 'xyz'));
        $this->assertSame('xyz', $bag->getString('int', 'xyz'));
        $this->assertSame('xyz', $bag->getString('number', 'xyz'));
        $this->assertSame('xyz', $bag->getString('nokey', 'xyz'));
    }

    public function testGetArray()
    {
        $data = [
            'string' => 'array',
            'int' => 1,
            'bool' => true,
            'array' => [1,2,3],
        ];

        $bag = new ParameterBag($data);

        $this->assertSame([1,2,3], $bag->getArray('array', [4,5,6]));
        $this->assertSame([4,5,6], $bag->getArray('string', [4,5,6]));
        $this->assertSame([4,5,6], $bag->getArray('int', [4,5,6]));
        $this->assertSame([4,5,6], $bag->getArray('bool', [4,5,6]));
        $this->assertSame([4,5,6], $bag->getArray('nokey', [4,5,6]));
    }

    public function testGetUuid()
    {
        $real = '5d110ca4-58f4-11e7-97a7-a45e60d54511';
        $data = [
            'uuid' => $real,
            'string' => 'abc',
        ];

        $bag = new ParameterBag($data);

        $default = '75568f1e-58f4-11e7-97a7-a45e60d54511';
        $this->assertSame($real, $bag->getUuid('uuid', $default));
        $this->assertSame($default, $bag->getUuid('string', $default));
        $this->assertSame($default, $bag->getUuid('nokey', $default));
    }

    public function testGetIterator()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $iterator = $bag->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $iterator);
    }

    public function testCount()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);
        $this->assertEquals(1, $bag->count());

        $bag = new ParameterBag();
        $this->assertEquals(0, $bag->count());
    }

    public function testGetInstance()
    {
        $object = new \stdClass();
        $object->id = 'real';

        $data = [
            'object' => $object,
        ];
        $bag = new ParameterBag($data);

        $default = new \stdClass();
        $default->id = 'default';

        $this->assertSame($object, $bag->get('object', $default));
        $this->assertSame($object, $bag->getInstance('object', \stdClass::class, $default));
        $this->assertSame($default, $bag->getInstance('object', \Exception::class, $default));
        $this->assertSame($default, $bag->getInstance('nokey', \stdClass::class, $default));
    }

    public function testGetCollection()
    {
        $array = [
            new \stdClass(),
            new \Exception(),
        ];
        $collection = new ArrayCollection($array);
        $data = [
            'array' => $array,
            'collection' => $collection,
        ];

        $bag = new ParameterBag($data);

        $default = new ArrayCollection();

        $result = $bag->getCollection('array', \stdClass::class, $default);
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);

        $result = $bag->getCollection('collection', \stdClass::class, $default);
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);

        $result = $bag->getCollection('nokey', \stdClass::class, $default);
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }
}
