<?php
namespace Ups\Tests\Entity\RateRequest;

use DOMDocument;
use Ups;
use PHPUnit_Framework_TestCase;

class  DimensionsTest extends PHPUnit_Framework_TestCase
{
    public function testToNode()
    {
        $dimensions = new \Ups\Entity\RateRequest\Dimensions();
        $dimensions->setLength('TestString');
        $dimensions->setWidth('TestString');
        $dimensions->setHeight('TestString');

        $xml = $dimensions->toNode();

        $doc = new DOMDocument();
        $doc->loadXML($xml->ownerDocument->saveXML($xml));
        $this->assertTrue($doc->schemaValidate(__DIR__ . '/../../_files/entities/RateRequest/Dimensions.xsd'));
    }
}
