<?php

declare(strict_types=1);

namespace Phpgeo;

use Phpgeo\Processor\Polyline\SimplifyDouglasPeucker;
use PHPUnit\Framework\TestCase;

class SimplifyDouglasPeuckerTest extends TestCase
{
    public function testSimplifyThreePointsToTwoPoints(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Point(10.0, 10.0));
        $polyline->addPoint(new Point(20.0, 20.0));
        $polyline->addPoint(new Point(30.0, 10.0));

        $processor = new SimplifyDouglasPeucker(1500000);

        // actual deviation is 1046 km, so 1500 km is enough of tolerance to strip the 2nd point
        $simplified = $processor->simplify($polyline);

        $segments = $simplified->getSegments();

        $this->assertCount(1, $segments);
        $this->assertEquals(new Line(new Point(10.0, 10.0), new Point(30.0, 10.0)), $segments[0]);
    }

    public function testSimplifyFourPointsToTwoPoints(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Point(50.0, 10.0));
        $polyline->addPoint(new Point(40.0, 20.0));
        $polyline->addPoint(new Point(30.0, 10.0));
        $polyline->addPoint(new Point(20.0, 30.0));

        $processor = new SimplifyDouglasPeucker(1500000);

        $simplified = $processor->simplify($polyline);

        $segments = $simplified->getSegments();

        $this->assertCount(1, $segments);
        $this->assertEquals(new Line(new Point(50.0, 10.0), new Point(20.0, 30.0)), $segments[0]);
    }

    public function testSimplifyFourPointsToThreePoints(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Point(50.0, 10.0));
        $polyline->addPoint(new Point(40.0, 20.0));
        $polyline->addPoint(new Point(30.0, 10.0));
        $polyline->addPoint(new Point(20.0, 30.0));

        $processor = new SimplifyDouglasPeucker(1200000);

        $simplified = $processor->simplify($polyline);

        $segments = $simplified->getSegments();

        $this->assertCount(2, $segments);
        $this->assertEquals(new Line(new Point(50.0, 10.0), new Point(30.0, 10.0)), $segments[0]);
        $this->assertEquals(new Line(new Point(30.0, 10.0), new Point(20.0, 30.0)), $segments[1]);
    }

    public function testSimplifyThreePointsImpossible(): void
    {
        $polyline = new Polyline();
        $polyline->addPoint(new Point(10.0, 10.0));
        $polyline->addPoint(new Point(20.0, 20.0));
        $polyline->addPoint(new Point(30.0, 10.0));

        $processor = new SimplifyDouglasPeucker(1000);

        $simplified = $processor->simplify($polyline);

        $this->assertEquals($polyline, $simplified);
    }
}
