### GIS Terminology Overview
### Assignment 5
### Dinesh Amarneni

### File Extensions
```
1. shp:
The Esri shapefile, or simply a shapefile, is a popular geospatial vector data format for geographic information system software. It is developed and regulated by Esri as a (mostly) open specification for data interoperability among Esri and other GIS software products.

2. osm:
OpenStreetMap (OSM) is a collaborative project to create a free editable map of the world. Two major driving forces behind the establishment and growth of OSM have been restrictions on use or availability of map information across much of the world and the advent of inexpensive portable satellite navigation devices.

3. geojson:
GeoJSON is a format for encoding a variety of geographic data structures. A GeoJSON object may represent a geometry, a feature, or a collection of features. GeoJSON supports the following geometry types: Point, LineString, Polygon, MultiPoint, MultiLineString, MultiPolygon, and GeometryCollection.

4. gpx:
GPX (the GPS eXchange Format) is a light-weight XML data format for the interchange of GPS data (waypoints, routes, and tracks) between applications and web services on the Internet. This document describes the XML elements defined in GPX in detail and provides examples of their use.

5. kml:
Keyhole Markup Language (KML) is an XML notation for expressing geographic annotation and visualization within Internet-based, two-dimensional maps and three-dimensional Earth browsers. KML was developed for use with Google Earth, which was originally named Keyhole Earth Viewer.

6. nmea:
Your GPS receiver might output or record your tracks in NMEA format, this is a format that can easily be converted to GPX so you can upload it to our website. Even though GPX is preferred there are still several OpenStreetMap tools that support NMEA including new versions of JOSM.

7. csv:
CSV stands for Comma Separated Values. Files that contain the .csv file extension are comma delimited files that contain separated database fields. These database fields have been exported into a format that contains a single line for each database record. The record is then divided and each field of the record that has been exported into a single line is separated by a comma.

8. wkt:
Well-known text (WKT) is a text markup language for representing vector geometry objects on a map, spatial reference systems of spatial objects and transformations between spatial reference systems.
```

### Software
```
1. ArcGis:
Esri's ArcGIS is a geographic information system (GIS) for working with maps and geographic information. It is used for: creating and using maps; compiling geographic data; analyzing mapped information; sharing and discovering geographic information; using maps and geographic information in a range of applications; and managing geographic information in a database.

2. QGIS:
QGIS (previously known as "Quantum GIS") is a cross-platform free and open source desktop geographic information systems (GIS) application that provides data viewing, editing, and analysis capabilities. Similar to other software GIS systems QGIS allows users to create maps with many layers using different map projections. Typical for this kind of software the vector data is stored as either point, line, or polygon-feature.

3. GpsBabel:
GPSBabel is a cross-platform, free software to transfer routes, tracks, and waypoint data to and from consumer GPS units, and to convert between over a hundred types of GPS data formats. It has a command-line interface and a graphical interface for Windows, OS X, and Linux users. GPSBabel is part of many Linux distributions including Debian GNU/Linux and Fedora, and also part of the 'fink' system for getting Unix software on Mac OS X.

4. GDAL:
GDAL (Geospatial Data Abstraction Library) is a library for reading and writing raster geospatial data formats, and is released under the permissive X/MIT style free software license by the Open Source Geospatial Foundation. As a library, it presents a single abstract data model to the calling application for all supported formats. It may also be built with a variety of useful command-line utilities for data translation and processing.
```

### Definitions
```
1. Point: 
A Point is a geometry that represents a single location in coordinate space. On a city map, a Point object could represent a bus stop. X an Y cordinate values are Point property values. Point is defined as a zero-dimensional geometry. The boundary of a Point is the empty set.

2. Curve:
A Curve is a one-dimensional geometry, usually represented by a sequence of points. Particular subclasses of Curve define the type of interpolation between points. Curve is a noninstantiable class. A Curve has the coordinates of its points, is defined as a one-dimensional geometry, is simple if it does not pass through the same point twice, is closed if its start point is equal to its endpoint. The boundary of a closed Curve is empty. The boundary of a nonclosed Curve consists of its two endpoints.

3. LineString: 
A LineString is a Curve with linear interpolation between points. In a city map, LineString objects could represent streets. A LineString has coordinates of segments, defined by each consecutive pair of points, is a Line if it consists of exactly two points and is a LinearRing if it is both closed and simple.

4. MultiCurve:
A MultiCurve is a geometry collection composed of Curve elements. MultiCurve is a noninstantiable class. A MultiCurve is a one-dimensional geometry, is simple if and only if all of its elements are simple; the only intersections between any two elements occur at points that are on the boundaries of both elements and is closed if all of its elements are closed. A MultiCurve boundary is obtained by applying the “mod 2 union rule” (also known as the “odd-even rule”): A point is in the boundary of a MultiCurve if it is in the boundaries of an odd number of MultiCurve elements. The boundary of a closed MultiCurve is always empty.

5. MultiLineStrings:
A MultiLineString is a MultiCurve geometry collection composed of LineString elements. On a region map, a MultiLineString could represent a river system or a highway system.

6. Surface Polygons:
A Surface is a two-dimensional geometry. It is a noninstantiable class. Its only instantiable subclass is Polygon. A Surface is a two-dimensional geometry. It is a noninstantiable class. Its only instantiable subclass is Polygon. The OpenGIS specification defines a simple Surface as a geometry that consists of a single “patch” that is associated with a single exterior boundary and zero or more interior boundaries. The boundary of a simple Surface is the set of closed curves corresponding to its exterior and interior boundaries.
A Polygon is a planar Surface representing a multisided geometry. It is defined by a single exterior boundary and zero or more interior boundaries, where each interior boundary defines a hole in the Polygon. On a region map, Polygon objects could represent forests, districts, and so on.

7. MultiPolygons:
A MultiPolygon is a MultiSurface object composed of Polygon elements. On a region map, a MultiPolygon could represent a system of lakes. A MultiPolygon is a two-dimensional geometry. A MultiPolygon boundary is a set of closed curves (LineString values) corresponding to the boundaries of its Polygon elements. Each Curve in the boundary of the MultiPolygon is in the boundary of exactly one Polygon element. Every Curve in the boundary of an Polygon element is in the boundary of the MultiPolygon.
```

### Relationships
```
1. Touches:
Touches(g1,g2) returns 1 or 0 to indicate whether g1 spatially touches g2. Two geometries spatially touch if the interiors of the geometries do not intersect, but the boundary of one of the geometries intersects either the boundary or the interior of the other.

2. Crosses:
Crosses(g1,g2) returns 1 if g1 spatially crosses g2. Returns NULL if g1 is a Polygon or a MultiPolygon, or if g2 is a Point or a MultiPoint. Otherwise, returns 0. The term spatially crosses denotes a spatial relation between two given geometries that has the following properties: The two geometries intersect, Their intersection results in a geometry that has a dimension that is one less than the maximum dimension of the two given geometries and Their intersection is not equal to either of the two given geometries.

3. Within:
Within(g1,g2) returns 1 or 0 to indicate whether g1 is spatially within g2. Best example for this is intersection operation in maths.

4. Overlaps:
Overlaps(g1,g2) returns 1 or 0 to indicate whether g1 spatially overlaps g2. The term spatially overlaps is used if two geometries intersect and their intersection results in a geometry of the same dimension but not equal to either of the given geometries.
```