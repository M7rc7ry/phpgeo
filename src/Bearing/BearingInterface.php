<?php

declare(strict_types=1);

namespace Phpgeo\Bearing;

use Phpgeo\Point;

/**
 * Interface BearingInterface
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
interface BearingInterface
{
    /**
     * This method calculates the initial bearing between the
     * two points.
     *
     * @param Point $point1
     * @param Point $point2
     *
     * @return float Bearing Angle
     */
    public function calculateBearing(Point $point1, Point $point2): float;

    /**
     * Calculates the final bearing between the two points.
     *
     * @param Point $point1
     * @param Point $point2
     *
     * @return float
     */
    public function calculateFinalBearing(Point $point1, Point $point2): float;

    /**
     * Calculates a destination point for the given point, bearing angle,
     * and distance.
     *
     * @param Point $point
     * @param float $bearing the bearing angle between 0 and 360 degrees
     * @param float $distance the distance to the destination point in meters
     *
     * @return Point
     */
    public function calculateDestination(Point $point, float $bearing, float $distance): Point;
}
