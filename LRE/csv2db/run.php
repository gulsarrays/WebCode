<?php
include "vendor/autoload.php";
include "config/database.php";

use App\Models as Models;
   
if( !isset( $argv[1] ) ){
    echo "Expecting CSV File\n";
    echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
    exit;
}


$rows = array_map('str_getcsv', file( $argv[1] ));
//array str_getcsv ( string $input [, string $delimiter = "," [, string $enclosure = '"' [, string $escape = "\\" ]]] )
        
$header = array_shift($rows);
$csv = array();


foreach ($rows as $row) {
    if(count($row) != count($header)) {        
        continue;
    }
    $csv[] = array_combine($header, $row);
}

foreach($csv as $row) {
        if(!is_array($row)) {
           continue; 
        }
	$region = mysql_escape_string(trim($row["REGIONNAME"]));
	$serviceId = mysql_escape_string(trim($row["SERVICEID"]));
	$serviceName = mysql_escape_string(trim($row["SERVICELONGNAME"]));
	$serviceType = mysql_escape_string(trim($row["SERVICETYPENAME"]));
	$supplierId = mysql_escape_string(trim($row["SUPPLIERID"]));
	$supplierName = mysql_escape_string(trim($row["SUPPLIERNAME"]));
	$mealName = mysql_escape_string(trim($row["MEALPLANNAME"]));
	$optionId = mysql_escape_string(trim($row["OPTIONID"]));
	$optionName = mysql_escape_string(trim($row["OPTIONNAME"]));
	$extraId = mysql_escape_string(trim($row["EXTRAID"]));
	$extraName = mysql_escape_string(trim($row["EXTRANAME"]));
	$occupancyId = mysql_escape_string(trim($row["OCCUPANCYTYPEID"]));
	$occupancyName = mysql_escape_string(trim($row["OCCUPANCYTYPENAME"]));
	$policyId = mysql_escape_string(trim($row["CHARGINGPOLICYID"]));
	$policyName = mysql_escape_string(trim($row["CHARGINGPOLICYNAME"]));
	$seasonId = mysql_escape_string(trim($row["SEASONTYPEID"]));
	$seasonName = mysql_escape_string(trim($row["SEASONTYPENAME"]));
	$seasonStart = mysql_escape_string(trim($row["SEASONSTARTDATE"]));
	$seasonEnd = mysql_escape_string(trim($row["SEASONENDDATE"]));
	$contractId = mysql_escape_string(trim($row["ORGANISATIONSUPPLIERCONTRACTID"]));
	$contractName = mysql_escape_string(trim($row["ORGANISATIONSUPPLIERCONTRACTNAME"]));
	$contractPeriodId = mysql_escape_string(trim($row["CONTRACTDURATIONID"]));
	$contractPeriodName = mysql_escape_string(trim($row["CONTRACTDURATIONNAME"]));
	$contractStart = mysql_escape_string(trim($row["CONTRACTDURATIONSTARTDATE"]));
	$contractEnd = mysql_escape_string(trim($row["CONTRACTDURATIONENDDATE"]));
	$currency = mysql_escape_string(trim($row["CURRENCYISOCODE"]));
        
	$is_default = mysql_escape_string(trim($row["IS_DEFAULT"]));
	//$is_default = '';
        
        if(empty($is_default)) {
            $is_default = 'NO';
        } else {
            $is_default = strtoupper($is_default); 
        }
	
        if (array_key_exists("WEEKDAYPRICES_EXISTS", $row)) {
            $weekdayPrice = mysql_escape_string(trim($row["WEEKDAYPRICES_EXISTS"]));
            $monday = mysql_escape_string(trim($row["PRICEDAYMONDAY"]));
            $tuesday = mysql_escape_string(trim($row["PRICEDAYTUESDAY"]));
            $wednesday = mysql_escape_string(trim($row["PRICEDAYWEDNESDAY"]));
            $thursday = mysql_escape_string(trim($row["PRICEDAYTHURSDAY"]));
            $friday = mysql_escape_string(trim($row["PRICEDAYFRIDAY"]));
            $saturday = mysql_escape_string(trim($row["PRICEDAYSATURDAY"]));
            $sunday = mysql_escape_string(trim($row["PRICEDAYSUNDAY"]));
        }

	$buyPrice = mysql_escape_string(trim($row["BUYPRICE"]));
	$margin = mysql_escape_string(trim($row["MARGIN"]));
        $sellPrice = mysql_escape_string(trim($row["SELLING"]));
        
    // Priceband details
    if (array_key_exists("PRICEBANDMIN", $row)) {
	    $minPriceBand = mysql_escape_string(trim($row["PRICEBANDMIN"]));
	    $maxPriceBand = mysql_escape_string(trim($row["PRICEBANDMAX"]));
	    $buyPrice = mysql_escape_string(trim($row["BUYPRICE"]));
	    $sellPrice = mysql_escape_string(trim($row["SELLING"]));
	}
        
        $buyPrice = round($buyPrice, 2);
        $sellPrice = round($sellPrice, 2);
    

	$optionStatus = ((isset($row["Option-status"]) && ($row["Option-status"] == "Unavailable")) ? 0 : 1);
    
    print_r($row);
    DB::beginTransaction(); //Start transaction!
    
    try {
        
        $serviceTypeObj = Models\ServiceType::firstOrCreate(array('name' => $serviceType));
        $currencyObj = Models\Currency::firstOrCreate(array('code' => $currency));
        $regionObj = Models\Region::firstOrCreate(array('name' => $region));
        $supplierObj = $regionObj->suppliers()->firstOrCreate(array('name' => $supplierName, 'ts_id' => $supplierId));
        
        if ($occupancyId) {
	   //$occupancyObj = Models\Occupancy::firstOrCreate(array('id' => $occupancyId, 'name' => $occupancyName)); /// This is master DB -  we should not populate it from csv 
	    $occupancyObj = Models\Occupancy::firstOrCreate(array('id' => $occupancyId));
        } else {
            $occupancyObj = Models\Occupancy::find(14);
        }
        
        $mealObj = null;
        if ($mealName) {
            $mealObj = Models\Meal::firstOrCreate(array('name' => $mealName));	
        }
        
        // Find or Create Service
        $serviceParams = array('ts_id' => $serviceId,
            'name' => trim($serviceName),
            'region_id' => $regionObj->id,
            //'currency_id' => $currencyObj->id,
            'service_type_id' => $serviceTypeObj->id,
            'supplier_id' => $supplierObj->id
        );
        $serviceObj = Models\Service::firstOrCreate( $serviceParams );
        
        // Find or Create Policies
        $policyObj = null;
        if ($policyId) {
            $policyParams = array('ts_id' => $policyId, 'name' => $policyName);
            $policyObj = Models\ChargingPolicy::where('ts_id', $policyId)->where('name', $policyName)->first();
            if (!$policyObj) {
                $roomBased = 0;
                $dayDuration = 1;
                if (preg_match("/room|unit/i", $policyName)) {
                    $roomBased = 1;
                }

                if( preg_match('!\d+!', $policyName, $matches)){
                    $dayDuration = $matches[0];
                }
                $policyArgs = array('room_based' => $roomBased, 'day_duration' => $dayDuration);
                $policyObj = Models\ChargingPolicy::create( array_merge($policyParams, $policyArgs));
            }
        }
        
        // Find or Create Price Bands
        $priceBandObj = null;
        if (isset($minPriceBand)) {
            $priceBandParams = array('min' => $minPriceBand, 'max' => $maxPriceBand);
            $priceBandObj = Models\PriceBand::firstOrCreate( $priceBandParams );
        }

        // Find or Create Contracts
        $contractObj = $serviceObj->contracts()->firstOrCreate(array('ts_id' => $contractId, 'name' => $contractName));
        $contractPeriodParams = array( 'ts_id' => $contractPeriodId, 'name' => $contractPeriodName, 'start' =>  date("Y/m/d", strtotime($contractStart)), 'end' => date("Y/m/d", strtotime($contractEnd)) );
        $contractPeriodObj = $contractObj->contractPeriods()->firstOrCreate( $contractPeriodParams );

        // Find or Create Season
        $seasonObj = $contractPeriodObj->seasons()->firstOrCreate(array('ts_id' => $seasonId, 'name' => $seasonName));
        $seasonPeriodParams = array( 'name' => '', 'start' =>  date("Y/m/d", strtotime($seasonStart)), 'end' => date("Y/m/d", strtotime($seasonEnd)) );
        $seasonPeriodObj = $seasonObj->seasonPeriods()->firstOrCreate( $seasonPeriodParams );

        // Find or Create Service Extras
        $extraObj = null;
        if ($extraId) {
                $extraParams = array('name' => $extraName, 'ts_id' => $extraId);
                $extraObj = $serviceObj->serviceExtras()->firstOrCreate( $extraParams );
        }

        // Find Or Create Service Option
        $optionObj = null;
        if ($optionId) {
                    $serviceOptionParams = array('occupancy_id' => $occupancyObj->id,
                'name' => $optionName,
                'ts_id' => $optionId,
                'service_extra_id' => (!empty($extraObj->id) ? $extraObj->id : NULL),
                'is_default' => $is_default,
                'status' => $optionStatus
                );
                $optionObj = $serviceObj->serviceOptions()->firstOrCreate( $serviceOptionParams );

            // Find or Create Meal Option
            if ($mealObj) {
                $optionObj->mealOptions()->firstOrCreate( ['meal_id' => $mealObj->id, 'season_period_id' => $seasonPeriodObj->id] );
            }
        }

        // Find or Create Prices 
        
        $season_period_start = date("Y/m/d", strtotime($seasonStart));
        $season_period_end =  date("Y/m/d", strtotime($seasonEnd));
            
        $meal_plan_id = '';
        if(!empty($mealObj->id)) {
           $meal_plan_id = $mealObj->id;
        }
        $priceParams = array('season_period_id' => $seasonPeriodObj->id, 'buy_price' => $buyPrice,
            'sell_price' => $sellPrice, 'margin' => $margin, 'service_id' => $serviceObj->id, 'currency_id' => $currencyObj->id, 'season_period_start' => $season_period_start, 'season_period_end' => $season_period_end,'meal_plan_id' => $meal_plan_id
            );

        $priceObj = null;
        if ($extraObj) {
            /*$priceObj = $extraObj->prices()->firstOrCreate( $priceParams );*/
            try {
                $priceObj = $extraObj->prices()->firstOrCreate( $priceParams );
            } catch (Exception $exc) {
                $priceObj = $extraObj->prices()->where('season_period_id', $seasonPeriodObj->id)->where('service_id', $serviceObj->id)->where('buy_price', round($buyPrice, 2))->where('sell_price', round($sellPrice, 2))->first();
            }

        } elseif ($optionObj) {
            /*$priceObj = $optionObj->prices()->firstOrCreate( $priceParams );*/
            try {
                $priceObj = $optionObj->prices()->firstOrCreate( $priceParams );
            } catch (Exception $exc) {
                $priceObj = $optionObj->prices()->where('season_period_id', $seasonPeriodObj->id)->where('service_id', $serviceObj->id)->where('buy_price', round($buyPrice, 2))->where('sell_price', round($sellPrice, 2))->first();

            }

        }

        // Find or Create Service Policies
        $servicePolicyObj = null;
        if ($policyObj) {
            $servicePolicyParams = array('charging_policy_id' => $policyObj->id);
            $servicePolicyObj = $priceObj->servicePolicy()->firstOrCreate( $servicePolicyParams );
        }

        // Find or Create Service Price Bands
        if ($priceBandObj && $servicePolicyObj) {
            $policyBandParams = array('price_band_id' => $priceBandObj->id);
            $servicePolicyObj->policyPriceBands()->firstOrCreate( $policyBandParams );
        }

        // Week Prices
        if(isset($weekdayPrice) && $weekdayPrice === 'YES') {
            $weekParams = array('monday' => $monday, 'tuesday' => $tuesday,
                    'wednesday' => $wednesday, 'thursday' => $thursday, 'friday' => $friday,
                    'saturday' =>  $saturday, 'sunday' => $sunday, 'status' => 1
                );
            $priceObj->weekPrices()->firstOrCreate( $weekParams );
        }
        
    } catch (Exception $err) {
        //failed logic here
        DB::rollback();
        throw $err;
    }
    DB::commit();
    echo "Service ".$serviceObj->id." / ".$serviceObj->name." has been created...\n";
}

