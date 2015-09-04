<?php

namespace Boarding\Tests\Unit\Route;

use Boarding\Card;
use Boarding\Route\Leg;
use Boarding\Route\PathFinding\QuickSortTopological;

/**
 * Class QuickSortTopologicalTest
 * @package Boarding\Tests\Unit\Card\Factory
 */
class QuickSortTopologicalTest extends \PHPUnit_Framework_TestCase
{
    public function testIfSortsCorrectly()
    {
        $cards = [
            new Card('london', 'paris'),
            new Card('warsaw', 'berlin'),
            new Card('paris', 'warsaw'),
            new Card('oslo', 'london'),
        ];

        $stack = new Card\Stack();
        $stack->addCards($cards);

        $cardToLegMapper = $this->getMock('Boarding\Route\Leg\CardMapperInterface')
            ->expects($this->once())
            ->method('mapCardToLeg')
            ->will($this->returnCallback(function(Card $card) {
                $leg = new Leg();

                $leg->setSeat($card->getSeat());
                $leg->setTo($card->getTo());
                $leg->setFrom($card->getFrom());
                $leg->setVehicle($card->getVehicle());

                foreach ($card->getAllAdditionalInfo() as $k => $v) {
                    $leg->setAdditionalInfo($k, $v);
                }

                return $leg;
            }));

        $bubbleLegsSorting = new QuickSortTopological($cardToLegMapper);
        $route = $bubbleLegsSorting->findPath($stack);

        $this->assertEquals('oslo', $route->getStartPlace());
        $this->assertEquals('berlin', $route->getEndPlace());
    }
}
