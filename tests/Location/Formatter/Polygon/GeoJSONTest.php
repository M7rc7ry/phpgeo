<?php

declare(strict_types=1);

namespace Phpgeo\Formatter\Polygon;

use Phpgeo\Point;
use Phpgeo\Exception\InvalidPolygonException;
use Phpgeo\Polygon;
use PHPUnit\Framework\TestCase;

class GeoJSONTest extends TestCase
{
    /**
     * @var GeoJSON
     */
    protected $formatter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->formatter = new GeoJSON();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        unset($this->formatter);
    }

    public function testFormatDefault(): void
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Point(10, 20));
        $polygon->addPoint(new Point(20, 40));
        $polygon->addPoint(new Point(30, 40));
        $polygon->addPoint(new Point(30, 20));

        $json = '{ "type" : "Polygon" , "coordinates" : [ [ [ 20, 10 ], [ 40, 20 ], [ 40, 30 ], [ 20, 30] ] ] }';

        $this->assertJsonStringEqualsJsonString($json, $this->formatter->format($polygon));
    }

    public function testPolygonGeoJSONWithLessThanThreePointsThrowsInvalidPolygonException(): void
    {
        $this->expectException(InvalidPolygonException::class);

        $polygon = new Polygon();
        $polygon->addPoint(new Point(0, 0));
        $polygon->addPoint(new Point(10, 10));

        $this->formatter->format($polygon);
    }
}
