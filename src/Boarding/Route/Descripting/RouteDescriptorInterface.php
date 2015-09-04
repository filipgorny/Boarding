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
}
