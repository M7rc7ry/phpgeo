<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Polygon;

use Phpgeo\Point;
use Phpgeo\Exception\InvalidPolygonException;
use Phpgeo\Polygon;

/**
 * GeoJSON Polygon Formatter
 *
 * @author Richard Barnes <rbarnes@umn.edu>
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Polygon $polygon
     *
     * @return string
     *
     * @throws InvalidPolygonException
     */
    public function format(Polygon $polygon): string
    {
        if ($polygon->getNumberOfPoints() < 3) {
            throw new InvalidPolygonException('A polygon must consist of at least three points.');
        }

        $points = [];

        /** @var Point $point */
        foreach ($polygon->getPoints() as $point) {
            $points[] = [$point->getLng(), $point->getLat()];
        }

        return json_encode(
            [
                'type' => 'Polygon',
                'coordinates' => [$points],
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
