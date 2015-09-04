<?php

namespace Boarding\Tests\Route\Descripting;
use Boarding\Route;
use Boarding\Vehicle\Flight;
use Boarding\Vehicle\Train;
use Boarding\Route\Descripting\BaseDescriptor;

/**
 * Class BaseDescriptorTest
 * @package Boarding\Tests\Route\Descripting
 */
class BaseDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $cardsArray = [
        'stockholm - new york' => [
            'from' => 'Stockholm',
            'to' => 'New York JFK',
            'seat' => '7B',
            'type' => 'flight',
            'vehicleIdentifier' => 'SK22',
            'additionalInfo' => [
                'gate' => '22',
                'note' => 'Baggage will we automatically transferred from your last leg'
            ]
        ],
        'gerona airport - stockholm' => [
            'from' => 'Gerona Airport',
            'to' => 'Stockholm',
            'seat' => '3A',
            'type' => 'train',
            'vehicleIdentifier' => 'SK455',
            'additionalInfo' => [
                'gate' => '45B',
                'note' => 'Baggage drop at ticket counter 344.'
            ]
        ],
        'madrid - barcelona' => [
            'from' => 'Madrid',
            'to' => 'Barcelona',
            'seat' => '45B',
            'type' => 'train',
            'vehicleIdentifier' => '78A'
        ],
        'barcelona - gerona airport' => [
            'from' => 'Barcelona',
            'to' => 'Gerona Airport',
            'seat' => null,
            'type' => 'airport bus',
            'vehicleIdentifier' => null
        ],
    ];

    public function testIfDescribesCorrectly()
    {
        $expectedText = <<<EOT
Take train 78A from Madrid to Barcelona. Sit in seat 45B.
From Barcelona, take flight SK455 to Stockholm. Gate D2, seat 3A.
Baggage drop at ticket counter 344.
EOT;

        $route = new Route();

        $leg1 = new Route\Leg();
        $leg1->setFrom('Madrid');
        $leg1->setTo('Barcelona');
        $leg1->setSeat('45B');

        $train1 = new Train();
        $train1->setIdentifier('78A');

        $leg1->setVehicle($train1);

        $route->addLeg($leg1);

        $leg2 = new Route\Leg();
        $leg2->setFrom('Barcelona');
        $leg2->setTo('Stockholm');
        $leg2->setSeat('3A');

        $flight1 = new Flight();
        $flight1->setIdentifier('SK455');

        $leg2->setVehicle($flight1);

        $leg2->setAdditionalInfo('note', 'Baggage drop at ticket counter 344.');
        $leg2->setAdditionalInfo('gate', 'D2');

        $route->addLeg($leg2);

        $baseDescriptor = new BaseDescriptor();

        $baseDescriptor->addDescriptionPattern('Boarding\Vehicle\Train');
        $baseDescriptor->addDescriptionPattern('Boarding\Vehicle\Flight');

        $description = $baseDescriptor->describeRoute($route);

        $this->assertEquals($expectedText, $description->getAsFullText());
    }
}
