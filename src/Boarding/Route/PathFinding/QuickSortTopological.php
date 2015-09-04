<?php

namespace Boarding\Route\PathFinding;

use Boarding\Card;
use Boarding\Card\Stack;
use Boarding\Route;
use Boarding\Route\Leg;

/**
 * Class QuickSortTopological
 * @package Boarding\Route\PathFinding
 */
class QuickSortTopological implements PathFindingStrategyInterface
{
    /**
     * @var Leg\CardMapperInterface
     */
    private $cardToLegMapper;

    /**
     * @param Leg\CardMapperInterface $cardToLegMapper
     */
    public function __construct(Leg\CardMapperInterface $cardToLegMapper)
    {
        $this->cardToLegMapper = $cardToLegMapper;
    }

    /**
     * @param Stack $stack
     * @return Route
     */
    public function findPath(Stack $stack)
    {
        $cards = $this->sortCards(iterator_to_array($stack));

        $route = new Route();

        foreach ($cards as $card) {
            $route->addLeg($this->cardToLegMapper->mapCardToLeg($card));
        }

        return $route;
    }

    /**
     * @param array $cards
     * @return array
     */
    public function sortCards(array $cards)
    {
        $cardsCopy = $cards; // it is an PHP array so no need to clone

        if (count($cards) < 2) {
            return $cards;
        }

        $left = [];
        $right = [];

        foreach ($cards as $currentCard) {
            foreach ($cardsCopy as $cardFromCopies) {
                if ($currentCard->getTo() === $cardFromCopies->getFrom()) {
                    $left[] = $currentCard;
                    break;
                }

                if ($currentCard->getFrom() === $cardFromCopies->getTo()) {
                    $right[] = $currentCard;
                    break;
                }
            }
        }

        return array_merge($this->sortCards($left), $this->sortCards($right));
    }
}
