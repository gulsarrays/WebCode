<?php

class RadiusSearch {

    static $_dbHost = 'localhost';
    static $_dbName = 'DynamicGeoPolygon';
    static $_dbUserName = 'homestead';
    static $_dbUserPwd = 'secret';

    static public function getPlantDataWithinRedius($fLat, $fLon, $dist) {
        $con = mysqli_connect(self::$_dbHost, self::$_dbUserName, self::$_dbUserPwd);

        // connect to database
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }

        mysqli_select_db($con, self::$_dbName);


        $qry = "SELECT
`id`,
`plant_name`,
ACOS( SIN( RADIANS( `lat` ) ) * SIN( RADIANS( $fLat ) ) + COS( RADIANS( `lat` ) )
* COS( RADIANS( $fLat )) * COS( RADIANS( `lng` ) - RADIANS( $fLon )) ) * 6380 AS `distance`
FROM `plant`
WHERE
ACOS( SIN( RADIANS( `lat` ) ) * SIN( RADIANS( $fLat ) ) + COS( RADIANS( `lat` ) )
* COS( RADIANS( $fLat )) * COS( RADIANS( `lng` ) - RADIANS( $fLon )) ) * 6380 < $dist
ORDER BY `distance` ";

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
