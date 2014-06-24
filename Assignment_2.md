##Grade

|    |Possible|Earned|Category     | Objective                                          | 
|:--:|:------:|:----:|:-----------:|----------------------------------------------------|
|![1]|    10  |   0   | OGR Command | Ogr command was present.                          |
|![1]|    40  |   0   | OGR Command | Ogr command was syntactically correct.            |
|    |        |      |             |                                                    |
|![1]|    10  |   0   | Table Structure | Table structure was present.                  |
|![1]|    40  |   0   | Table Structure | Table structure was correct.                  |
|    | Total  |      |             |                                                    |
|    |    100 |   **100**   | Table Structure | Table structure was present, and correct.     |



![1] = Correct <br>
![2] = Incorrect <br>
![3] = Partially Correct <br>

[1]: https://raw.githubusercontent.com/rugbyprof/5443-Spatial-Database/master/media/correct.png
[2]: https://raw.githubusercontent.com/rugbyprof/5443-Spatial-Database/master/media/incorrect.png
[3]: https://raw.githubusercontent.com/rugbyprof/5443-Spatial-Database/master/media/partial.png


### Assignment 2

### MY OGR command

```
ogr2ogr -f "MySQL" MySQL:"damarneni,host=localhost,user=damarneni,password=damarneni,port=3036" /tmp/TM_WORLD_BORDERS-0.3.shp -nln World_Borders -update -overwrite -lco engine=MYISAM
```

My Table Structure

```sql
CREATE TABLE IF NOT EXISTS `world_borders` (
  `OGR_FID` int(11) NOT NULL AUTO_INCREMENT,
  `SHAPE` geometry NOT NULL,
  `fips` varchar(2) DEFAULT NULL,
  `iso2` varchar(2) DEFAULT NULL,
  `iso3` varchar(3) DEFAULT NULL,
  `un` decimal(3,0) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `area` decimal(7,0) DEFAULT NULL,
  `pop2005` decimal(10,0) DEFAULT NULL,
  `region` decimal(3,0) DEFAULT NULL,
  `subregion` decimal(3,0) DEFAULT NULL,
  `lon` double(8,3) DEFAULT NULL,
  `lat` double(7,3) DEFAULT NULL,
  UNIQUE KEY `OGR_FID` (`OGR_FID`),
  SPATIAL KEY `SHAPE` (`SHAPE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=247 ;
```

```Table structure for table `geometry_columns`
CREATE TABLE IF NOT EXISTS `geometry_columns` (
  `F_TABLE_CATALOG` varchar(256) DEFAULT NULL,
  `F_TABLE_SCHEMA` varchar(256) DEFAULT NULL,
  `F_TABLE_NAME` varchar(256) NOT NULL,
  `F_GEOMETRY_COLUMN` varchar(256) NOT NULL,
  `COORD_DIMENSION` int(11) DEFAULT NULL,
  `SRID` int(11) DEFAULT NULL,
  `TYPE` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

``` Dumping data for table `geometry_columns`
INSERT INTO `geometry_columns` (`F_TABLE_CATALOG`, `F_TABLE_SCHEMA`, `F_TABLE_NAME`, `F_GEOMETRY_COLUMN`, `COORD_DIMENSION`, `SRID`, `TYPE`) VALUES
(NULL, NULL, 'world_borders', 'SHAPE', 2, 1, 'POLYGON');
```

```Table structure for table `spatial_ref_sys`
CREATE TABLE IF NOT EXISTS `spatial_ref_sys` (
  `SRID` int(11) NOT NULL,
  `AUTH_NAME` varchar(256) DEFAULT NULL,
  `AUTH_SRID` int(11) DEFAULT NULL,
  `SRTEXT` varchar(2048) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

```Dumping data for table `spatial_ref_sys`
INSERT INTO `spatial_ref_sys` (`SRID`, `AUTH_NAME`, `AUTH_SRID`, `SRTEXT`) VALUES
(1, NULL, NULL, 'GEOGCS["GCS_WGS_1984",DATUM["WGS_1984",SPHEROID["WGS_84",6378137.0,298.257223563]],PRIMEM["Greenwich",0.0],UNIT["Degree",0.0174532925199433]]');
```
