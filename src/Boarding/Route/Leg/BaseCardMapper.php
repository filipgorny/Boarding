<?php

namespace Boarding\Route\Leg;

use Boarding\Card;
use Boarding\Route\Leg;

/**
 * Class BaseCardMapper
 * @package Boarding\Route\Leg
 */
class BaseCardMapper implements CardMapperInterface
{
    /**
     * @param Card $card
     * @return Leg
     */
    public function mapCardToLeg(Card $card)
    {
        $leg = new Leg();

        $leg->setSeat($card->getSeat());
        $leg->setTo($card->getTo());
        $leg->setFrom($card->getFrom());
        $leg->setVehicle($card->getVehicle());

        foreach ($card->getAllAdditionalInfo() as $k => $v) {
            $leg->setAdditionalInfo($k, $v);
        }

        return $leg;
    }
}
