<?php // RAY_compute_distance.php
error_reporting(E_ALL);
echo "<pre>\n";

// COMPUTE THE DISTANCE BETWEEN TWO LAT/LON PAIRS

// MAN PAGE: http://en.wikipedia.org/wiki/Haversine_formula
function compute_distance($from_lat, $from_lon, $to_lat, $to_lon, $units='KM')
{
    $units = strtoupper(substr(trim($units),0,1));
    // ENSURE THAT ALL ARE FLOATING POINT VALUES
    $from_lat = floatval($from_lat);
    $from_lon = floatval($from_lon);
    $to_lat   = floatval($to_lat);
    $to_lon   = floatval($to_lon);

    // IF THE SAME POINT
    if ( ($from_lat == $to_lat) && ($from_lon == $to_lon) )
    {
        return 0.0;
    }

    // COMPUTE THE DISTANCE WITH THE HAVERSINE FORMULA
    $distance = acos( sin(deg2rad($from_lat))
              * sin(deg2rad($to_lat))
              + cos(deg2rad($from_lat))
              * cos(deg2rad($to_lat))
              * cos(deg2rad($from_lon - $to_lon)) );

    $distance = rad2deg($distance);

    // DISTANCE IN MILES AND KM - ADD OTHERS IF NEEDED
    $miles = (float) $distance * 69.0;
    $km    = (float) $miles * 1.61;

    // RETURN MILES
    if ($units == 'M') return round($miles,1);

    // RETURN KILOMETERS = MILES * 1.61
    if ($units == 'K') return round($km,2);
}

if (!empty($_GET))
{
    $distance = compute_distance($_GET["a_lat"], $_GET["a_lon"], $_GET["b_lat"], $_GET["b_lon"], $_GET["units"]);
    echo $distance . ' ' . $_GET["units"];
}
?>


<a target="_blank" href="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=camp+david+geolocation&sll=39.648333,-77.465&sspn=0.025972,0.057807&ie=UTF8&z=15&iwloc=lyrftr:m,10141899780758213082,39.648361,-77.465029">Camp David</a>
<a target="_blanl" href="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=White+House+Washington,+DC&sll=39.806296,-77.097044&sspn=0.414606,0.924911&ie=UTF8&hq=White+House&hnear=White+House,+Washington,+DC&ll=38.898047,-77.036562&spn=0.025417,0.057807&z=15&iwloc=A">White House</a>
TEST IT HERE:
<form>
POINT A LAT <input name="a_lat" value="38.898047"> LON <input name="a_lon" value="-77.036562" />
POINT B LAT <input name="b_lat" value="39.737554"> LON <input name="b_lon" value="-77.464943" />
<input type="radio" name="units" value="miles" checked="checked" />Miles
<input type="radio" name="units" value="km" />Kilometers
<input type="submit" />
</form>

