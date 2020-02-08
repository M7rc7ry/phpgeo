<?php

declare(strict_types=1);

namespace Phpgeo;

use InvalidArgumentException;

/**
 * Bounds Class.
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Bounds
{
    /**
     * @var Point
     */
    protected $northWest;

    /**
     * @var Point
     */
    protected $southEast;

    /**
     * @param Point $northWest
     * @param Point $southEast
     */
    public function __construct(Point $northWest, Point $southEast)
    {
        $this->northWest = $northWest;
        $this->southEast = $southEast;
    }

    /**
     * Getter
     *
     * @return Point
     */
    public function getNorthWest(): Point
    {
        return $this->northWest;
    }

    /**
     * Getter
     *
     * @return Point
     */
    public function getSouthEast(): Point
    {
        return $this->southEast;
    }

    /**
     * @return float
     */
    public function getNorth(): float
    {
        return $this->northWest->getLat();
    }

    /**
     * @return float
     */
    public function getSouth(): float
    {
        return $this->southEast->getLat();
    }

    /**
     * @return float
     */
    public function getWest(): float
    {
        return $this->northWest->getLng();
    }

    /**
     * @return float
     */
    public function getEast(): float
    {
        return $this->southEast->getLng();
    }

    /**
     * Calculates the center of this bounds object and returns it as a
     * Point instance.
     *
     * @return Point
     * @throws InvalidArgumentException
     */
    public function getCenter(): Point
    {
        $centerLat = ($this->getNorth() + $this->getSouth()) / 2;

        return new Point($centerLat, $this->getCenterLng());
    }

    /**
     * @return float
     */
    protected function getCenterLng(): float
    {
        $centerLng = ($this->getEast() + $this->getWest()) / 2;

        $overlap = $this->getWest() > 0 && $this->getEast() < 0;

        if ($overlap && $centerLng > 0) {
            return -180.0 + $centerLng;
        }

        if ($overlap && $centerLng < 0) {
            return 180.0 + $centerLng;
        }

        if ($overlap && $centerLng == 0) {
            return 180.0;
        }

        return $centerLng;
    }
}
