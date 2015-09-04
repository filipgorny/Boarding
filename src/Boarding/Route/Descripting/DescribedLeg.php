<?php

namespace Boarding\Route\Descripting;

use Boarding\Route;

/**
 * Class DescribedLeg
 * @package Route\Descriping
 */
class DescribedLeg
{
    /**
     * @var string
     */
    private $mainLine;

    /**
     * @var string
     */
    private $secondLine;

    /**
     * DescribedLeg constructor.
     * @param string $mainLine
     * @param string $secondLine
     */
    public function __construct($mainLine = null, $secondLine = null)
    {
        $this->mainLine = $mainLine;
        $this->secondLine = $secondLine;
    }

    /**
     * @return string
     */
    public function getMainLine()
    {
        return $this->mainLine;
    }

    /**
     * @param string $mainLine
     */
    public function setMainLine($mainLine)
    {
        $this->mainLine = $mainLine;
    }

    /**
     * @return string
     */
    public function getSecondLine()
    {
        return $this->secondLine;
    }

    /**
     * @param string $secondLine
     */
    public function setSecondLine($secondLine)
    {
        $this->secondLine = $secondLine;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $line = $this->mainLine;

        if ($this->secondLine) {
            $line .= PHP_EOL.$this->secondLine;
        }

        return $line;
    }
}
