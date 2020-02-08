<?php

declare(strict_types=1);

namespace Phpgeo\Factory;

use InvalidArgumentException;
use Phpgeo\Bearing\BearingEllipsoidal;
use Phpgeo\Bearing\BearingSpherical;
use Phpgeo\Bounds;
use Phpgeo\Point;
use PHPUnit\Framework\TestCase;

class BoundsFactoryTest extends TestCase
{
    public function testIfExpandFromCenterPointWorksAsExpected()
    {
        $startCenter = new Point(52, 13);
        $this->assertEquals(
            new Bounds(
                new Point(52.00063591099075, 12.998967101997957),
                new Point(51.999364079975535, 13.001032898002041)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, 100, new BearingSpherical())
        );
        $this->assertEquals(
            new Bounds(
                new Point(52.00063549793861, 12.998970388437384),
                new Point(51.99936449299343, 13.001029582403508)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, 100, new BearingEllipsoidal())
        );

        $startCenter = new Point(-52, -13);
        $this->assertEquals(
            new Bounds(
                new Point(-51.999364079975535, -13.001032898002041),
                new Point(-52.00063591099075, -12.998967101997957)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, 100, new BearingSpherical())
        );
        $this->assertEquals(
            new Bounds(
                new Point(-51.99936449299343, -13.001029582403508),
                new Point(-52.00063549793861, -12.998970388437384)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, 100, new BearingEllipsoidal())
        );
    }

    public function testIfExpandFromCenterPointWorksWithNegativeDistance()
    {
        $startCenter = new Point(52, 13);
        $this->assertEquals(
            new Bounds(
                new Point(51.999364079975535, 13.001032898002041),
                new Point(52.00063591099075, 12.998967101997957)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, -100, new BearingSpherical())
        );
        $this->assertEquals(
            new Bounds(
                new Point(51.99936449299343, 13.001029582403508),
                new Point(52.00063549793861, 12.998970388437384)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, -100, new BearingEllipsoidal())
        );
    }

    public function testIfExpandFromCenterPointThrowsExceptionOn180meridianWithBearingSpherical()
    {
        $this->expectException(InvalidArgumentException::class);

        $startCenter = new Point(52, 179.999);
        $this->assertEquals(
            new Bounds(
                new Point(52.00063591099075, 12.998967101997957),
                new Point(51.999364079975535, 13.001032898002041)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, 1000, new BearingSpherical())
        );
    }

    public function testIfExpandFromCenterPointWorksOn180meridianWithBearingEllipsoidal()
    {
        $startCenter = new Point(52, 179.999);
        $this->assertEquals(
            new Bounds(
                new Point(52.00635457125255, 179.98870257203671),
                new Point(51.993644521951445, -179.99070548794623)
            ),
            BoundsFactory::expandFromCenterPoint($startCenter, 1000, new BearingEllipsoidal())
        );
    }
}