//echo "Please Wait - Back end work is in process";

/*
//updateOptionsIsDefaultForAllOccupany();
//populateMarginTablePerServicePerSeason();
function updateOptionsIsDefaultForAllOccupany1() {
    $optionsWithIsDefaultYes = DB::table('service_options')->where('is_default', '=', 'YES')->get();
    foreach ($optionsWithIsDefaultYes as $optionWithIsDefaultYes) {
        
        $optionName = preg_replace('/\(Double\)/i','',$optionWithIsDefaultYes->name) ;
        $optionsWithAboveOptionName = DB::table('service_options')->where('name', 'like', "$optionName%")->get();
        foreach ($optionsWithAboveOptionName as $option) {
            if($option->is_default == 'NO') {
                DB::table('service_options')
                    ->where('id', $option->id)
                    ->update(['is_default' => 'YES','is_default_updated_outofCSV' => 1]);
                echo "Is defult option updated for ".$option->name." \n ";
            }            
        }
    }
}

function populateMarginTablePerServicePerSeason() {
    $serviceData = DB::table('services')
            -> join('service_options' ,'service_options.service_id', '=' , 'services.id')
            -> join('prices' ,'prices.priceable_id', '=' , 'service_options.id')
            -> join('season_periods' ,'season_periods.id', '=' , 'prices.season_period_id')
            -> where ('prices.priceable_type', 'like', '%ServiceOption')
            -> select('services.id as service_id', 'services.ts_id as service_tsid', 'services.currency_id as currency_id',  'service_options.id as option_id', 'service_options.ts_id as option_tsid', 'service_options.name as option_name', 'service_options.occupancy_id as occupancy_id',  'prices.id as price_id', 'prices.season_period_id as season_period_id', 'season_periods.name as season_period_name', 'prices.margin')
            -> orderBy('season_period_id','asc')
            -> orderBy('occupancy_id','asc')
            -> get();
    
    $count = 0;
    $prev_season_period_id = 0;
    $total_margin = 0;
    foreach($serviceData as $service) {
        
        if(($prev_season_period_id == $service->season_period_id) || ($prev_season_period_id == 0)) {
            $prev_season_period_id = $service->season_period_id;
            $total_margin += $service->margin;
            $count++;
        } else {            
            $avg_margin = $total_margin/($count);            
            $marginParams = array(
                'service_id' => $service->service_id,
                'season_period_id' => $prev_season_period_id,                
                'currency_id' => $service->currency_id,
                'margin' => $avg_margin
                    );
            
             $marginObj = Models\Margins::firstOrCreate($marginParams);

//            $marginObj = Models\Margins::firstOrCreate(array('service_id' => $prev_service_id, 'season_period_id' => $prev_season_period_id ));
//            
//            foreach ($marginParams as $key => $value) {
//                $marginObj->$key = $value;
//            }
//            $marginObj->save();
             
            $prev_season_period_id = $service->season_period_id;
            $count = 0;
            $total_margin = 0;
            echo "margin and currency updated for season period id " .$prev_season_period_id. " \n ";
        }   
    }
    
}
 
 updateOptionsIsDefaultForAllOccupany();

function updateOptionsIsDefaultForAllOccupany() {
    $optionsWithIsDefaultYes = DB::table('service_options')->where('is_default', '=', 'YES')->get();
    foreach ($optionsWithIsDefaultYes as $optionWithIsDefaultYes) {
        
        //$optionName = preg_replace('/\(Double\)/i','',$optionWithIsDefaultYes->name) ;
        $optionName = preg_replace('/\(Double\)|-Double/i','',$optionWithIsDefaultYes->name) ;
        //$optionName = preg_replace('/-Double/i','',$optionWithIsDefaultYes->name) ;
        $optionsWithAboveOptionName = DB::table('service_options')->where('name', 'like', "$optionName%")->get();
        
        foreach ($optionsWithAboveOptionName as $option) {            
            if($option->is_default == 'NO') {
                DB::table('service_options')
                    ->where('id', $option->id)
                    ->update(['is_default' => 'YES','is_default_updated_outofCSV' => 1]);
                
                echo "Is defult option updated for ".$option->name."<br><br> \n ";
            }            
        }
    }
}
exit;
  
*/
//echo "Success !!! We have Successfully imported the data from CSV";


?>