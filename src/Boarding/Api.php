<?php

namespace Boarding;

use Boarding\Card\Factory\CardFactoryInterface;
use Boarding\Card\Stack;
use Boarding\Route\PathFinding\PathFindingStrategyInterface;
use Boarding\Vehicle\Factory\VehicleFactoryInterface;

/**
 * Class Api
 * @package Boarding
 */
class Api
{
    /**
     * @var CardFactoryInterface
     */
    private $cardFactory;

    /**
     * @var PathFindingStrategyInterface
     */
    private $pathFindingStrategy;

    /**
     * @param CardFactoryInterface $cardFactory
     * @param PathFindingStrategyInterface $pathFindingStrategy
     */
    public function __construct(
        CardFactoryInterface $cardFactory,
        PathFindingStrategyInterface $pathFindingStrategy
    ) {
        $this->cardFactory = $cardFactory;
        $this->pathFindingStrategy = $pathFindingStrategy;
    }

    /**
     * Create a new Stack object instance, using injected factory object
     *
     * @param $data
     * @return Stack
     */
    public function createStack($data)
    {
        $stack = new Stack();

        foreach ($data as $element) {
            $stack->addCard($this->cardFactory->createCard($element));
        }

        return $stack;
    }

    public function findRoute(Stack $stack)
    {

    }
}
