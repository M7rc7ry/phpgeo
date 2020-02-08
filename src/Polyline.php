<?php

declare(strict_types=1);

namespace Phpgeo;

use Phpgeo\Distance\DistanceInterface;
use Phpgeo\Exception\InvalidGeometryException;
use Phpgeo\Formatter\Polyline\FormatterInterface;

/**
 * Polyline Implementation
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class Polyline implements GeometryInterface
{
    use GetBoundsTrait;

    /**
     * @var Point[]
     */
    protected $points = [];

    /**
     * @param Point $point
     *
     * @return void
     */
    public function addPoint(Point $point)
    {
        $this->points[] = $point;
    }

    /**
     * Adds an unique point to the polyline. A maximum allowed distance for
     * same point comparison can be provided. Default allowed distance
     * deviation is 0.001 meters (1 millimeter).
     *
     * @param Point $point
     * @param float $allowedDistance
     *
     * @return void
     */
    public function addUniquePoint(Point $point, float $allowedDistance = .001)
    {
        if ($this->containsPoint($point, $allowedDistance)) {
            return;
        }

        $this->addPoint($point);
    }

    /**
     * @return Point[]
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @return int
     */
    public function getNumberOfPoints(): int
    {
        return count($this->points);
    }

    /**
     * @param Point $point
     * @param float $allowedDistance
     *
     * @return bool
     */
    public function containsPoint(Point $point, float $allowedDistance = .001): bool
    {
        foreach ($this->points as $existingPoint) {
            if ($existingPoint->hasSameLocation($point, $allowedDistance)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param FormatterInterface $formatter
     *
     * @return string
     */
    public function format(FormatterInterface $formatter): string
    {
        return $formatter->format($this);
    }

    /**
     * @return Line[]
     */
    public function getSegments(): array
    {
        $length = count($this->points);
        $segments = [];

        if ($length <= 1) {
            return $segments;
        }

        for ($i = 1; $i < $length; $i++) {
            $segments[] = new Line($this->points[$i - 1], $this->points[$i]);
        }

        return $segments;
    }

    /**
     * Calculates the length of the polyline.
     *
     * @param DistanceInterface $calculator instance of distance calculation class
     *
     * @return float
     */
    public function getLength(DistanceInterface $calculator): float
    {
        $distance = 0.0;

        if (count($this->points) <= 1) {
            return $distance;
        }

        foreach ($this->getSegments() as $segment) {
            $distance += $segment->getLength($calculator);
        }

        return $distance;
    }

    /**
     * Create a new polyline with reversed order of points, i. e. reversed
     * polyline direction.
     *
     * @return Polyline
     */
    public function getReverse(): Polyline
    {
        $reversed = new static();

        foreach (array_reverse($this->points) as $point) {
            $reversed->addPoint($point);
        }

        return $reversed;
    }

    /**
     * Returns the point which is defined by the avarages of all
     * latitude/longitude values.
     *
     * This currently only works for polylines which don't cross the dateline at
     * 180/-180 degrees longitude.
     *
     * @return Point
     *
     * @throws InvalidGeometryException when the polyline doesn't contain any points.
     */
    public function getAveragePoint(): Point
    {
        $latitude = 0.0;
        $longitude = 0.0;
        $numberOfPoints = count($this->points);

        if ($this->getNumberOfPoints() === 0) {
            throw new InvalidGeometryException('Polyline doesn\'t contain points', 9464188927);
        }

        foreach ($this->points as $point) {
            /* @var $point Point */
            $latitude += $point->getLat();
            $longitude += $point->getLng();
        }

        $latitude /= $numberOfPoints;
        $longitude /= $numberOfPoints;

        return new Point($latitude, $longitude);
    }
}
