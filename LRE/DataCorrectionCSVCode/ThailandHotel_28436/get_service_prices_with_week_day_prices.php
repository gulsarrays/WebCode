<?php

//MSSQL connection string details.
$dbhost = "127.0.0.1:11443";
$dbuser = 'sa';
$dbpass = 'Enchant@123';
$dbname = 'TS_Live';
$db = mssql_connect($dbhost, $dbuser, $dbpass);
if (!$db) {
	die('Could not connect to mssql - check your connection details & make sure that ntwdblib.dll is the right version!');
}
$db_selected = mssql_select_db($dbname, $db);
if (!$db_selected) {
	die('Could not select mssql db');
}


$sql = "select distinct S.SERVICEID,S.SERVICELONGNAME,S.SERVICESHORTNAME 
from SERVICE S Inner join 
SERVICE_OPTION_IN_SERVICE SOIS on S.SERVICEID =SOIS.SERVICEID
inner join SERVICE_TYPE_OPTION STO on SOIS.SERVICETYPEOPTIONID = STO.SERVICETYPEOPTIONID
inner join Price P on P.SERVICEOPTIONINSERVICEID = SOIS.SERVICEOPTIONINSERVICEID 
inner join PRICE_BAND PB on PB.PRICEID = P.PRICEID
WHERE 
P.PRICEAMOUNTVALIDATED =1 
UNION 
select distinct S.SERVICEID,S.SERVICELONGNAME,SERVICESHORTNAME
from SERVICE S Inner join 
SERVICE_EXTRA SE on S.SERVICEID =SE.SERVICEID
inner join SERVICE_TYPE_EXTRA STE on SE.SERVICETYPEEXTRAID = STE.SERVICETYPEEXTRAID
inner join Price P on P.SERVICEEXTRAID = SE.SERVICEEXTRAID 
inner join PRICE_BAND PB on PB.PRICEID = P.PRICEID
inner join ORGANISATION_SUPPLIER_CONTRACT OSC on P.ORGANISATIONSUPPLIERCONTRACTID = OSC.ORGANISATIONSUPPLIERCONTRACTID
inner join CONTRACT_DURATION CD on CD.CONTRACTDURATIONID = OSC.CONTRACTDURATIONID
inner join CONTRACT_SEASON_TYPE CST on CD.CONTRACTDURATIONID = CST.CONTRACTDURATIONID
inner join SEASON_TYPE ST ON ST.SEASONTYPEID = CST.SEASONTYPEID
where 
P.PRICEAMOUNTVALIDATED =1" ;
$results = mssql_query($sql, $db);

//Generate CSV file - Set as MSSQL_ASSOC as you don't need the numeric values.
while ($l = mssql_fetch_array($results, MSSQL_ASSOC)) {
    $priceBandServiceIdArr[] = $l['SERVICEID'];
}

//print('<xmp>');
//print_r($priceBandServiceIdArr);
//print('</xmp>');
    
mssql_free_result($results);
mssql_close($db);

//die('533333333333');


$serviceIds = '28436';
//$contarctDurationStartDate = "2014-01-01";
$contarctDurationEndDate = "2015-01-01";//"2013-31-12";

//MSSQL connection string details.
$dbhost = "127.0.0.1:11443";
$dbuser = 'sa';
$dbpass = 'Enchant@123';
$dbname = 'TS_Live';
$db = mssql_connect($dbhost, $dbuser, $dbpass);
if (!$db) {
	die('Could not connect to mssql - check your connection details & make sure that ntwdblib.dll is the right version!');
}
$db_selected = mssql_select_db($dbname, $db);
if (!$db_selected) {
	die('Could not select mssql db');
}

