<?php
/*
 * Test data
 * 
 1) your latitude : 20.16545450
    your longitude : 85.4987654
    Search with in the radius : 0.5 km - to 1 km, then  1.095/1.096/1.097
 * 
 2) your latitude : 38.898047
    your longitude : -77.036562
    Search with in the radius : 45km to 110km

 */
class RadiusSearch {

    static $_dbHost = 'localhost';
    static $_dbName = 'DynamicGeoPolygon';
    static $_dbUserName = 'homestead';
    static $_dbUserPwd = 'secret';

    static public function getPlantDataWithinRedius($fLat, $fLon, $radius) {
        $con = mysqli_connect(self::$_dbHost, self::$_dbUserName, self::$_dbUserPwd);

        // connect to database
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }

        mysqli_select_db($con, self::$_dbName);

        // search by kilometers =  6371
        // search by miles =  3959
        
        // Search the rows in the markers table
        $qry = sprintf("SELECT id, plant_name, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM plant HAVING distance < '%s' ORDER BY distance ",
          mysqli_real_escape_string($con,$fLat),
          mysqli_real_escape_string($con,$fLon),
          mysqli_real_escape_string($con,$fLat),
          mysqli_real_escape_string($con,$radius));
        $result = mysqli_query($con, $qry) or die(mysqli_error($con));



        
//        $qry = "SELECT
//`id`,
//`plant_name`,
//ACOS( SIN( RADIANS( `lat` ) ) * SIN( RADIANS( $fLat ) ) + COS( RADIANS( `lat` ) )
//* COS( RADIANS( $fLat )) * COS( RADIANS( `lng` ) - RADIANS( $fLon )) ) * 6371 AS `distance`
//FROM `plant`
//WHERE
//ACOS( SIN( RADIANS( `lat` ) ) * SIN( RADIANS( $fLat ) ) + COS( RADIANS( `lat` ) )
//* COS( RADIANS( $fLat )) * COS( RADIANS( `lng` ) - RADIANS( $fLon )) ) * 6371 < $radius
//ORDER BY `distance` ";

        $result = mysqli_query($con, $qry) or die(mysqli_error($con));
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo "<h3> Plants availabe within the give radis are : </h3>";
            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                echo "<b>".++$i.". " . $row['plant_name'] . "</b> <br>";
            }
        } else {
            echo "<b>No Results</b>";
        }
        echo "<br><br><br>";

        // close connection
        mysqli_close($con);
    }

}

?>
