<?php

namespace Boarding;

use Boarding\Route\Leg;

/**
 * Class Route
 * @package Boarding
 */
class Route implements \ArrayAccess
{
    /**
     * @var Leg[]
     */
    private $legs;

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->legs[$offset]);
    }

    /**
     * @param mixed $offset
     * @return Leg
     */
    public function offsetGet($offset)
    {
        return $this->legs[$offset];
    }

    /**
     * @param mixed $offset
     * @param Leg $value
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof Leg) {
            throw new \InvalidArgumentException('Value is not an instance of Leg');
        }

        $this->legs[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->legs[$offset]);
    }

    /**
     * @return string|null
     */
    public function getStartPlace()
    {
        if (count($this->legs) > 0) {
            return $this->legs[0]->getFrom();
        }
    }

    /**
     * @return string|null
     */
    public function getEndPlace()
    {
        if (count($this->legs) > 0) {
            return $this->legs[count($this->legs)-1]->getTo();
        }
    }

    /**
     * @param Leg $leg
     */
    public function addLeg(Leg $leg)
    {
        $this->legs[] = $leg;
    }

    /**
     * @param $index
     * @return Leg
     */
    public function getLeg($index)
    {
        return $this->offsetGet($index);
    }

    /**
     * @return Route\Leg[]
     */
    public function getAllLegs()
    {
        return $this->legs;
    }
}
