<?php

declare(strict_types=1);

namespace Phpgeo;

use Phpgeo\Distance\Vincenty;
use PHPUnit\Framework\TestCase;

class Issue18Test extends TestCase
{
    public function testIfIssue18IsFixed(): void
    {
        $vincenty = new Vincenty();

        $distance = $vincenty->getDistance(
            new Point(0, 0),
            new Point(0, 0.1)
        );

        $this->assertIsFloat($distance);
    }
}
