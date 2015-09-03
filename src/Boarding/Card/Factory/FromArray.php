<?php

namespace Boarding\Card\Factory;

use Boarding\Card;
use Boarding\Card\Factory\Exception\InvalidCardInputException;
use Boarding\Card\Vehicle;

class FromArray implements CardFactoryInterface
{
    private $requiredFields = [
        'from',
        'to',
        //'seat',
        'type',
        //'vehicleIdentifier',
    ];

    /**
     * @param $data
     * @throws InvalidCardInputException
     * @return Card
     */
    public function createCard($data)
    {
        if (!$this->validFormat($data)) {
            throw new InvalidCardInputException('The card has an invalid format.');
        }

        $card = new Card();
        $card->setFrom($data['from']);
        $card->setTo($data['to']);
        isset($data['seat']) and $card->setSeat($data['seat']);

        try {
            $vehicle = new Vehicle(Vehicle::translateTypeString($data['type']), isset($data['vehicleIdentifier']) ? $data['vehicleIdentifier'] : null);

            $card->setVehicle($vehicle);
        } catch (\OutOfBoundsException $e) {
            throw new InvalidCardInputException('Cannot create vehicle instance ('.$e->getMessage().').');
        }

        if (isset($data['additionalInfo'])) {
            foreach ($data['additionalInfo'] as $k => $v) {
                $card->setAdditionalInfo($k, $v);
            }
        }

        return $card;
    }

    /**
     * Validate if all the required fields exists in the array
     *
     * @param $data
     * @return bool
     */
    private function validFormat($data)
    {
        if (!is_array($data)) {
            return false;
        }

        foreach ($this->requiredFields as $requiredField) {
            if (!array_key_exists($requiredField, $data)) {
                return false;
            }
        }

        return true;
    }
}
