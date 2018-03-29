<?php
include "server.php";

$a_lat = '38.898047';
$a_lon = '-77.036562';
$a_dist = '110';

if (!empty($_POST)) {
    $a_lat = $_POST['a_lat'];
    $a_lon = $_POST['a_lon'];
    $a_dist = $_POST['a_dist'];
    
    $data = RadiusSearch::getPlantDataWithinRedius($a_lat, $a_lon, $a_dist);

}
?>
<!DOCTYPE>

<html>
    <head>

        <title>Radius search with google maps and mysql</title>
    </head>
    <body>
        <div style="margin:auto;  width: 600px; ">
            <h2>Radius search with google maps and mysql</h2>
            <form action="index.php" method="POST" id="map-form">

                your latitude :<input name="a_lat" value="<?php echo $a_lat; ?>"> <br>
                your longitude : <input name="a_lon" value="<?php echo $a_lon; ?>" /> <br>
                Search with in the radius : <input name="a_dist" value="<?php echo $a_dist; ?>"> km <br><br>

                <input type="submit" value="Search"/>

                <input type="button" value="Reset" id="reset"/>
            </form>

        </div>

    </body>
</html>
