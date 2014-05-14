<?php

namespace Ups;

use DOMDocument;
use SimpleXMLElement;
use Exception;
use Ups\Entity\RateRequest;
use Ups\Entity\RateResponse;

/**
 * Rate API Wrapper
 *
 * @package ups
 * @author Michael Williams <michael.williams@limelyte.com>
 */
class Rate extends Ups
{
    private $requestOption;

    protected $endpoint = '/Rate';

    public function shopRates($rateRequest)
    {
        $this->requestOption = "Shop";

        return $this->sendRequest($rateRequest);
    }

    public function getRate($rateRequest)
    {
        $this->requestOption = "Rate";

        return $this->sendRequest($rateRequest);
    }

    /**
     * Creates and sends a request for the given shipment. This handles checking for
     * errors in the response back from UPS
     *
     * @param $rateRequest
     * @return RateRequest
     * @throws \Exception
     */
    private function sendRequest($rateRequest)
    {
        $request = $this->createRequest($rateRequest);
        $response = $this->request($this->createAccess(), $request, $this->compileEndpointUrl($this->endpoint));

        if ($response->Response->ResponseStatusCode == 0) {
            throw new Exception(
                "Failure ({$response->Response->Error->ErrorSeverity}): {$response->Response->Error->ErrorDescription}",
                (int)$response->Response->Error->ErrorCode
            );
        } else {
            return $this->formatResponse($response);
        }
    }

    /**
     * Create the Rate request
     *
     * @param RateRequest $rateRequest The request details. Refer to the UPS documentation for available structure
     * @return  string
     */
    private function createRequest($rateRequest)
    {
        $shipment = $rateRequest->Shipment;

        $xml = new DOMDocument();
        $xml->formatOutput = true;

        $trackRequest = $xml->appendChild($xml->createElement("RatingServiceSelectionRequest"));
        $trackRequest->setAttribute('xml:lang', 'en-US');

        $request = $trackRequest->appendChild($xml->createElement("Request"));

        $node = $xml->importNode($this->createTransactionNode(), true);
        $request->appendChild($node);

        $request->appendChild($xml->createElement("RequestAction", "Rate"));
        $request->appendChild($xml->createElement("RequestOption", $this->requestOption));

        $shipmentNode = $trackRequest->appendChild($xml->createElement('Shipment'));

        // Support specifying an individual service
        if (isset($shipment->Service)) {
            $serviceNode = $shipmentNode->appendChild($xml->createElement('Service'));
            Utilities::appendChild($shipment->Service, 'Code', $serviceNode);
            Utilities::appendChild($shipment->Service, 'Description', $serviceNode);
        }

        if (isset($shipment->Shipper)) {
            $shipper = $shipmentNode->appendChild($xml->createElement("Shipper"));

            if (isset($shipment->Shipper->ShipperNumber)) {
                $shipper->appendChild($xml->createElement("ShipperNumber", $shipment->Shipper->ShipperNumber));
            }

            if (isset($shipment->Shipper->Address)) {
                Utilities::addAddressNode($shipment->Shipper->Address, $shipper);
            }
        }

        if (isset($shipment->ShipFrom)) {
            $shipFrom = $shipmentNode->appendChild($xml->createElement("ShipFrom"));
            Utilities::addLocationInformation($shipment->ShipFrom, $shipFrom);
        }

        if (isset($shipment->ShipTo)) {
            $shipTo = $shipmentNode->appendChild($xml->createElement("ShipTo"));
            Utilities::addLocationInformation($shipment->ShipTo, $shipTo);
        }

        Utilities::addPackages($shipment, $shipmentNode);

        return $xml->saveXML();
    }

    /**
     * Format the response
     *
     * @param   SimpleXMLElement $response
     * @return  stdClass
     */
    private function formatResponse(SimpleXMLElement $response)
    {
        // We don't need to return data regarding the response to the user
        unset($response->Response);

        $result = $this->convertXmlObject($response);

        return new RateResponse($result);
    }
}