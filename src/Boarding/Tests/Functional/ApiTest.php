<?php

namespace Boarding\Tests\Functional;

use Boarding\Api;
use Boarding\Card\Factory\FromArray;
use Boarding\Card\Vehicle;
use Boarding\Route\Descripting\BaseDescriptor;
use Boarding\Route\Leg\BaseCardMapper;
use Boarding\Route\PathFinding\Bubble;
use Boarding\Route\PathFinding\QuickSortTopological;
use Boarding\Vehicle\Factory\NamesHashFactory;

class ApiTest extends \PHPUnit_Framework_TestCase
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

    /**
     * The api should create a valid stack of cards
     */
    public function testCreatesValidStack()
    {
        $vehicleFactory = new NamesHashFactory();
        $vehicleFactory->registerVehicleType('flight', 'Boarding\\Vehicle\\Flight');
        $vehicleFactory->registerVehicleType('train', 'Boarding\\Vehicle\\Train');
        $vehicleFactory->registerVehicleType('airport bus', 'Boarding\\Vehicle\\AirportBus');

        $cardToLegMapper = new BaseCardMapper();

        $descriptor = new BaseDescriptor();

        $api = new Api(new FromArray($vehicleFactory), new QuickSortTopological($cardToLegMapper), $descriptor);

        $stack = $api->createStack($this->cardsArray);

        $this->assertInstanceOf('Boarding\Card\Stack', $stack, 'Api did not create a stack.');
        $this->assertEquals(4, $stack->getLength());
    }

    /**
     * The api should be able to return sorted route
     */
    public function testFindValidRoute()
    {
        /*
            EXPECTED RESULT:

            Take train 78A from Madrid to Barcelona. Sit in seat 45B.
            Take the airport bus from Barcelona to Gerona Airport. No seat assignment.
            From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A.

            Baggage drop at ticket counter 344.

            From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B.

            Baggage will we automatically transferred from your last leg.

            You have arrived at your final destination.
         */

        $vehicleFactory = new NamesHashFactory();
        $vehicleFactory->registerVehicleType('flight', 'Boarding\\Vehicle\\Flight');
        $vehicleFactory->registerVehicleType('train', 'Boarding\\Vehicle\\Train');
        $vehicleFactory->registerVehicleType('airport bus', 'Boarding\\Vehicle\\AirportBus');

        $cardToLegMapper = new BaseCardMapper();

        $descriptor = new BaseDescriptor();

        $api = new Api(new FromArray($vehicleFactory), new QuickSortTopological($cardToLegMapper), $descriptor);

        $stack = $api->createStack($this->cardsArray);

        $route = $api->findRoute($stack);

        $this->assertInstanceOf('Boarding\Route', $route);

        $this->assertInstanceOf('Boarding\Route\Leg', $route->getLeg(0));

        $manuallySortedListOfCards = [
            $this->cardsArray['madrid - barcelona'],
            $this->cardsArray['barcelona - gerona airport'],
            $this->cardsArray['gerona airport - stockholm'],
            $this->cardsArray['stockholm - new york']
        ];

        foreach ($manuallySortedListOfCards as $index => $data) {
            $leg = $route[$index];

            $this->assertInstanceOf('Boarding\Route\Leg', $leg);

            $this->assertEquals(
                $data['from'],
                $leg->getFrom(),
                'Route from does not match, '
                .$data['from']
                .' - '
                .$data['to']
                .' corresponding to '
                .$leg->getFrom()
                .' - '.$leg->getTo()
            );

            $this->assertEquals($data['to'], $leg->getTo());
            $this->assertEquals($data['seat'], $leg->getSeat());
            $this->assertInstanceOf('Boarding\Vehicle\AbstractVehicle', $leg->getVehicle());
            $this->assertEquals($data['type'], $leg->getVehicle()->getName());

            if (isset($data['additionalInfo'])) {
                $this->assertEquals($data['additionalInfo']['gate'], $leg->getAdditionalInfo('gate'));
                $this->assertEquals($data['additionalInfo']['note'], $leg->getAdditionalInfo('note'));
            }
        }
    }

    /**
     * The api should be able to produce text from input
     */
    public function testDescribesRoute()
    {
        $descriptor = new BaseDescriptor();

        $vehicleFactory = new NamesHashFactory();
        $vehicleFactory->registerVehicleType('train', 'Boarding\\Vehicle\\Train');

        $cardToLegMapper = new BaseCardMapper();

        $api = new Api(new FromArray($vehicleFactory), new QuickSortTopological($cardToLegMapper), $descriptor);

        $stack = $api->createStack([$this->cardsArray['madrid - barcelona']]);
        $route = $api->findRoute($stack);

        $this->assertEquals(
            'Take train 78A from Madrid to Barcelona. Sit in seat 45B.',
            $api->describeRoute($route)->getAsFullText()
        );
    }
}
