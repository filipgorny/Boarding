<?php

namespace Boarding\Route;

use Boarding\Card;
use Boarding\Card\Vehicle;

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
     * @var Vehicle
     */
    private $vehicle;

    /**
     * @var string[]
     */
    private $additionalInfo = [];

    /**
     * @param Card $card
     */
    public function __construct(Card $card)
    {
        $this->from = $card->getFrom();
        $this->to = $card->getTo();
        $this->vehicle = $card->getVehicle();
        $this->additionalInfo = $card->getAllAdditionalInfo();
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
     * @return Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * @return \string[]
     */
    public function getAdditionalInfo($name)
    {
        return $this->additionalInfo[$name];
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
