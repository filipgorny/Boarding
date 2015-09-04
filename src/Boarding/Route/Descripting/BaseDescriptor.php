<?php

namespace Boarding\Route\Descripting;

use Boarding\Route;
use Boarding\Route\Descripting\Exception\UndefinedPatternForVehicleException;

/**
 * Class BaseDescriptor
 * @package Route\Descriping
 */
class BaseDescriptor implements RouteDescriptorInterface
{
    private $patterns = [
        'directions' => [],
        'seat' => []
    ];

    /**
     * This method iterates over a route legs, and based on the vehicles creates a strings of the english based text.
     *
     * @param Route $route
     * @return RouteDescription
     */
    public function describeRoute(Route $route)
    {
        //    EXPECTED RESULT EXAMPLE:
        //    Take train 78A from Madrid to Barcelona. Sit in seat 45B.
        //    Take the airport bus from Barcelona to Gerona Airport. No seat assignment.
        //    From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A.
        //
        //    Baggage drop at ticket counter 344.
        //
        //    From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B.
        //
        //    Baggage will we automatically transferred from your last leg.
        //
        //    You have arrived at your final destination.

        $description = new RouteDescription();

        foreach ($route->getAllLegs() as $leg) {
            $vehicleName = $leg->getVehicle()->getName();

            if (!isset($this->patterns['directions'][$vehicleName]) || !(isset($this->patterns['seat'][$vehicleName]))) {
                throw new UndefinedPatternForVehicleException(
                    'Pattern for vehicle not found: '.$vehicleName
                );
            }

            $directionString = $this->patterns['directions'][$vehicleName];
            $seatString = ($leg->getSeat()) ? $this->patterns['seat'][$vehicleName] : 'No seat assignment.';

            $describedLeg = new DescribedLeg();
            $describedLeg->setMainLine(
                $this->translate(
                    $directionString.' '.$seatString,
                    [
                        'identifier' => $leg->getVehicle()->getIdentifier(),
                        'seat' => $leg->getSeat(),
                        'from' => $leg->getFrom(),
                        'to' => $leg->getTo(),
                        'gate' => $leg->getAdditionalInfo('gate')
                    ]
                )
            );

            if (!empty($leg->getAdditionalInfo('note'))) {
                $describedLeg->setSecondLine($leg->getAdditionalInfo('note'));
            }

            $description->addDescribedLeg($describedLeg);
        }

        return $description;
    }

    /**
     * Parses a template and populates with data.
     *
     * @param $string
     * @param array $data
     * @return string
     */
    private function translate($string, array $data)
    {
        foreach ($data as $k => $v) {
            $string = str_replace('%'.$k, $v, $string);
        }

        return $string;
    }

    /**
     * Add new description pattern that maps a vehicle type into string for describing location source and destination
     * and the seat placement.
     *
     * @param string|object $definitionSource
     */
    public function addDescriptionPattern($definitionSource)
    {
        if (is_string($definitionSource)) {
            if (!(
            new \ReflectionClass($definitionSource))
                ->implementsInterface('Boarding\Route\Descripting\DescriptionPatternInterface')
            ) {
                throw new \InvalidArgumentException(
                    'Given class or object is not am implementation of DescriptionPatternInterface (' . $definitionSource . ').'
                );
            }
        } elseif (is_object($definitionSource)) {
            if (!(
            new \ReflectionObject($definitionSource))
                ->implementsInterface('Boarding\Route\Descripting\DescriptionPatternInterface')
            ) {
                throw new \InvalidArgumentException(
                    'Given class or object is not am implementation of DescriptionPatternInterface (' . get_class($definitionSource) . ').'
                );
            }
        }

        $this->patterns['directions'][$definitionSource::getVehicleName()] = $definitionSource::getDirectionPattern();
        $this->patterns['seat'][$definitionSource::getVehicleName()] = $definitionSource::getSeatPattern();
    }
}
