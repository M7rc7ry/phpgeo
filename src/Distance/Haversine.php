<?php

declare(strict_types=1);

namespace Phpgeo\Distance;

use Phpgeo\Point;
use Phpgeo\Exception\NotConvergingException;
use Phpgeo\Exception\NotMatchingEllipsoidException;

/**
 * Implementation of distance calculation with http://en.wikipedia.org/wiki/Law_of_haversines
 *
 * @see http://en.wikipedia.org/wiki/Law_of_haversines
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Haversine implements DistanceInterface
{
    /**
     * @param Point $point1
     * @param Point $point2
     *
     * @throws NotMatchingEllipsoidException
     *
     * @return float
     */
    public function getDistance(Point $point1, Point $point2): float
    {
        if ($point1->getEllipsoid()->getName() !== $point2->getEllipsoid()->getName()) {
            throw new NotMatchingEllipsoidException('The ellipsoids for both points must match');
        }

        $lat1 = deg2rad($point1->getLat());
        $lat2 = deg2rad($point2->getLat());
        $lng1 = deg2rad($point1->getLng());
        $lng2 = deg2rad($point2->getLng());

        $dLat = $lat2 - $lat1;
        $dLng = $lng2 - $lng1;

        $radius = $point1->getEllipsoid()->getArithmeticMeanRadius();

        $distance = 2 * $radius * asin(
            sqrt(
                (sin($dLat / 2) ** 2)
                + cos($lat1) * cos($lat2) * (sin($dLng / 2) ** 2)
            )
        );

        return round($distance, 3);
    }
}
