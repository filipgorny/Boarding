<?php

namespace Boarding\Vehicle;

use Boarding\Route\Descripting\DescriptionPatternInterface;

/**
 * Class AbstractVehicle
 * @package Boarding\Vehicle
 */
abstract class AbstractVehicle implements DescriptionPatternInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @param string $identifier
     */
    public function __construct($identifier = null)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::getVehicleName();
    }
}
