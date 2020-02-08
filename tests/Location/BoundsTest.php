<?php

declare(strict_types=1);

namespace Phpgeo;

use Phpgeo\Point;
use Phpgeo\Bounds;
use PHPUnit\Framework\TestCase;

class BoundsTest extends TestCase
{
    /**
     * @var Bounds
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Bounds(
            new Point(50, 10),
            new Point(30, 30)
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        unset($this->object);
    }

    /**
     * @covers Phpgeo\Bounds::getNorthWest
     */
    public function testGetNortWest(): void
    {
        $c = new Point(50, 10);

        $this->assertEquals($c, $this->object->getNorthWest());
    }

    /**
     * @covers Phpgeo\Bounds::getSouthEast
     */
    public function testGetSouthEast(): void
    {
        $c = new Point(30, 30);

        $this->assertEquals($c, $this->object->getSouthEast());
    }

    /**
     * @covers Phpgeo\Bounds::getNorth
     */
    public function testGetNorth(): void
    {
        $this->assertEquals(50, $this->object->getNorth());
    }

    /**
     * @covers Phpgeo\Bounds::getSouth
     */
    public function testGetSouth(): void
    {
        $this->assertEquals(30, $this->object->getSouth());
    }

    /**
     * @covers Phpgeo\Bounds::getWest
     */
    public function testGetWest(): void
    {
        $this->assertEquals(10, $this->object->getWest());
    }

    /**
     * @covers Phpgeo\Bounds::getEast
     */
    public function testGetEast(): void
    {
        $this->assertEquals(30, $this->object->getEast());
    }

    /**
     * @covers Phpgeo\Bounds::getCenter
     */
    public function testGetCenter(): void
    {
        $testBounds = [
            ['nw' => new Point(50, 10), 'se' => new Point(30, 30), 'c' => new Point(40, 20)],
            ['nw' => new Point(50, - 130), 'se' => new Point(30, - 110), 'c' => new Point(40, - 120)],
            ['nw' => new Point(10, - 10), 'se' => new Point(- 10, 10), 'c' => new Point(0, 0)],
            [
                'nw' => new Point(- 80, - 130),
                'se' => new Point(- 90, - 110),
                'c'  => new Point(- 85, - 120)
            ],
            ['nw' => new Point(80, - 130), 'se' => new Point(90, - 110), 'c' => new Point(85, - 120)],
            ['nw' => new Point(80, 110), 'se' => new Point(90, 130), 'c' => new Point(85, 120)],
            ['nw' => new Point(50, 170), 'se' => new Point(30, - 160), 'c' => new Point(40, - 175)],
            ['nw' => new Point(- 50, 150), 'se' => new Point(- 70, - 170), 'c' => new Point(- 60, 170)],
        ];

        foreach ($testBounds as $bounds) {
            $b = new Bounds($bounds['nw'], $bounds['se']);

            $this->assertEquals($bounds['c'], $b->getCenter());
        }
    }
}
