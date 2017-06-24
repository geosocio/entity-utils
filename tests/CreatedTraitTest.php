<?php

namespace GeoSocio\EntityUtils\Tests;

use GeoSocio\EntityUtils\CreatedTrait;
use PHPUnit\Framework\TestCase;

class CreatedTraitTest extends TestCase
{
    public function testSetCreatedValue()
    {
        $created = $this->getObjectForTrait(CreatedTrait::class);
        $created->setCreatedValue();
        $this->assertNotNull($created->getCreated());
    }

    public function testSetCreated()
    {
        $created = $this->getObjectForTrait(CreatedTrait::class);
        $datetime = new \DateTime();
        $created->setCreated($datetime);
        $this->assertEquals($datetime, $created->getCreated());
    }
}
