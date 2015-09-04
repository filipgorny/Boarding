<?php

namespace Boarding\Route;

use Boarding\Card;
use Boarding\Vehicle\AbstractVehicle;

/**
 * This is mostly a wrapper on a Card class.
 * Instantiation of a Leg class symbolizes the sorted route element.
 *
 * Class Leg
 * @package Boarding\Route
 */
class Leg
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $seat;

    /**
     * @var AbstractVehicle
     */
    private $vehicle;

    /**
     * @var string[]
     */
    private $additionalInfo = [];

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * @param string $seat
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;
    }

    /**
     * @return AbstractVehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param AbstractVehicle $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * @param $name
     * @return null|string
     */
    public function getAdditionalInfo($name)
    {
        return isset($this->additionalInfo[$name]) ? $this->additionalInfo[$name] : null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setAdditionalInfo($name, $value)
    {
        $this->additionalInfo[$name] = $value;
    }
}
