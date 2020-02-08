<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Point;

use Phpgeo\Point;

/**
 * Coordinates Formatter "Decimal Degrees"
 *
 * @author Marcus Jaschen <mjaschen@gmail.com>
 */
class DecimalDegrees implements FormatterInterface
{
    /**
     * @var string Separator string between latitude and longitude
     */
    protected $separator;

    /**
     * @var int
     */
    protected $digits = 5;

    /**
     * @param string $separator
     * @param int $digits
     */
    public function __construct(string $separator = ' ', int $digits = 5)
    {
        $this->separator = $separator;
        $this->digits    = $digits;
    }

    /**
     * @param Point $point
     *
     * @return string
     */
    public function format(Point $point): string
    {
        return sprintf(
            '%.' . $this->digits . 'f%s%.' . $this->digits . 'f',
            $point->getLat(),
            $this->separator,
            $point->getLng()
        );
    }

    /**
     * Sets the separator between latitude and longitude values
     *
     * @param string $separator
     *
     * @return $this
     */
    public function setSeparator(string $separator): DecimalDegrees
    {
        $this->separator = $separator;

        return $this;
    }
}
