<?php
namespace Ups\Tests\Entity\TrackResponse;

use DOMDocument;
use Ups;
use PHPUnit_Framework_TestCase;

class  ShipmentReferenceNumberTest extends PHPUnit_Framework_TestCase
{
    public function testToNode()
    {
        $shipmentReferenceNumber = new \Ups\Entity\TrackResponse\ShipmentReferenceNumber();
        $shipmentReferenceNumber->setValue('TestString');

        $xml = $shipmentReferenceNumber->toNode();

        $doc = new DOMDocument();
        $doc->loadXML($xml->ownerDocument->saveXML($xml));
        $this->assertTrue($doc->schemaValidate(__DIR__ . '/../../_files/entities/TrackResponse/ShipmentReferenceNumber.xsd'));
    }
}