//'REGIONNAME','SERVICEID','SERVICELONGNAME','SERVICETYPENAME','SUPPLIERID','SUPPLIERNAME','MEALPLANNAME','OPTIONID','OPTIONNAME','EXTRAID','EXTRANAME','OCCUPANCYTYPEID','OCCUPANCYTYPENAME','CHARGINGPOLICYID','CHARGINGPOLICYNAME','SEASONTYPEID','SEASONTYPENAME','SEASONSTARTDATE','SEASONENDDATE','ORGANISATIONSUPPLIERCONTRACTID','ORGANISATIONSUPPLIERCONTRACTNAME','CONTRACTDURATIONID','CONTRACTDURATIONNAME','CONTRACTDURATIONSTARTDATE','CONTRACTDURATIONENDDATE','CURRENCYISOCODE','WEEKDAYPRICES_EXISTS','PRICEDAYMONDAY','PRICEDAYTUESDAY','PRICEDAYWEDNESDAY','PRICEDAYTHURSDAY','PRICEDAYFRIDAY','PRICEDAYSATURDAY','PRICEDAYSUNDAY','BUYPRICE','MARGIN','SELLING'

$sql = "select r.REGIONNAME ,s.SERVICEID ,s.SERVICELONGNAME, st1.SERVICETYPENAME,su.SUPPLIERID ,su.SUPPLIERNAME,MP.MEALPLANNAME ,SOIS.SERVICEOPTIONINSERVICEID AS OPTIONID,
sto.SERVICETYPEOPTIONNAME AS OPTIONNAME , (CASE WHEN SOIS.IsDefaultOption =1 THEN 'YES' ELSE 'NO'END) AS IS_DEFAULT, NULL AS EXTRAID,NULL AS EXTRANAME ,
OT.OCCUPANCYTYPEID,OT.OCCUPANCYTYPENAME,
CP.CHARGINGPOLICYID
	,cp.CHARGINGPOLICYNAME,
	ST.SEASONTYPEID,ST.SEASONTYPENAME,DT.DATERANGESTARTDATE AS SEASONSTARTDATE,
  DT.DATERANGEENDDATE AS SEASONENDDATE,
  OSC.ORGANISATIONSUPPLIERCONTRACTID  AS ORGANISATIONSUPPLIERCONTRACTID,
  ORGANISATIONSUPPLIERCONTRACTNAME AS ORGANISATIONSUPPLIERCONTRACTNAME,
  CD.CONTRACTDURATIONID,
  CD.CONTRACTNAME AS CONTRACTDURATIONNAME ,cd.CONTRACTDURATIONSTARTDATE,
	CD.CONTRACTDURATIONENDDATE,
           c.CURRENCYISOCODE,
		   (CASE WHEN P.PRICEDAYMONDAY =1 and P.PRICEDAYTUESDAY =1 and P.PRICEDAYWEDNESDAY =1 AND P.PRICEDAYTHURSDAY =1 and P.PRICEDAYSATURDAY =1 and P.PRICEDAYSUNDAY =1 THEN 'NO' ELSE 'YES'END) AS WEEKDAYPRICES_EXISTS,
           P.PRICEDAYMONDAY,
           P.PRICEDAYTUESDAY,
           P.PRICEDAYWEDNESDAY,
           P.PRICEDAYTHURSDAY,
           P.PRICEDAYFRIDAY,
           P.PRICEDAYSATURDAY,
           P.PRICEDAYSUNDAY,
		   (Select PRICEAMOUNT from PRICE where priceid=p.buying_priceid) AS BUYPRICE,
		  (( (p.PRICEAMOUNT -  (Select PRICEAMOUNT from PRICE where priceid=p.buying_priceid))*100)/p.PRICEAMOUNT) AS MARGIN,
		   p.PRICEAMOUNT AS SELLING 
	from price p inner join service_option_in_service sois ON SOIS.SERVICEOPTIONINSERVICEID = P.SERVICEOPTIONINSERVICEID
	inner join service_type_option sto on STO.SERVICETYPEOPTIONID = SOIS.SERVICETYPEOPTIONID
	inner join season_type ST on ST.SEASONTYPEID=p.SEASONTYPEID
	inner join DATERANGE DT on DT.SEASONTYPEID = ST.SEASONTYPEID and dt.CONTRACTDURATIONID = p.CONTRACTDURATIONID  
	inner join assigned_charging_policy acp on acp.serviceOptioninserviceid =SOIS.SERVICEOPTIONINSERVICEID
	inner join CHARGING_POLICY cp on cp.CHARGINGPOLICYID=acp.CHARGINGPOLICYID 
	inner join contract_duration CD on CD.CONTRACTDURATIONID=p.CONTRACTDURATIONID
	inner join ORGANISATION_SUPPLIER_CONTRACT OSC ON OSC.CONTRACTDURATIONID = CD.CONTRACTDURATIONID 
	inner join currency c on c.CURRENCYID =p.CURRENCYID 
	inner join service s on sois.SERVICEID =s.serviceid
	inner join supplier su on su.supplierid=s.supplierid
	 inner join service_type st1 on st1.servicetypeid=s.servicetypeid
	LEFT JOIN ASSIGNED_REGION AS1 ON S.SERVICEID = AS1.SERVICEID
    left join region r on r.regionid=AS1.REGIONID
	 left join ASSIGNED_OCCUPANCY ao on ao.ServiceTypeOptionID=STO.SERVICETYPEOPTIONID
	 left join occupancy_type ot on ot.occupancytypeid=ao.occupancytypeid
	left join meal_plan mp on mp.MEALPLANID = p.MEALPLANID 
	where s.serviceid IN (".$serviceIds.")  and p.pricebuying=0 AND DT.CONTRACTDURATIONID = CD.CONTRACTDURATIONID
	AND OSC.SUPPLIERID =s.SUPPLIERID AND p.PRICEAMOUNTVALIDATED=1 AND CD.CONTRACTDURATIONENDDATE>='".$contarctDurationEndDate."'

	UNION
	SELECT r.REGIONNAME, s.SERVICEID,s.SERVICELONGNAME , st1.SERVICETYPENAME,su.SUPPLIERID ,su.SUPPLIERNAME,MP.MEALPLANNAME ,NULL AS OPTIONID,NULL AS OPTIONNAME  , NULL AS IS_DEFAULT,
	se.SERVICEEXTRAID,ste.SERVICETYPEEXTRANAME AS EXTRANAME ,
	OT.OCCUPANCYTYPEID, OT.OCCUPANCYTYPENAME
	,CP.CHARGINGPOLICYID
	,cp.CHARGINGPOLICYNAME,
	ST.SEASONTYPEID, ST.SEASONTYPENAME,
	DT.DATERANGESTARTDATE AS SEASONSTARTDATE,
  DT.DATERANGEENDDATE AS SEASONENDDATE,
   OSC.ORGANISATIONSUPPLIERCONTRACTID  AS ORGANISATIONSUPPLIERCONTRACTID,
  ORGANISATIONSUPPLIERCONTRACTNAME AS ORGANISATIONSUPPLIERCONTRACTNAME,
 CD.CONTRACTDURATIONID,
  CD.CONTRACTNAME AS CONTRACTDURATIONNAME,cd.CONTRACTDURATIONSTARTDATE,
	CD.CONTRACTDURATIONENDDATE,
           c.CURRENCYISOCODE,
		   (CASE WHEN P.PRICEDAYMONDAY =1 and P.PRICEDAYTUESDAY =1 and P.PRICEDAYWEDNESDAY =1 AND P.PRICEDAYTHURSDAY =1 and P.PRICEDAYSATURDAY =1 and P.PRICEDAYSUNDAY =1 THEN 'NO' ELSE 'YES'END) AS WEEKDAYPRICES_EXISTS,
           P.PRICEDAYMONDAY,
           P.PRICEDAYTUESDAY,
           P.PRICEDAYWEDNESDAY,
           P.PRICEDAYTHURSDAY,
           P.PRICEDAYFRIDAY,
           P.PRICEDAYSATURDAY,
           P.PRICEDAYSUNDAY,
		   (Select PRICEAMOUNT from PRICE where priceid=p.buying_priceid) AS BUYPRICE,
		  (( (p.PRICEAMOUNT -  (Select PRICEAMOUNT from PRICE where priceid=p.buying_priceid))*100)/p.PRICEAMOUNT) AS MARGIN,
		   p.PRICEAMOUNT AS SELLING
	from price P  INNER JOIN SERVICE_EXTRA SE ON SE.SERVICEEXTRAID = P.SERVICEEXTRAID 
	inner join service_type_extra ste on STe.SERVICETYPEextraID = SE.SERVICETYPEextraID
	inner join season_type ST on ST.SEASONTYPEID=p.SEASONTYPEID
	inner join DATERANGE DT on DT.SEASONTYPEID = ST.SEASONTYPEID and dt.CONTRACTDURATIONID = p.CONTRACTDURATIONID 
	inner join assigned_charging_policy acp on acp.SERVICETYPEEXTRAID =se.SERVICETYPEEXTRAID
	inner join CHARGING_POLICY cp on cp.CHARGINGPOLICYID=acp.CHARGINGPOLICYID 
	inner join contract_duration CD on CD.CONTRACTDURATIONID=p.CONTRACTDURATIONID
	inner join ORGANISATION_SUPPLIER_CONTRACT OSC ON OSC.CONTRACTDURATIONID = CD.CONTRACTDURATIONID 
	inner join currency c on c.CURRENCYID =p.CURRENCYID 
	inner join service s on se.SERVICEID =s.serviceid
	inner join supplier su on su.supplierid=s.supplierid
	 inner join service_type st1 on st1.servicetypeid=s.servicetypeid
	 LEFT JOIN ASSIGNED_REGION AS1 ON S.SERVICEID = AS1.SERVICEID
     left join region r on r.regionid=AS1.REGIONID
	 left join ASSIGNED_OCCUPANCY ao on ao.SERVICETYPEEXTRAID=SE.SERVICETYPEEXTRAID
	 left join occupancy_type ot on ot.occupancytypeid=ao.occupancytypeid
	left join meal_plan mp on mp.MEALPLANID = p.MEALPLANID 
	where s.serviceid IN (".$serviceIds.")  and p.pricebuying=0 AND   DT.CONTRACTDURATIONID = CD.CONTRACTDURATIONID
	AND OSC.SUPPLIERID =s.SUPPLIERID AND  p.PRICEAMOUNTVALIDATED=1 AND CD.CONTRACTDURATIONENDDATE>='".$contarctDurationEndDate."'";
