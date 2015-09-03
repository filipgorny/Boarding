<?php

namespace Boarding\Tests\Unit\Card\Factory;

use Boarding\Card;
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

        $bubbleLegsSorting = new QuickSortTopological();
        $route = $bubbleLegsSorting->findPath($stack);

        $this->assertEquals('oslo', $route->getStartPlace());
        $this->assertEquals('berlin', $route->getEndPlace());
    }
}
