<?php

namespace Boarding\Route\Leg;

use Boarding\Card;

/**
 * Interface CardMapperInterface
 * @package Boarding\Route\Leg
 */
interface CardMapperInterface
{
    public function mapCardToLeg(Card $card);
}
