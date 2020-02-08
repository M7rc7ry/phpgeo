<?php

declare(strict_types=1);

namespace Phpgeo\Distance;

use Phpgeo\Ellipsoid;
use Phpgeo\Point;
use Phpgeo\Exception\NotMatchingEllipsoidException;
use PHPUnit\Framework\TestCase;

class VincentyTest extends TestCase
{
    protected $ellipsoid;

    protected function setUp(): void
    {
        $ellipsoidConfig = [
            'name' => 'WGS-84',
            'a'    => 6378137.0,
            'f'    => 298.257223563,
        ];

        $this->ellipsoid = Ellipsoid::createFromArray($ellipsoidConfig);
    }

    public function testGetDistanceZero(): void
    {
        $point1 = new Point(52.5, 13.5, $this->ellipsoid);
        $point2 = new Point(52.5, 13.5, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($point1, $point2);

        $this->assertEquals(0.0, $distance);
    }

    public function testGetDistanceSameLatitude(): void
    {
        $point1 = new Point(52.5, 13.5, $this->ellipsoid);
        $point2 = new Point(52.5, 13.1, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($point1, $point2);

        $this->assertEquals(27164.059, $distance);
    }

    public function testGetDistanceSameLongitude(): void
    {
        $point1 = new Point(52.5, 13.5, $this->ellipsoid);
        $point2 = new Point(52.1, 13.5, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($point1, $point2);

        $this->assertEquals(44509.218, $distance);
    }

    public function testGetDistance(): void
    {
        $point1 = new Point(19.820664, - 155.468066, $this->ellipsoid);
        $point2 = new Point(20.709722, - 156.253333, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($point1, $point2);

        $this->assertEquals(128130.850, $distance);
    }

    public function testGetDistanceInternationalDateLine(): void
    {
        $point1 = new Point(20.0, 170.0, $this->ellipsoid);
        $point2 = new Point(- 20.0, - 170.0, $this->ellipsoid);

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($point1, $point2);

        $this->assertEquals(4932842.135, $distance);
    }

    public function testNotMatchingEllispoids(): void
    {
        $this->expectException(NotMatchingEllipsoidException::class);

        $point1 = new Point(19.820664, - 155.468066, $this->ellipsoid);
        $point2 = new Point(20.709722, - 156.253333, new Ellipsoid('AnotherEllipsoid', 6378140.0, 299.2));

        $calculator = new Vincenty();
        $distance   = $calculator->getDistance($point1, $point2);
    }
}
