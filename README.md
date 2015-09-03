# Boarding cards route finder

## About the project

This is an example project, written in purpose of code style presentation.

TODO add info what it does

## How to use

Process of getting boarding legs:
1. Initialize the Api Gateway object.

```php
$api = new Boarding\Api(new FromArray(), new Bubble());
```

Note you can change the injected factory and strategy, see the documentation of Api constructor method.

2. Create the new boarding cards stack instance

```php
$stack = $api->createStack();
```

3. Add cards info

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

4. Ask API to search for the route.

```php
$route = $api->findRoute($stack);
```
