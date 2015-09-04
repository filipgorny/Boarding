<?php

namespace Boarding\Route\Descripting;

use Boarding\Route;

/**
 * Interface RouteDescriptorInterface
 * @package Route\Descriping
 */
interface RouteDescriptorInterface
{
    /**
     * @param Route $route
     * @return RouteDescription
     */
    public function describeRoute(Route $route);

    /**
     * Add new description pattern that maps a vehicle type into string for describing location source and destination
     * and the seat placement.
     *
     * @param string|object $definitionSource
     */
    public function addDescriptionPattern($definitionSource);

    /**
     * Bulk add a description patterns
     *
     * @see RouteDescriptorInterface::addDescriptionPattern
     *
     * @param $definitionSources
     */
    public function addDescriptionPatterns($definitionSources);
}
