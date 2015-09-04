<?php

namespace Boarding;

use Boarding\Card\Factory\CardFactoryInterface;
use Boarding\Card\Stack;
use Boarding\Route\Descripting\RouteDescription;
use Boarding\Route\Descripting\RouteDescriptorInterface;
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
     * @var RouteDescriptorInterface
     */
    private $descriptor;

    /**
     * @param CardFactoryInterface $cardFactory
     * @param PathFindingStrategyInterface $pathFindingStrategy
     * @param RouteDescriptorInterface $routeDescriptor
     */
    public function __construct(
        CardFactoryInterface $cardFactory,
        PathFindingStrategyInterface $pathFindingStrategy,
        RouteDescriptorInterface $routeDescriptor
    ) {
        $this->cardFactory = $cardFactory;
        $this->pathFindingStrategy = $pathFindingStrategy;
        $this->descriptor = $routeDescriptor;
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

    /**
     * @param Stack $stack
     * @return Route
     */
    public function findRoute(Stack $stack)
    {
        return $this->pathFindingStrategy->findPath($stack);
    }

    /**
     * @param Route $route
     * @return RouteDescription
     */
    public function describeRoute(Route $route)
    {
        return $this->descriptor->describeRoute($route);
    }
}
