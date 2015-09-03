<?php

namespace Boarding\Tests\Unit\Card\Factory;

use Boarding\Vehicle\Factory\NamesHashFactory;

/**
 * Class NamesHashFactoryTest
 * @package Boarding\Tests\Unit\Card\Factory
 */
class NamesHashFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIfInitializesVehicle()
    {
        $vehicleFactory = new NamesHashFactory();
        $vehicleFactory->registerVehicleType('flight', 'Boarding\\Vehicle\\Flight');
        $vehicleFactory->registerVehicleType('train', 'Boarding\\Vehicle\\Train');
        $vehicleFactory->registerVehicleType('airport bus', 'Boarding\\Vehicle\\AirportBus');

        $this->assertInstanceOf('Boarding\\Vehicle\\Flight', $vehicleFactory->initialize('flight'));
        $this->assertInstanceOf('Boarding\\Vehicle\\Train', $vehicleFactory->initialize('train'));
        $this->assertInstanceOf('Boarding\\Vehicle\\AirportBus', $vehicleFactory->initialize('airport bus'));
    }

    public function testSetsTheIdentifier()
    {
        $vehicleFactory = new NamesHashFactory();
        $vehicleFactory->registerVehicleType('flight', 'Boarding\\Vehicle\\Flight');

        $flight = $vehicleFactory->initialize('flight', '123');

        $this->assertEquals('123', $flight->getIdentifier());
    }
}
