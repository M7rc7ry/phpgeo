<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Polyline;

use Phpgeo\Polyline;

/**
 * GeoJSON Polyline Formatter
 *
 * @author Richard Barnes <rbarnes@umn.edu>
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Polyline $polyline
     *
     * @return string
     */
    public function format(Polyline $polyline): string
    {
        $points = [];

        foreach ($polyline->getPoints() as $point) {
            $points[] = [$point->getLng(), $point->getLat()];
        }

        return json_encode(
            [
                'type' => 'LineString',
                'coordinates' => $points,
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
