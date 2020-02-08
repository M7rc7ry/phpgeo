<?php

declare(strict_types=1);

namespace Phpgeo;

interface GeometryInterface
{
    /**
     * Returns an array containing all assigned points.
     *
     * @return Point[]
     */
    public function getPoints(): array;
}
