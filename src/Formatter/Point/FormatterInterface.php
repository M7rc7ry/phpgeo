<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Point;

use Phpgeo\Point;

/**
 * Coordinates Formatter Interface
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
interface FormatterInterface
{
    /**
     * @param Point $point
     * @return string
     */
    public function format(Point $point): string;
}
