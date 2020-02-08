<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Polyline;

use Phpgeo\Polyline;

/**
 * Polyline Formatter Interface
 *
 * @author Richard Barnes <rbarnes@umn.edu>
 */
interface FormatterInterface
{
    /**
     * @param Polyline $polyline
     *
     * @return string
     */
    public function format(Polyline $polyline): string;
}
