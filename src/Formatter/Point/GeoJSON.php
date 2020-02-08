<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Point;

use Phpgeo\Point;

/**
 * GeoJSON Coordinates Formatter
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class GeoJSON implements FormatterInterface
{
    /**
     * @param Point $point
     *
     * @return string
     */
    public function format(Point $point): string
    {
        return json_encode(
            [
                'type' => 'Point',
                'coordinates' => [
                    $point->getLng(),
                    $point->getLat(),
                ],
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
