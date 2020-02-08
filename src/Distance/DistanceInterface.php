<?php

declare(strict_types=1);

namespace Phpgeo\Distance;

use Phpgeo\Point;

/**
 * Interface for Distance Calculator Classes
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
interface DistanceInterface
{
    /**
     * @param Point $point1
     * @param Point $point2
     *
     * @return float distance between the two points in meters
     */
    public function getDistance(Point $point1, Point $point2): float;
}
