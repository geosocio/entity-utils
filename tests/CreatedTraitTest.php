<?php

namespace GeoSocio\EntityUtils;

use GeoSocio\EntityUtils\CreatedTrait;
use PHPUnit\Framework\TestCase;

class CreatedTraitTest extends TestCase
{
    /**
     * Test Created Value.
     */
    public function testSetCreatedValue()
    {
        $created = $this->getObjectForTrait(CreatedTrait::class);
        $created->setCreatedValue();
        $this->assertNotNull($created->getCreated());
    }

    /**
     * Test Created.
     */
    public function testSetCreated()
    {
        $created = $this->getObjectForTrait(CreatedTrait::class);
        $datetime = new \DateTime();
        $created->setCreated($datetime);
        $this->assertSame($datetime, $created->getCreated());
    }
}
