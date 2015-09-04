<?php

namespace Boarding\Route\Descripting;

/**
 * Interface DescriptionPatternInterface
 * @package Boarding\Route\Descripting
 */
interface DescriptionPatternInterface
{
    /**
     * @return string
     */
    public static function getVehicleName();

    /**
     * @return string
     */
    public static function getDirectionPattern();

    /**
     * @return string
     */
    public static function getSeatPattern();
}
