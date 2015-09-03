<?php

namespace Boarding\Vehicle;

/**
 * Class AbstractVehicle
 * @package Boarding\Vehicle
 */
abstract class AbstractVehicle
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @param string $identifier
     */
    public function __construct($identifier)
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
     * @return string
     */
    abstract public function getName();
}
