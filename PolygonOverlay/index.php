<?php 
	include 'db_connect.php';
	include 'functions.php';
	
	unset($Coords);
		if(isset($_POST['Countries'])){
        $id = $_POST['Countries'];
		//$size = sizeof($id);
		/* echo "<pre>";
		print_r($id);
		echo "</pre>"; */
		//$id = implode($id,",");
		$j = 0;
		foreach($id as $i){
		$result = $con->query("SELECT asText(SHAPE) as border
                               FROM `world_borders` 
                               WHERE CountryID = '{$i}'");
		
		print_r($result);
		echo "<br>";
		echo "<br>";
			$Result = $result->fetch_assoc();
			//print_r($Result);
            $Coords = sql_to_coordinates($Result['border']);
			print_r($Coords);
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			$j = $j +1;
			}
			}
?>

<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polygon</title>
    <style>
      #map-canvas {
        height: 90%;
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
	echo "initialize";
	//for($temp = 0; $temp < $j; $temp++){
		$center = $Coords[sizeof($Coords)/2];
		/* print_r($center[$temp]);
		echo "<br>";
		echo "<br>"; */
		//}
	?>
	center: new google.maps.LatLng(<?=$center['lat']?>,<?=$center['lng']?>),
    mapTypeId: google.maps.MapTypeId.TERRAIN
	}
  };

  var Polygons = new Array(); 
  
  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Define the LatLng coordinates for the polygon's path.
  var PolygonCoords[] = [
    <?php
    array_shift($Coords);
	//for($k = 0; $k < $j ;$k++){
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
	//}
    ?>
  ];
  for(i = 0;i < sizeof(PolygonCoords); i++){
  // Construct the polygon.
  Polygons[] = new google.maps.Polygon({
    paths: PolygonCoords[i],
    strokeColor: '#<?=random_color()?>',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#<?=random_color()?>',
    fillOpacity: 0.35
  });
  
  Polygons[].setMap(map);
  //} 
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