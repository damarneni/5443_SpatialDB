<?php
function sql_to_coordinates($blob)
    {
        $blob = str_replace("))", "", str_replace("POLYGON((", "", $blob));
        $coords = explode(",", $blob);
        $coordinates = array();
        foreach($coords as $coord)
        {
            $coord_split = explode(" ", $coord);
            $coordinates[]=array("lat"=>$coord_split[0], "lng"=>$coord_split[1]);
        }
        return $coordinates;
    }

    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }
?>