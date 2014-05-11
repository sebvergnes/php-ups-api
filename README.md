PHP UPS API Wrapper
===================

[![Build Status](https://travis-ci.org/sebvergnes/php-ups-api.png)](https://travis-ci.org/sebvergnes/php-ups-api)

This library is aimed at wrapping all the UPS APIs into a simple to use PHP Library. It currently only covers the Quantum View® and Tracking APIs, but feel free to contribute.

## UPS APIs

To use the UPS APIs, you have to [request an access key from UPS](https://www.ups.com/upsdeveloperkit). For every request, you will have to provide the Access Key, your UPS user ID and password.

## Requirements

This library uses PHP 5.3+.

## Installation

It is recommended that you install the PHP UPS API Wrapper library [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "sebvergnes/ups-api": "dev-master"
    }
}
```

## QuantumView Class

The QuantumView Class allow you to request a Quantum View Data subscription. 

### Example

```php
$quantumView = new UPS\QuantumView($accessKey, $userId, $password);

try {
	// Get the subscription for all events for the last hour
	$events = $quantumView->getSubscription(null, (time() - 3600));
	
	foreach($events as $event) {
		// Your code here
		echo $event->Type;
	}
	
} catch (Exception $e) {
	var_dump($e);
}
```

### Parameters

QuantumView parameters are:

 * `name` Name of subscription requested by user. If _null_, all events will be returned.
 * `beginDateTime` Beginning date time for the retrieval criteria of the subscriptions. Format: Y-m-d H:i:s or Unix timestamp.
 * `endDateTime` Ending date time for the retrieval criteria of the subscriptions. Format: Y-m-d H:i:s or Unix timestamp.
 * `fileName` File name of specific subscription requested by user.
 * `bookmark` Bookmarks the file for next retrieval.

_If you provide a `beginDateTime`, but no `endDateTime`, the `endDateTime` will default to the current date time._

_To use the `fileName` parameter, do not provide a `beginDateTime`._


## Tracking Class

The Tracking Class allow you to track a shipment using the UPS Tracking API. 

### Example

```php
$tracking = new UPS\Tracking($accessKey, $userId, $password);

try {
	$shipment = $tracking->track('TRACKING NUMBER');
		
	foreach($shipment->Package->Activity as $activity) {
		var_dump($activity);
	}
	
} catch (Exception $e) {
	var_dump($e);
}
```

### Parameters

Tracking parameters are:

 * `trackingNumber` The package’s tracking number.
 * `requestOption` Optional processing. For Mail Innovations the only valid options are Last Activity and All activity.


## Rate Class

The Rate Class allow you to get shipment rates using the UPS Rate API.

### Example
```php
$rates = new Rate($access, $userid, $passwd);

try {
    $shopRates = $rates->shopRates($rateRequest);

	foreach($shopRates as $rates) {
		var_dump($rates);
	}

} catch (Exception $e) {
    var_dump($e);
}
```
### Parameters

 * `rateRequest` Mandatory. rateRequest Object with shipment details


## TimeInTransit Class

The TimeInTransit Class allow you to get all transit times using the UPS TimeInTransit API.

### Example
```php
$timeInTransit = new TimeInTransit($access, $userid, $passwd);

try {
    $times = $timeInTransit->getTimeInTransit($timeInTransitRequest);

	foreach($times->ServiceSummary as $serviceSummary) {
		var_dump($serviceSummary);
	}

} catch (Exception $e) {
    var_dump($e);
}
```

### Parameters

 * `timeInTransitRequest` Mandatory. timeInTransitRequest Object with shipment details
