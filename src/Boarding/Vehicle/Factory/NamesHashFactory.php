<?php

namespace Boarding\Vehicle\Factory;

use Boarding\Vehicle\AbstractVehicle;

/**
 * Class NamesHashFactory
 * @package Boarding\Vehicle\Factory
 */
class NamesHashFactory implements VehicleFactoryInterface
{
    /**
     * @var string[]
     */
    private $knownTypes;

    /**
     * @param $type
     * @param $class
     */
    public function registerVehicleType($type, $class)
    {
        $this->knownTypes[$type] = $class;
    }

    /**
     * @param string $name
     * @param string|null $identifier
     * @return AbstractVehicle
     */
    public function initialize($name, $identifier = null)
    {
        if (!isset($this->knownTypes[$name])) {
            throw new \OutOfBoundsException('Vehicle type not registered: '.$name);
        }

        $vehicle = new $this->knownTypes[$name]($identifier);

        return $vehicle;
    }

    /**
     * @return string[]
     */
    public function getRegisteredVehicles()
    {
        return $this->knownTypes;
    }
}
