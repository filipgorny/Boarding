<?php

namespace Boarding\Route\PathFinding;

use Boarding\Card\Stack;
use Boarding\Route;

/**
 * This interface represents both a creation and sorting algorithm for a Route.
 *
 * Interface PathFindingStrategyInterface
 * @package Boarding\Route\PathFinding
 */
interface PathFindingStrategyInterface
{
    /**
     * @param Stack $stack
     * @return Route
     */
    public function findPath(Stack $stack);
}
