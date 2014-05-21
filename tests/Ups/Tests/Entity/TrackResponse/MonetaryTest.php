<?php
namespace Ups\Tests\Entity\TrackResponse;

use DOMDocument;
use Ups;
use PHPUnit_Framework_TestCase;

class  MonetaryTest extends PHPUnit_Framework_TestCase
{
    public function testToNode()
    {
        $monetary = new \Ups\Entity\TrackResponse\Monetary();
        $monetary->setMonetaryValue('TestString');

        $xml = $monetary->toNode();

        $doc = new DOMDocument();
        $doc->loadXML($xml->ownerDocument->saveXML($xml));
        $this->assertTrue($doc->schemaValidate(__DIR__ . '/../../_files/entities/TrackResponse/Monetary.xsd'));
    }
}
