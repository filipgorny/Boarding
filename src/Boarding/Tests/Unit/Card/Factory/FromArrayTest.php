<?php

namespace Boarding\Tests\Unit\Card\Factory;

use Boarding\Card\Factory\FromArray;
use Boarding\Card\Vehicle;

/**
 * Class FromArrayTest
 * @package Boarding\Tests\Unit\Card\Factory
 */
class FromArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testIfProducesCard()
    {
        $data = [
            'from' => 'Stockholm',
            'to' => 'New York JFK',
            'seat' => '7B',
            'type' => 'flight',
            'vehicleIdentifier' => 'SK22',
            'additionalInfo' => [
                'gate' => '22',
                'note' => 'Baggage will we automatically transferred from your last leg'
            ]
        ];

        $fromArrayFactory = new FromArray();

        $card = $fromArrayFactory->createCard($data);

        $this->assertInstanceOf('Boarding\Card', $card);
    }

    public function testIfProducesCardWithData()
    {
        $data = [
            'from' => 'Stockholm',
            'to' => 'New York JFK',
            'seat' => '7B',
            'type' => 'flight',
            'vehicleIdentifier' => 'SK22',
            'additionalInfo' => [
                'gate' => '22',
                'note' => 'Baggage will we automatically transferred from your last leg'
            ]
        ];

        $fromArrayFactory = new FromArray();

        $card = $fromArrayFactory->createCard($data);

        $this->assertInstanceOf('Boarding\Card', $card);

        $this->assertEquals('Stockholm', $card->getFrom());
        $this->assertEquals('New York JFK', $card->getTo());
        $this->assertEquals('7B', $card->getSeat());
        $this->assertInstanceOf('Boarding\Card\Vehicle', $card->getVehicle());
        $this->assertEquals(Vehicle::TYPE_FLIGHT, $card->getVehicle()->getType());
        $this->assertEquals($data['additionalInfo']['gate'], $card->getAdditionalInfo('gate'));
        $this->assertEquals($data['additionalInfo']['note'], $card->getAdditionalInfo('note'));
    }
}
