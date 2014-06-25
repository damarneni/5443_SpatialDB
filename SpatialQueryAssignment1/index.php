<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polygon</title>
    <style>
      html, body, #map-canvas {
        height: 600px;
		width: 800px;
        margin: 0px;
        padding: 0px
      }
    </style>
    <!-- Include Google Maps Api to generate maps -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    
    <!-- Include Jquery to help with simplifying javascript syntax  -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>

	var map;
	var markers = [];
	var polygons = [];

	//Runs when page is done loading
	function initialize() {
	  //Javascript object to help configure google map.
	  var mapOptions = {
		zoom: 4,
		center: new google.maps.LatLng(39.707, -101.503),
		mapTypeId: google.maps.MapTypeId.TERRAIN
	  };

	  //Create google map, place it in 'map-canvas' element, and use 'mapOptions' to 
	  //help configure it
	  map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

  	  //Add the "click" event listener to the map, so we can capture
  	  //lat lon from a google map click.
	  google.maps.event.addListener(map, "click", function(event) {
		var lat = event.latLng.lat();
		var lng = event.latLng.lng();

		$.post( "backend.php", { lat: lat, lng: lng })
		  .done(function( data ) {
			//console.log( "Data Loaded: " + data );
			deleteMarkers();
			data = JSON.parse(data);
			for(var i = 0; i < data.length; i++) {
    			var obj = data[i];
    			addMarker(obj);
    			addPolygon(obj);
    		}
		  });
	  });  
	}	
	
	function addPolygon(obj) {
		var PolyCoords = [];
		
		console.log("Multi: "+obj.Multi);
		
		if(obj.Multi == 1){
			for(j=0;j<obj.Poly.length;j++){
				var latlng = new google.maps.LatLng(obj.Poly[j][1],obj.Poly[j][0]);
				PolyCoords.push(latlng);
			}
		}else{
			console.log(typeof obj.Poly);
// 			for each (item in obj.Poly) {
// 				console.log(item);
// 			    for(i=0;j<item.length;i++){
// 				    var latlng = new google.maps.LatLng(obj.Poly[i][1],obj.Poly[i][0]);
// 				    PolyCoords.push(latlng);
// 				}
// 			}


		}
		
		var polygon = new google.maps.Polygon({
			paths: PolyCoords,
			title: obj.fullname,
			fillColor: obj.Color,
			fillOpacity: 0.2,
			strokeWeight: 2,
			strokeColor: obj.Color,
			map: map
		});
		
		polygons.push(polygon); //Add polygon to global array of polygons
	}
	
	function addMarker(obj) {
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(obj.latitude,obj.longitude),
			title: obj.fullname,
			map: map
		});
		markers.push(marker); //Add marker to global array of markers
	}

	//Sets the map on all markers (could change the map, or set to null to erase markers)
	function setAllMap(map) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(map);
			polygons[i].setMap(map);
		}
	}

	// Removes the markers from the map, but keeps them in the array.
	function clearMarkers() {
		setAllMap(null);
	}

	// Shows any markers currently in the array.
	function showMarkers() {
		setAllMap(map);
	}

	// Deletes all markers in the array by removing references to them.
	function deleteMarkers() {
		clearMarkers();
		markers = [];	//set global marker array to EMPTY
		polygons = [];
	}

	//Add a listener that runs "initialize" when page is done loading.
	google.maps.event.addDomListener(window, 'load', initialize);
	

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>
