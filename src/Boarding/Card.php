<?php

namespace Boarding;

use Boarding\Vehicle\AbstractVehicle;

/**
 * Class Card
 * @package Boarding
 */
class Card
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
     * Card constructor.
     * @param string $from
     * @param string $to
     * @param string $seat
     * @param AbstractVehicle $vehicle
     */
    public function __construct($from = null, $to = null, $seat = null, AbstractVehicle $vehicle = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->seat = $seat;
        $this->vehicle = $vehicle;
    }

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
     * @return bool
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

    /**
     * @return \string[]
     */
    public function getAllAdditionalInfo()
    {
        return $this->additionalInfo;
    }
}
