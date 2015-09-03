<?php

namespace Boarding\Card;

/**
 * Class Vehicle
 * @package Boarding
 */
class Vehicle
{
    const TYPE_TRAIN = 'train';
    const TYPE_BUS = 'bus';
    const TYPE_AIRPORT_BUS = 'airport bus';
    const TYPE_FLIGHT = 'flight';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $identifier;

    /**
     * Vehicle constructor.
     * @param string $type
     * @param string $identifier
     */
    public function __construct($type, $identifier = null)
    {
        if (!(
            ($type === self::TYPE_FLIGHT) || ($type === self::TYPE_BUS) || ($type == self::TYPE_TRAIN)
        )) {
                throw new \OutOfBoundsException('Invalid vehicle type');
        }

        $this->type = $type;
        $this->inentifier = $identifier;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->inentifier = $identifier;
    }

    /**
     * Translate type from string to class identifier
     *
     * @param $type
     * @return string
     */
    public static function translateTypeString($type)
    {
        switch ($type) {
            case 'train':
                return self::TYPE_TRAIN;
            case 'flight':
                return self::TYPE_FLIGHT;
            case 'bus':
                return self::TYPE_BUS;
            case 'airport bus':
                return self::TYPE_BUS;
            default:
                throw new \OutOfBoundsException('Type not recognised ('.$type.')');
        }
    }
}
