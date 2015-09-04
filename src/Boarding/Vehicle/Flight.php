<?php

namespace Boarding\Vehicle;

/**
 * Class Flight
 * @package Boarding\Vehicle
 */
class Flight extends AbstractVehicle
{
    /**
     * @return string
     */
    public static function getVehicleName()
    {
        return 'flight';
    }

    /**
     * @return string
     */
    public static function getDirectionPattern()
    {
        return 'From %from, take flight %identifier to %to.';
    }

    /**
     * @return string
     */
    public static function getSeatPattern()
    {
        return 'Gate %gate, seat %seat.';
    }
}
