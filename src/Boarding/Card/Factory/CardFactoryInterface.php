<?php

namespace Boarding\Card\Factory;

use Boarding\Card\Factory\Exception\InvalidCardInputException;
use Boarding\Card;

interface CardFactoryInterface
{
    /**
     * @param $data
     * @throws InvalidCardInputException
     * @return Card
     */
    public function createCard($data);
}
