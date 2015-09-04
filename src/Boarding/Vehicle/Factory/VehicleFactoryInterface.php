<?php

namespace Boarding\Vehicle\Factory;

use Boarding\Vehicle\AbstractVehicle;

/**
 * Class VehicleFactoryInterface
 * @package Boarding\Vehicle\Factory
 */
interface VehicleFactoryInterface
{
    /**
     * @param string $name
     * @param string|null $identifier
     * @return AbstractVehicle
     */
    public function initialize($name, $identifier = null);

    /**
     * @return string[]
     */
    public function getRegisteredVehicles();
}
