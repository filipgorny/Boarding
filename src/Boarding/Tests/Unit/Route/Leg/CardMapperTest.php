<?php

namespace Boarding\Tests\Route\Leg;

use Boarding\Card;
use Boarding\Route\Leg\BaseCardMapper;
use Boarding\Vehicle\Train;

/**
 * Class CardMapperTest
 * @package Boarding\Tests\Route\Leg
 */
class CardMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testMapsCardToLeg()
    {
        $data = [
            'to' => 'london',
            'from' => 'poznan',
            'seat' => '23b',
            'additionalInfo' => [
                'note' => 'test'
            ],
            'type' => 'train',
            'vehicleIdentifier' => '123'
        ];

        $card = new Card();
        $card->setTo($data['to']);
        $card->setFrom($data['from']);
        $card->setSeat($data['seat']);
        $card->setAdditionalInfo('note', $data['additionalInfo']['note']);
        $card->setVehicle(new Train($data['vehicleIdentifier']));

        $mapper = new BaseCardMapper();
        $leg = $mapper->mapCardToLeg($card);

        $this->assertEquals($card->getFrom(), $leg->getFrom());
        $this->assertEquals($card->getTo(), $leg->getTo());
        $this->assertEquals($card->getSeat(), $leg->getSeat());
        $this->assertEquals($card->getAdditionalInfo('note'), $leg->getAdditionalInfo('note'));
        $this->assertEquals($card->getVehicle()->getIdentifier(), $leg->getVehicle()->getIdentifier());
    }
}
