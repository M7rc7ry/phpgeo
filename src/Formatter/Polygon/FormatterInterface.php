<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Polygon;

use Phpgeo\Polygon;

/**
 * Polygon Formatter Interface
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 * @author Richard Barnes <rbarnes@umn.edu>
 */
interface FormatterInterface
{
    /**
     * @param Polygon $polygon
     *
     * @return string
     */
    public function format(Polygon $polygon): string;
}
