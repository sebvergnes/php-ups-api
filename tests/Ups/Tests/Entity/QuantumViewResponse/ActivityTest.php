<?php
namespace Ups\Tests\Entity\QuantumViewResponse;

use DOMDocument;
use Ups;
use PHPUnit_Framework_TestCase;

class  ActivityTest extends PHPUnit_Framework_TestCase
{
    public function testToNode()
    {
        $activity = new \Ups\Entity\QuantumViewResponse\Activity();

        $xml = $activity->toNode();

        $doc = new DOMDocument();
        $doc->loadXML($xml->ownerDocument->saveXML($xml));
        $this->assertTrue($doc->schemaValidate(__DIR__ . '/../../_files/entities/QuantumViewResponse/Activity.xsd'));
    }
}