$results = mssql_query($sql, $db);
$out = '';

$csvHeaderArray = array('REGIONNAME','SERVICEID','SERVICELONGNAME','SERVICETYPENAME','SUPPLIERID','SUPPLIERNAME','MEALPLANNAME','OPTIONID','OPTIONNAME','IS_DEFAULT','EXTRAID','EXTRANAME','OCCUPANCYTYPEID','OCCUPANCYTYPENAME','CHARGINGPOLICYID','CHARGINGPOLICYNAME','SEASONTYPEID','SEASONTYPENAME','SEASONSTARTDATE','SEASONENDDATE','ORGANISATIONSUPPLIERCONTRACTID','ORGANISATIONSUPPLIERCONTRACTNAME','CONTRACTDURATIONID','CONTRACTDURATIONNAME','CONTRACTDURATIONSTARTDATE','CONTRACTDURATIONENDDATE','CURRENCYISOCODE','WEEKDAYPRICES_EXISTS','PRICEDAYMONDAY','PRICEDAYTUESDAY','PRICEDAYWEDNESDAY','PRICEDAYTHURSDAY','PRICEDAYFRIDAY','PRICEDAYSATURDAY','PRICEDAYSUNDAY','BUYPRICE','MARGIN','SELLING');
foreach($csvHeaderArray as $value) {
    $out .= '"'.$value.'",';
}
$out .= "\n";
//Generate CSV file - Set as MSSQL_ASSOC as you don't need the numeric values.
while ($l = mssql_fetch_array($results, MSSQL_ASSOC)) {
    
    if(in_array($l['SERVICEID'], $priceBandServiceIdArr) ) {
        continue;
    }        
    
    foreach($l AS $key => $value){
            //If the character " exists, then escape it, otherwise the csv file will be invalid.
            $pos = strpos($value, '"');
            if ($pos !== false) {
                    $value = str_replace('"', '\"', $value);
                    $value = str_replace(chr(10), '', $value);
                    $value = str_replace(chr(13), '', $value);
                    $value = trim($value);
            }
            $out .= '"'.trim($value).'",';
    }
    $out .= chr(10);
}
mssql_free_result($results);
mssql_close($db);
// Output to browser with the CSV mime type
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=service_price_with_weekday_28436_".date('jSFY').".csv");
echo $out;
?>