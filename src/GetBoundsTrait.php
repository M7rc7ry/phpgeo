<?php

declare(strict_types=1);

namespace Phpgeo;

/**
 * Trait GetBoundsTrait
 *
 * @package Location
 *
 * @property Point[] $points
 */
trait GetBoundsTrait
{
    /**
     * @return Point[]
     */
    abstract public function getPoints(): array;

    /**
     * @return Bounds
     */
    public function getBounds(): Bounds
    {
        $latMin = 90.0;
        $latMax = -90.0;
        $lngMin = 180.0;
        $lngMax = -180.0;

        foreach ($this->getPoints() as $point) {
            $latMin = min($point->getLat(), $latMin);
            $lngMin = min($point->getLng(), $lngMin);
            $latMax = max($point->getLat(), $latMax);
            $lngMax = max($point->getLng(), $lngMax);
        }

        return new Bounds(
            new Point($latMax, $lngMin),
            new Point($latMin, $lngMax)
        );
    }
}
