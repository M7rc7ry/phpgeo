<?php

declare(strict_types=1);

namespace Phpgeo\Distance;

use Phpgeo\Ellipsoid;
use Phpgeo\Point;
use Phpgeo\Exception\NotMatchingEllipsoidException;
use PHPUnit\Framework\TestCase;

class HaversineTest extends TestCase
{
    protected $calculator;
    protected $ellipsoid;

    protected function setUp(): void
    {
        $ellipsoidConfig = [
            'name' => 'WGS-84',
            'a'    => 6378137.0,
            'f'    => 298.257223563,
        ];

        $this->ellipsoid = Ellipsoid::createFromArray($ellipsoidConfig);

        $this->calculator = new Haversine();
    }

    public function testGetDistanceZero(): void
    {
        $point1 = new Point(52.5, 13.5, $this->ellipsoid);
        $point2 = new Point(52.5, 13.5, $this->ellipsoid);

        $distance = $this->calculator->getDistance($point1, $point2);

        $this->assertEquals(0.0, $distance);
    }

    public function testGetDistanceSameLatitude(): void
    {
        $point1 = new Point(52.5, 13.5, $this->ellipsoid);
        $point2 = new Point(52.5, 13.1, $this->ellipsoid);

        $distance = $this->calculator->getDistance($point1, $point2);

        $this->assertEquals(27076.476, $distance);
    }

    public function testGetDistanceSameLongitude(): void
    {
        $point1 = new Point(52.5, 13.5, $this->ellipsoid);
        $point2 = new Point(52.1, 13.5, $this->ellipsoid);

        $distance = $this->calculator->getDistance($point1, $point2);

        $this->assertEquals(44478.032, $distance);
    }

    public function testGetDistance(): void
    {
        $point1 = new Point(19.820664, - 155.468066, $this->ellipsoid);
        $point2 = new Point(20.709722, - 156.253333, $this->ellipsoid);

        $distance = $this->calculator->getDistance($point1, $point2);

        $this->assertEquals(128384.515, $distance);
    }

    public function testGetDistanceInternationalDateLine(): void
    {
        $point1 = new Point(20.0, 170.0, $this->ellipsoid);
        $point2 = new Point(- 20.0, - 170.0, $this->ellipsoid);

        $distance = $this->calculator->getDistance($point1, $point2);

        $this->assertEquals(4952349.639, $distance);
    }

    public function testNotMatchingEllispoids(): void
    {
        $this->expectException(NotMatchingEllipsoidException::class);

        $point1 = new Point(19.820664, - 155.468066, $this->ellipsoid);
        $point2 = new Point(20.709722, - 156.253333, new Ellipsoid('AnotherEllipsoid', 6378140.0, 299.2));

        $distance = $this->calculator->getDistance($point1, $point2);
    }
}
