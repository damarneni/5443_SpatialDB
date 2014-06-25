### Assignment 7
### TO join two queries with CONTAINS OR WITHIN
### Dinesh Amarneni

Query1 (Gives California state Geometry)

```
SELECT SHAPE as Poly 
FROM `state_borders` 
WHERE state = 'California'
```

Query2 (Gives all earth quakes Geometry)

```
SELECT SHAPE AS POINT
FROM  `earth_quakes` 
```

And My Answer is (Gives Earth quakes geometry which are in California using CONTAINS function)

```
SELECT EQ.SHAPE AS POINT
FROM `earth_quakes` AS EQ, `state_borders` AS SB
WHERE CONTAINS (SB.SHAPE, EQ.SHAPE)  AND state = 'California'
```