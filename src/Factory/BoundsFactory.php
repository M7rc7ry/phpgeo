<?php

declare(strict_types=1);

namespace Phpgeo\Factory;

use InvalidArgumentException;
use Phpgeo\Bearing\BearingInterface;
use Phpgeo\Bounds;
use Phpgeo\Point;

/**
 * Bounds Factory
 */
class BoundsFactory
{
    /**
     * Creates a Bounds instance which corners have the given distance from its center.
     *
     * @param Point $center
     * @param float $distance in meters
     * @param BearingInterface $bearing
     * @return Bounds
     * @throws InvalidArgumentException if bounds crosses the 180/-180 degrees meridian.
     */
    public static function expandFromCenterPoint(
        Point $center,
        float $distance,
        BearingInterface $bearing
    ): Bounds {
        $northWest = $bearing->calculateDestination($center, 315, $distance);
        $southEast = $bearing->calculateDestination($center, 135, $distance);

        return new Bounds($northWest, $southEast);
    }
}
