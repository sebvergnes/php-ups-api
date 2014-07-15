<?php
namespace Ups\Entity\RateRequest;

use DOMDocument;
use DOMNode;
use Ups\NodeInterface;

class  Pickup implements NodeInterface
{
    const PKT_DAILY = '01';
    const PKT_CUSTOMERCOUNTER = '03';
    const PKT_ONETIME = '06';
    const PKT_AIR_ONCALL = "07";
    const PKT_LETTERCENTER = "19";
    const PKT_AIR_SERVICECENTER = "20";

    /**
     * @var string
     */
    private $code;

    function __construct($attributes = null)
    {

        if (null !== $attributes) {
            if (isset($attributes->Code)) {
                $this->setCode($attributes->Code);
            }
        }
    }

    /**
     * @param null|DOMDocument $document
     * @return DOMNode
     */
    public function toNode(DOMDocument $document = null)
    {
        if (null === $document) {
            $document = new DOMDocument();
        }

        $node = $document->createElement('Pickup');
        $node->appendChild($document->createElement('Code', $this->getCode()));
        return $node;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

}
