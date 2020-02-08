<?php

declare(strict_types=1);

namespace Phpgeo;

use InvalidArgumentException;
use Phpgeo\Distance\Vincenty;
use Phpgeo\Formatter\Point\DecimalDegrees;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    /**
     * @var Ellipsoid
     */
    protected $ellipsoid;

    /**
     * @var Point
     *
     */
    protected $point;

    protected function setUp(): void
    {
        $ellipsoidConfig = [
            'name' => 'WGS-84',
            'a' => 6378137.0,
            'f' => 298.257223563,
        ];

        $this->ellipsoid = Ellipsoid::createFromArray($ellipsoidConfig);

        $this->point = new Point(52.5, 13.5, $this->ellipsoid);
    }

    public function testConstructorInvalidLatitudeOutOfBoundsWorksAsExpected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Latitude value must be numeric -90.0 .. +90.0 (given: 91)');

        $c = new Point(91.0, 13.5, $this->ellipsoid);
    }

    public function testConstructorInvalidLongitudeOutOfBoundsWorksAsExpected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Longitude value must be numeric -180.0 .. +180.0 (given: 190)');

        $c = new Point(52.2, 190.0, $this->ellipsoid);
    }

    public function testConstructorDefaultEllipsoid(): void
    {
        $c = new Point(52.5, 13.5);

        $this->assertInstanceOf(Ellipsoid::class, $c->getEllipsoid());
    }

    public function testGetLat(): void
    {
        $this->assertEquals(52.5, $this->point->getLat());
    }

    public function testGetLng(): void
    {
        $this->assertEquals(13.5, $this->point->getLng());
    }

    public function testGetEllipsoid(): void
    {
        $this->assertEquals($this->ellipsoid, $this->point->getEllipsoid());
    }

    public function testGetdistance(): void
    {
        $point1 = new Point(19.820664, -155.468066, $this->ellipsoid);
        $point2 = new Point(20.709722, -156.253333, $this->ellipsoid);

        $this->assertEquals(128130.850, $point1->getDistance($point2, new Vincenty()));
    }

    public function testFormat(): void
    {
        $this->assertEquals('52.50000 13.50000', $this->point->format(new DecimalDegrees()));
    }

    public function testHasSameLocation(): void
    {
        $point1 = new Point(0.0, 0.0);
        $point2 = new Point(0.0, 0.0);

        self::assertTrue($point1->hasSameLocation($point1, 0.0));
        self::assertTrue($point1->hasSameLocation($point1, 0.1));

        self::assertTrue($point1->hasSameLocation($point2, 0.0));
        self::assertTrue($point1->hasSameLocation($point2, 0.1));

        self::assertTrue($point2->hasSameLocation($point1, 0.0));
        self::assertTrue($point2->hasSameLocation($point1, 0.1));

        // distance: 1 arc second
        $point2 = new Point(0, 0.0002777778);

        self::assertFalse($point1->hasSameLocation($point2, 0.0));

        // a longitude difference of 1 arc second is about ~30.9 meters on the equator line
        self::assertFalse($point1->hasSameLocation($point2, 30.85));
        self::assertTrue($point1->hasSameLocation($point2, 30.95));
    }
}
