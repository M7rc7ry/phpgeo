<?php

declare(strict_types=1);

namespace Phpgeo\Processor\Polyline;

use Phpgeo\Polyline;

/**
 * Interface for simplifying a polyline
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
interface SimplifyInterface
{
    /**
     * Simplifies the given polyline
     *
     * @param Polyline $polyline
     *
     * @return Polyline
     */
    public function simplify(Polyline $polyline): Polyline;
}
