<?php

namespace Boarding\Route\Descripting;

use Boarding\Route;

/**
 * Class RouteDescription
 * @package Route\Descriping
 */
class RouteDescription
{
    /**
     * @var DescribedLeg[]
     */
    private $describedLegs = [];

    /**
     * @return string
     *
     */
    public function getAsFullText()
    {
        return implode(PHP_EOL, $this->describedLegs);
    }

    /**
     * @param DescribedLeg $describedLeg
     */
    public function addDescribedLeg(DescribedLeg $describedLeg)
    {
        $this->describedLegs[] = $describedLeg;
    }

    /**
     * @return DescribedLeg[]
     */
    public function getDescribedLegs()
    {
        return $this->describedLegs;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getAsFullText();
    }
}
