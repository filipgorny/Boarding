<?php

namespace Boarding\Vehicle;

/**
 * Class AirportBus
 * @package Boarding\Vehicle
 */
class AirportBus extends AbstractVehicle
{
    /**
     * @return string
     */
    public static function getVehicleName()
    {
        return 'airport bus';
    }

    /**
     * @return string
     */
    public static function getDirectionPattern()
    {
        return 'Take the airport bus from %from to %to.';
    }

    /**
     * @return string
     */
    public static function getSeatPattern()
    {
        return 'Sit in seat %seat.';
    }
}
