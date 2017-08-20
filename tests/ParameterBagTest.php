<?php

namespace GeoSocio\EntityUtils;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use GeoSocio\EntityUtils\ParameterBag;
use PHPUnit\Framework\TestCase;

/**
 * Parameter Bag Test
 */
class ParameterBagTest extends TestCase
{
    /**
     * Test All.
     */
    public function testAll()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);
        $this->assertEquals($data, $bag->all());
    }

    /**
     * Test Keys.
     */
    public function testKeys()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);
        $this->assertEquals(['key'], $bag->keys());
    }

    /**
     * Test Replace.
     */
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

    /**
     * Test Add.
     */
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

    /**
     * Test Get.
     */
    public function testGet()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);
        $this->assertEquals('value', $bag->get('key'));
        $this->assertEquals('default', $bag->get('nokey', 'default'));
    }

    /**
     * Test Set.
     */
    public function testSet()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $bag->set('key2', 'value2');

        $this->assertEquals('value2', $bag->get('key2'));
    }

    /**
     * Test Has.
     */
    public function testHas()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $this->assertTrue($bag->has('key'));
        $this->assertFalse($bag->has('nokey'));
    }

    /**
     * Test Remove.
     */
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

    /**
     * Test Int.
     */
    public function testGetInt()
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

    /**
     * Test Int.
     */
    public function testGetIntArray()
    {
        $data = [
            'array' => [
                12345,
                true,
                '12345',
                ['array'],
                new \stdClass(),
            ],
        ];

        $bag = new ParameterBag($data);

        $this->assertInternalType('array', $bag->getIntArray('array', []));
        $this->assertCount(1, $bag->getIntArray('array', []));
        $this->assertSame(12345, $bag->getIntArray('array', [])[0]);
    }

    /**
     * Test Boolean.
     */
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

    /**
     * Test Boolean.
     */
    public function testGetBooleanArray()
    {
        $data = [
            'array' => [
                12345,
                true,
                '12345',
                ['array'],
                new \stdClass(),
            ],
        ];

        $bag = new ParameterBag($data);

        $this->assertInternalType('array', $bag->getBooleanArray('array', []));
        $this->assertCount(1, $bag->getBooleanArray('array', []));
        $this->assertTrue($bag->getBooleanArray('array', [])[0]);
    }

    /**
     * Test String.
     */
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

    /**
     * Test String.
     */
    public function testGetStringArray()
    {
        $data = [
            'array' => [
                12345,
                true,
                '12345',
                ['array'],
                new \stdClass(),
            ],
        ];

        $bag = new ParameterBag($data);

        $this->assertInternalType('array', $bag->getStringArray('array', []));
        $this->assertCount(1, $bag->getStringArray('array', []));
        $this->assertSame('12345', $bag->getStringArray('array', [])[0]);
    }

    /**
     * Test Array.
     */
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

    /**
     * Test UUID.
     */
    public function testGetUuid()
    {
        $real = '5d110ca4-58f4-11e7-97a7-a45e60d54511';
        $data = [
            'uuid' => strtoupper($real),
            'string' => 'abc',
        ];

        $bag = new ParameterBag($data);

        $default = '75568f1e-58f4-11e7-97a7-a45e60d54511';
        $this->assertSame($real, $bag->getUuid('uuid', $default));
        $this->assertSame($default, $bag->getUuid('string', $default));
        $this->assertSame($default, $bag->getUuid('nokey', $default));
    }

    /**
     * Test UUID.
     */
    public function testGetUuidArray()
    {
        $uuid = '5d110ca4-58f4-11e7-97a7-a45e60d54511';
        $data = [
            'array' => [
                12345,
                true,
                '12345',
                strtoupper($uuid),
                ['array'],
                new \stdClass(),
            ],
        ];

        $bag = new ParameterBag($data);

        $this->assertInternalType('array', $bag->getUuidArray('array', []));
        $this->assertCount(1, $bag->getUuidArray('array', []));
        $this->assertSame('5d110ca4-58f4-11e7-97a7-a45e60d54511', $bag->getUuidArray('array', [])[0]);
        $this->assertNull($bag->getUuidArray('nokey'));
    }

    /**
     * Test Iterator.
     */
    public function testGetIterator()
    {
        $data = [
            'key' => 'value',
        ];
        $bag = new ParameterBag($data);

        $iterator = $bag->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $iterator);
    }

    /**
     * Test Count.
     */
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

    /**
     * Test Instance.
     */
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

    /**
     * Test Collection.
     */
    public function testGetCollection()
    {
        $array = [
            new \stdClass(),
            [
                'property' => 'value',
            ],
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
        $this->assertCount(2, $result);

        $result = $bag->getCollection('collection', \stdClass::class, $default);
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);

        $result = $bag->getCollection('nokey', \stdClass::class, $default);
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }
}
