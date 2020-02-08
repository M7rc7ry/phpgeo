<?php

declare(strict_types=1);

namespace Phpgeo\Bearing;

use Phpgeo\Point;

/**
 * Value object for a "Direct Vincenty" bearing calculation result.
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class DirectVincentyBearing
{
    /**
     * @var Point
     */
    private $destination;

    /**
     * @var float
     */
    private $bearingFinal;

    /**
     * Bearing constructor.
     *
     * @param Point $destination
     * @param float $bearingFinal
     */
    public function __construct(Point $destination, float $bearingFinal)
    {
        $this->destination  = $destination;
        $this->bearingFinal = $bearingFinal;
    }

    /**
     * @return Point
     */
    public function getDestination(): Point
    {
        return $this->destination;
    }

    /**
     * @return float
     */
    public function getBearingFinal(): float
    {
        return $this->bearingFinal;
    }
}
