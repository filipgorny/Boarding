# Boarding cards route finder

## About the project

This is an example project, written in purpose of code style presentation.

It should not be used for a commercial purposes, other than an example of an OOP design solution.

This is the solution for following excersise:
1. Consider you have a randomly ordered cards, telling about city which you starting from, destination,
seat number, vehicle type and identifier, and the additional info if required.
2. Prepare an API which will sort the cards and return a list of routes.
3. Translate the result into human readable content.

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

