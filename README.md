# Boarding cards route finder

## About the project

This is an example project, written in purpose of code style presentation.

It should not be used for a commercial purposes, other than an example of an OOP design solution.

This is the solution for a following code exercise:
* Consider you have a randomly ordered cards, telling about city which you starting from, destination,
seat number, vehicle type and identifier, and the additional info if required.
* Prepare an API which will sort the cards and return a list of routes.
* Translate the result into human readable content.

## How to use

Process of getting boarding legs is as follows:

### Initialize the Api Gateway object.

```php

// configure the factory services
$vehicleFactory = new NamesHashFactory();
$vehicleFactory->registerVehicleType('flight', 'Boarding\\Vehicle\\Flight');
$vehicleFactory->registerVehicleType('train', 'Boarding\\Vehicle\\Train');
$vehicleFactory->registerVehicleType('airport bus', 'Boarding\\Vehicle\\AirportBus');

// initialize mapper dependency (converting cards to route legs)
$cardToLegMapper = new BaseCardMapper();

// initialize descriptor dependency (converting route legs objects to strings)
$descriptor = new BaseDescriptor();

// register description patterns defined in the vehicle classes (they implement a DescriptionPatternInterface interface)
// note you can also pass an instance of vehicle class
$baseDescriptor->addDescriptionPattern('Boarding\Vehicle\Train');
$baseDescriptor->addDescriptionPattern('Boarding\Vehicle\Flight');
$baseDescriptor->addDescriptionPattern('Boarding\Vehicle\AirportBus');

// initialize the api with factories and sorting strategy
$api = new Boarding\Api(new FromArray($vehicleFactory), new QuickSortTopological($cardToLegMapper), $descriptor);

```

### Create the new boarding cards stack instance

```php
$stack = $api->createStack();
```

### Add cards info

```php
$stack->addNewCard([
    'from' => 'Gerona Airport',
    'to' => 'Stockholm',
    'seat' => '3A',
    'type' => 'train',
    'vehicleIdentifier' => 'SK455',
    'additionalInfo' => [
        'gate' => '45B',
        'note' => 'Baggage drop at ticket counter 344.'
    ]
);
```

This method may throw ```php Boarding\Card\Factory\Exception\InvalidCardInputException ``` when the values array is not valid.

### Ask API to search for the route.

```php
$route = $api->findRoute($stack);
```

### Get route as a text

You can get translated text, ready to use on your website or in the console app, by calling a describeRoute method.

```php
$routeDescription = $api->describeRoute($route);

echo $routeDescription->getAsFullText();

```

## Testing

This projects uses PHPUnit as a testing framework. Configuration file is provided in the phpunit.xml.
You may need to just run

```
phpunit
```

in the root folder using your unix console.

## Adding more vehicles

When you want to add a new vehicle, please make another class extending abstract base of Boarding\Vehicle\AbstractVehicle.

It should have an unique name which will be identified in the card's info array. It should also define
the translation description for route and seat (see the DescriptionPatternInterface).
