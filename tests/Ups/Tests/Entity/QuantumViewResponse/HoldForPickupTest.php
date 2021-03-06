<?php
namespace Ups\Tests\Entity\QuantumViewResponse;

use DOMDocument;
use Ups;
use PHPUnit_Framework_TestCase;

class  HoldForPickupTest extends PHPUnit_Framework_TestCase
{
    public function testToNode()
    {
        $holdForPickup = new \Ups\Entity\QuantumViewResponse\HoldForPickup();

        $xml = $holdForPickup->toNode();

        $doc = new DOMDocument();
        $doc->loadXML($xml->ownerDocument->saveXML($xml));
        $this->assertTrue($doc->schemaValidate(__DIR__ . '/../../_files/entities/QuantumViewResponse/HoldForPickup.xsd'));
    }
}
