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
    private $patters = [
        'directions' => [
            'train' => 'Take train %identifier from %from to %to.',
            'airport bus' => 'Take the airport bus from %from to %to.',
            'flight' => 'From %from, take flight %identifier to %to.'
        ],
        'seat' => [
            'train' => 'Sit in seat %seat.',
            'airport bus' => 'Sit in seat %seat.',
            'flight' => 'Gate %gate, seat %seat.'
        ]
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

            if (!isset($this->patters['directions'][$vehicleName]) || !(isset($this->patters['seat'][$vehicleName]))) {
                throw new UndefinedPatternForVehicleException(
                    'Pattern for vehicle not found: '.$vehicleName
                );
            }

            $directionString = $this->patters['directions'][$vehicleName];
            $seatString = ($leg->getSeat()) ? $this->patters['seat'][$vehicleName] : 'No seat assignment.';

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
}
