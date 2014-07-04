<?php
/**
 * Title:   GeoJson (Requires https://github.com/phayes/geoPHP)
 * Notes:   Query a MySQL table or view and return the results in GeoJSON format, suitable for use in OpenLayers, Leaflet, etc.
 * Author:  Bryan R. McBride, GISP
 * Contact: bryanmcbride.com
 * GitHub:  https://github.com/bmcbride/PHP-Database-GeoJSON
 * Edited:  By Dinesh Amarneni AND Yaswanth Amaraneni.
 * Instructor: Dr. Griffin
 */

 //Every Query gives max 25000 rows. 
 // It was very slow so we kept LIMIT 25000
 
error_reporting(0);

//Establish connection to database.
$Conn = new PDO("pgsql:host=localhost;dbname=5443","5443","5443");

if(isset($argv[1]) && $argv[1]=='debug'){
	$_POST = unserialize(file_get_contents("array.out"));
	print_r($_POST);
}

$fp = fopen('array.out','w');
fwrite($fp,serialize($_POST));
fclose($fp);


$fp = fopen('error.log','w');
fwrite($fp,time()."\n");
$out = print_r($_POST,true);
fwrite($fp,$out);


if(isset($argv[1]) && $argv[1]=='debug' || $_GET['debug']){
	$_POST['lat1'] = 33.546;
	$_POST['lon1'] = -122.546;
	$_POST['earthQuakes'] = true;
	$debug = true;
}

//Based on Query Number Entered in Form it performs particular task
switch($_POST['QueryNum']){
case 1:	
	$Data = WITHIN_RECTANGLE($_POST);
	break;
case 2:
	$Data = CONTACT_RECTANGLE($_POST);
	break;
case 3:
	$Data = EXCLUDES_RECTANGLE($_POST);
	break;
case 4:
	$Data = WITHIN_SELECTED($_POST);
	break;
case 5:
	$Data = WITHIN_CIRCLE($_POST);
	break;
case 6:
	shipToRailStation($_POST);
	break;
}

//Data sends back to geo.js JSON object
echo json_encode($Data);

//name: EXCLUDES_RECTANGLE
//parameter: Array ($_POST)
//Gives all features that are within some range and not in Bounding Box
function EXCLUDES_RECTANGLE($post){
	global $fp;
	global $Conn;

	$Lat1 = $post['lat1'];
	$Lon1 = $post['lon1'];
	$Lat2 = $post['lat2'];
	$Lon2 = $post['lon2'];

	$Points = array();

	foreach($post['sources'] as $source){
		$sql = "
			SELECT ST_AsGeoJSON(wkb_geometry) AS wkb
			FROM {$source}
			WHERE ST_DWithin(ST_SetSRID(wkb_geometry,4269) , ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2},4269),5)
			AND NOT wkb_geometry IN (SELECT wkb_geometry
			FROM {$source} 
			WHERE wkb_geometry @ ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2}))
			LIMIT 25000
			";
		$result = $Conn->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$Points[] = $row['wkb'];
		}
	}
	fwrite($fp,print_r($Points,true));
	return $Points;
}

function shipToRailStation(){
	global $fp;
	global $Conn;

	$Points = array();
	$sql = "
		SELECT 

		";
}

//name: WITHIN_CIRCLE
//parameter: Array ($_POST)
//Gives all features that are within circle range
function WITHIN_CIRCLE($post){
	global $fp;
	global $Conn;


	$Lat1 = $post['lat1'];
	$Lon1 = $post['lon1'];
	$Lat2 = $post['lat2'];
	$Lon2 = $post['lon2'];

	$Points = array();

	foreach($post['sources'] as $source){
		$sql = "
			SELECT ST_AsGeoJSON(wkb_geometry) AS wkb
			FROM {$source}
			WHERE ST_DWithin(ST_SetSRID(wkb_geometry,4269) , ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2},4269),5)
			LIMIT 25000
			";
		$result = $Conn->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$Points[] = $row['wkb'];
		}
	}
	fwrite($fp,print_r($Points,true));
	//print_r($Points);
	return $Points;
}

//name: WITHIN_RECTANGLE
//parameter: Array ($_POST)
//Gives all features that are within BoundingBox
function WITHIN_RECTANGLE($post){
	global $fp;
	global $Conn;

	$Lat1 = $post['lat1'];
	$Lon1 = $post['lon1'];
	$Lat2 = $post['lat2'];
	$Lon2 = $post['lon2'];

	$Points = array();

	foreach($post['sources'] as $source){
		$sql = "
			SELECT ST_AsGeoJSON(wkb_geometry) AS wkb
			FROM {$source}
			WHERE wkb_geometry @ ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2})
			LIMIT 25000
			";
			$result = $Conn->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$Points[] = $row['wkb'];
		}
	}
	fwrite($fp,print_r($Points,true));
	return $Points;
}

//name: WITHIN_SELECTED
//parameter: Array ($_POST)
//Gives selected features that are within BoundingBox
function WITHIN_SELECTED($post){
	return WITHIN_RECTANGLE($post);
}

//name: CONTACT_RECTANGLE
//parameter: Array ($_POST)
//Gives all features that are in contact with BoundingBox
function CONTACT_RECTANGLE($post){
	global $fp;
	global $Conn;

	$Lat1 = $post['lat1'];
	$Lon1 = $post['lon1'];
	$Lat2 = $post['lat2'];
	$Lon2 = $post['lon2'];

	$Points = array();

	foreach($post['sources'] as $source){
		$sql = "
			SELECT ST_AsGeoJSON(wkb_geometry) AS wkb
			FROM {$source}
			WHERE ST_Intersects(ST_SetSRID(wkb_geometry,4269) , ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2},4269))
			LIMIT 25000
			";
			fwrite($fp,print_r($sql,true));
		$result = $Conn->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$Points[] = $row['wkb'];
		}
	}
	fwrite($fp,print_r($Points,true));
	return $Points;
}

fclose($fp);