# Distance and Length

[TOC]

## Distance Between Two Points (Vincenty's Formula)

Use the calculator object directly:

``` php
<?php

use Phpgeo\Point;
use Phpgeo\Distance\Vincenty;

$point1 = new Point(19.820664, -155.468066); // Mauna Kea Summit
$point2 = new Point(20.709722, -156.253333); // Haleakala Summit

$calculator = new Vincenty();

echo $calculator->getDistance($point1, $point2);
```

The code above will produce the output below:

``` plaintext
128130.850
```

or call the `getDistance()` method of a `Point` instance by injecting
a calculator instance:

``` php
<?php

use Phpgeo\Point;
use Phpgeo\Distance\Vincenty;

$point1 = new Point(19.820664, -155.468066); // Mauna Kea Summit
$point2 = new Point(20.709722, -156.253333); // Haleakala Summit

echo $point1->getDistance($point2, new Vincenty());
```

The code above will produce the output below:

``` plaintext
128130.850
```

## Distance Between Two Points (Haversine Formula)

There exist different methods for calculating the distance between
two points. The [Haversine formula](https://en.wikipedia.org/wiki/Haversine_formula#Law)
is much faster than Vincenty's method but less precise:

``` php
<?php

use Phpgeo\Point;
use Phpgeo\Distance\Haversine;

$point1 = new Point(19.820664, -155.468066); // Mauna Kea Summit
$point2 = new Point(20.709722, -156.253333); // Haleakala Summit

echo $point1->getDistance($point2, new Haversine());
```

The code above will produce the output below:

``` plaintext
128384.515
```

## Length of a Polyline

*phpgeo* has a polyline implementation which can be used to calculate the
length of a GPS track or a route. A polyline consists of at least two points.
Points are instances of the `Point` class.

For more details about polylines/GPS tracks see the [`Polyline`](../Geometries/Polyline) section.

``` php
<?php

use Phpgeo\Point;
use Phpgeo\Polyline;
use Phpgeo\Distance\Vincenty;

$track = new Polyline();
$track->addPoint(new Point(52.5, 13.5));
$track->addPoint(new Point(54.5, 12.5));

echo $track->getLength(new Vincenty());
```

## Perimeter of a Polygon

The perimeter is calculated as the sum of the length of all segments.
The result is given in meters.

``` php
<?php

use Phpgeo\Distance\Vincenty;
use Phpgeo\Point;
use Phpgeo\Polygon;

$polygon = new Polygon();
$polygon->addPoint(new Point(10, 10));
$polygon->addPoint(new Point(10, 20));
$polygon->addPoint(new Point(20, 20));
$polygon->addPoint(new Point(20, 10));

echo $polygon->getPerimeter(new Vincenty());
```

The code above will produce the output below:

``` plaintext
4355689.472
```
