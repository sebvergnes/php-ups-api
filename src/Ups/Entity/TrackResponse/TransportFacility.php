<?php
namespace Ups\Entity\TrackResponse;

use DOMDocument;
use DOMNode;
use Ups\NodeInterface;

class  TransportFacility implements NodeInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $code;

    function __construct($attributes = null)
    {

        if (null !== $attributes) {
            if (isset($attributes->Type)) {
                $this->setType($attributes->Type);
            }
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

        $node = $document->createElement('TransportFacility');
        $node->appendChild($document->createElement('Type', $this->getType()));
        if (null !== $this->getCode()) {
            $node->appendChild($document->createElement('Code', $this->getCode()));
        }
        return $node;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
