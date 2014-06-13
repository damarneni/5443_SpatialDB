<?php 
	include 'db_connect.php';
	include 'functions.php';
	
	unset($Coords);
		if(isset($_POST['Countries'])){
        $id = $_POST['Countries'];
		$size = sizeof($id);
		/* echo "<pre>";
		print_r($id);
		echo "</pre>"; */
		$id = implode($id,",");
		$result = $con->query("SELECT asText(SHAPE) as border
                               FROM `world_borders` 
                               WHERE CountryID = '{$id}'");

            $Result = $result->fetch_assoc();

            $Coords = sql_to_coordinates($Result['border']);
			//print_r($Coords);
			}
?>

<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polygon</title>
    <style>
      #map-canvas {
        height: 600px;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
// This example creates a simple polygon representing the Bermuda Triangle.

function initialize() {
  var mapOptions = {
    zoom: 5,
    <?php
		$center = $Coords[sizeof($Coords)/2];
    ?>
    center: new google.maps.LatLng(<?=$center['lat']?>,<?=$center['lng']?>),
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };

  var Polygons = new array($size);
  
  <?php
  echo "$size";
  echo "<pre>";
  echo "sizeof(Polygons)";
  echo "</pre>";
  ?>

  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Define the LatLng coordinates for the polygon's path.
  var PolygonCoords = [
    <?php
    array_shift($Coords);
    if(isset($Coords)){
        foreach($Coords as $c){
            $lat = $c['lat'];
            $lng = $c['lng'];
            $lat = str_replace("(","",$lat);
            $lng = str_replace("(","",$lng);
            $lat = str_replace(")","",$lat);
            $lng = str_replace(")","",$lng);
            echo "new google.maps.LatLng({$lat},{$lng}),\n";
        }
    }
    ?>
  ];
for($i = 1;$i <= sizeof(Polygons); $i++){
  // Construct the polygon.
  Polygons[$i] = new google.maps.Polygon({
    paths: PolygonCoords,
    strokeColor: '#<?=random_color()?>',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#<?=random_color()?>',
    fillOpacity: 0.35
  });

  Polygons[$i].setMap(map);
  }
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div>
        <form action="index.php" method="POST">
            <?php
            $result = $con->query("SELECT CountryID,name 
                                   FROM `world_borders` 
                                   ORDER BY name");
            ?>
            <select name="Countries[]" multiple>                   
            <?php
            while($row = $result->fetch_assoc()){
                echo"<option value=\"{$row['CountryID']}\">{$row['name']}</option>";
            }
            ?>
            <input type="submit" name="submit" value="Get Country">
        </form>
    </div>
    <div id="map-canvas"></div>
  </body>
</html>