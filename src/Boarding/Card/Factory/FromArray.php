<?php

namespace Boarding\Card\Factory;

use Boarding\Card;
use Boarding\Card\Factory\Exception\InvalidCardInputException;
use Boarding\Card\Vehicle;
use Boarding\Vehicle\AbstractVehicle;
use Boarding\Vehicle\Factory\VehicleFactoryInterface;

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
     * @var VehicleFactoryInterface
     */
    private $vehicleFactory;

    /**
     * @param VehicleFactoryInterface $vehicleFactory
     */
    public function __construct(VehicleFactoryInterface $vehicleFactory)
    {
        $this->vehicleFactory = $vehicleFactory;
    }

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
            $vehicle = $this->vehicleFactory->initialize($data['type'], isset($data['vehicleIdentifier']) ? $data['vehicleIdentifier'] : null);

            if (!$vehicle instanceof AbstractVehicle) {
                throw new InvalidCardInputException('Vehicle type not registered: '.$data['type']);
            }

            $card->setVehicle($vehicle);
        } catch (\OutOfBoundsException $e) {
            throw new InvalidCardInputException('Vehicle type not registered: '.$data['type']);
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
