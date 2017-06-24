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
}
