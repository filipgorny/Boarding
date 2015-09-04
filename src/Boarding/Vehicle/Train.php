<?php

namespace Boarding\Vehicle;

/**
 * Class Train
 * @package Boarding\Vehicle
 */
class Train extends AbstractVehicle
{
    /**
     * @return string
     */
    public static function getVehicleName()
    {
        return 'train';
    }

    /**
     * @return string
     */
    public static function getDirectionPattern()
    {
        return 'Take train %identifier from %from to %to.';
    }

    /**
     * @return string
     */
    public static function getSeatPattern()
    {
        return 'Sit in seat %seat.';
    }
}
