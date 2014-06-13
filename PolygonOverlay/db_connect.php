<?php
    // Create connection
    $con=mysqli_connect("localhost","damarneni","damarneni","damarneni");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    unset($Coords);

    if(isset($_POST['Country'])){
        $id = $_POST['Country'];
        $result = $con->query("SELECT asText(SHAPE) as border
                               FROM `world_borders` 
                               WHERE CountryID = '{$id}'");

            $Result = $result->fetch_assoc();

            $Coords = sql_to_coordinates($Result['border']);
            //echo"<pre>";
            //print_r($Coords);
            //echo"</pre>";
    }
?>
