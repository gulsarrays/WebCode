<?php
class Csv2Db extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function UploadFromCsv()
    {        
        $this->getCsvDataInArray();
        foreach($this->csvDataArr as $row) {
            $region = $row["REGIONNAME"];
            $serviceId = $row["SERVICEID"];
            $serviceName = $row["SERVICELONGNAME"];
            $serviceType = $row["SERVICETYPENAME"];
            $supplierId = $row["SUPPLIERID"];
            $supplierName = $row["SUPPLIERNAME"];
            $mealName = $row["MEALPLANNAME"];
            $optionId = $row["OPTIONID"];
            $optionName = $row["OPTIONNAME"];
            $extraId = $row["EXTRAID"];
            $extraName = $row["EXTRANAME"];
            $occupancyId = $row["OCCUPANCYTYPEID"];
            $occupancyName = $row["OCCUPANCYTYPENAME"];
            $policyId = $row["CHARGINGPOLICYID"];
            $policyName = $row["CHARGINGPOLICYNAME"];
            $seasonId = $row["SEASONTYPEID"];
            $seasonName = $row["SEASONTYPENAME"];
            $seasonStart = $row["SEASONSTARTDATE"];
            $seasonEnd = $row["SEASONENDDATE"];
            $contractId = $row["ORGANISATIONSUPPLIERCONTRACTID"];
            $contractName = $row["ORGANISATIONSUPPLIERCONTRACTNAME"];
            $contractPeriodId = $row["CONTRACTDURATIONID"];
            $contractPeriodName = $row["CONTRACTDURATIONNAME"];
            $contractStart = $row["CONTRACTDURATIONSTARTDATE"];
            $contractEnd = $row["CONTRACTDURATIONENDDATE"];
            $currency = $row["CURRENCYISOCODE"];

            if (array_key_exists("WEEKDAYPRICES_EXISTS", $row)) {
                $weekdayPrice = $row["WEEKDAYPRICES_EXISTS"];
                $monday = $row["PRICEDAYMONDAY"];
                $tuesday = $row["PRICEDAYTUESDAY"];
                $wednesday = $row["PRICEDAYWEDNESDAY"];
                $thursday = $row["PRICEDAYTHURSDAY"];
                $friday = $row["PRICEDAYFRIDAY"];
                $saturday = $row["PRICEDAYSATURDAY"];
                $sunday = $row["PRICEDAYSUNDAY"];
            }

            $buyPrice = $row["BUYPRICE"];
            $margin = $row["MARGIN"];
            $sellPrice = $row["SELLING"];

            // Priceband details
            if (array_key_exists("PRICEBANDMIN", $row)) {
                    $minPriceBand = $row["PRICEBANDMIN"];
                    $maxPriceBand = $row["PRICEBANDMAX"];
                    $buyPrice = $row["BUYPRICEBANDAMOUNT"];
                    $sellPrice = $row["SELLINGPRICEBANDAMOUNT"];
            }

            $optionStatus = ((isset($row["Option-status"]) && ($row["Option-status"] == "Unavailable")) ? 0 : 1);
            
            
    
    print_r($row);
    echo "<br><br>";

            
            
            $this->insertMasterData($serviceType, $currency, $region, $supplierName, $supplierId, $occupancyId, $occupancyName, $mealName);
            $this->insertServiceData($serviceId, $serviceName);            
            $this->insertPolicyData($policyId, $policyName);
            if (isset($minPriceBand)) {
                $this->insertPriceBandData($minPriceBand, $maxPriceBand);
            }
            $this->insertContractData($contractId, $contractName, $contractPeriodId, $contractPeriodName, $contractStart, $contractEnd);
            $this->insertSeasonData($seasonId, $seasonName, $seasonStart, $seasonEnd);
            $this->insertExtraData($extraName, $extraId);
            $this->insertOptionData($optionName, $optionId, $optionStatus);
            $this->insertPriceData($buyPrice, $sellPrice);
            $this->insertServicePolicyData();
            $this->insertPolicyPriceBandData();
            
            // Week Prices
            if(isset($weekdayPrice)) {
                $this->insertWeekpricesData($monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
            }
            
        }
        return View::make('pages.csv2db');
    }
    private function getCsvDataInArray() {
        $argv[1] = "/home/gulmohar/Desktop/CSV/DNLD/Service_Prices_With_WEEKDAYPRICES.csv";
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }
        $this->csvDataArr = $csv;
    }
    
    private function insertMasterData($serviceType, $currency, $region, $supplierName, $supplierId, $occupancyId, $occupancyName, $mealName) {
        $this->serviceTypeObj =  App\Models\ServiceType::firstOrCreate(array('name' => $serviceType));
        $this->currencyObj = App\Models\Currency::firstOrCreate(array('code' => $currency));
        $this->regionObj = App\Models\Region::firstOrCreate(array('name' => $region));
       
        echo '$supplierName : '.$supplierName."<br>";
        echo '$supplierId : '.$supplierId."<br>";
        dd($this->regionObj->suppliers());
        
        $this->supplierObj = $this->regionObj->suppliers()->firstOrCreate(array('name' => $supplierName, 'ts_id' => $supplierId));
        if ($occupancyId) {
                $this->occupancyObj = App\Models\Occupancy::firstOrCreate(array('id' => $occupancyId, 'name' => $occupancyName));
        } else {
            $this->occupancyObj = App\Models\Occupancy::find(14);
        }

        $this->mealObj = null;
        if ($mealName) {
                $this->mealObj = App\Models\Meal::firstOrCreate(array('name' => $mealName));	
        } 
    }
    
    private function insertServiceData($serviceId, $serviceName) {            

            // Find or Create Service
            $serviceParams = array('ts_id' => $serviceId,
                'name' => trim($serviceName),
                'region_id' => $this->regionObj->id,
                'currency_id' => $this->currencyObj->id,
                'service_type_id' => $this->serviceTypeObj->id,
                'supplier_id' => $this->supplierObj->id
            );
            $this->serviceObj = App\Models\Service::firstOrCreate( $serviceParams );
        
    }
    
    private function insertPolicyData($policyId, $policyName) {

        // Find or Create Policies
        $this->policyObj = null;
        if ($policyId) {
            $policyParams = array('ts_id' => $policyId, 'name' => $policyName);
            $this->policyObj = App\Models\ChargingPolicy::where('ts_id', $policyId)->where('name', $policyName)->first();
            if (!$this->policyObj) {
                $roomBased = 0;
                $dayDuration = 1;
                if (preg_match("/room|unit/i", $policyName)) {
                    $roomBased = 1;
                }

                if( preg_match('!\d+!', $policyName, $matches)){
                    $dayDuration = $matches[0];
                }
                $policyArgs = array('room_based' => $roomBased, 'day_duration' => $dayDuration);
                $this->policyObj = App\Models\ChargingPolicy::create( array_merge($policyParams, $policyArgs));
            }
        }
    }
    
    private function insertPriceBandData($minPriceBand, $maxPriceBand) {
        // Find or Create Price Bands
        $this->priceBandObj = null;
        if (isset($minPriceBand)) {
            $priceBandParams = array('min' => $minPriceBand, 'max' => $maxPriceBand);
            $this->priceBandObj = App\Models\PriceBand::firstOrCreate( $priceBandParams );
        }
    }
    
    private function insertContractData($contractId, $contractName, $contractPeriodId, $contractPeriodName, $contractStart, $contractEnd) {
        // Find or Create Contracts
        $this->contractObj = $this->serviceObj->contracts()->firstOrCreate(array('ts_id' => $contractId, 'name' => $contractName));
        $contractPeriodParams = array( 'ts_id' => $contractPeriodId, 'name' => $contractPeriodName, 'start' =>  date("Y/m/d", strtotime($contractStart)), 'end' => date("Y/m/d", strtotime($contractEnd)) );
        $this->contractPeriodObj = $this->contractObj->contractPeriods()->firstOrCreate( $contractPeriodParams );
    }
    
    private function insertSeasonData($seasonId, $seasonName, $seasonStart, $seasonEnd) {
        // Find or Create Season
        $this->seasonObj = $this->contractPeriodObj->seasons()->firstOrCreate(array('ts_id' => $seasonId, 'name' => $seasonName));
        $seasonPeriodParams = array( 'start' =>  date("Y/m/d", strtotime($seasonStart)), 'end' => date("Y/m/d", strtotime($seasonEnd)) );
        $this->seasonPeriodObj = $this->seasonObj->seasonPeriods()->firstOrCreate( $seasonPeriodParams );
    }
    
    private function insertExtraData($extraName, $extraId) {
        // Find or Create Service Extras
        $this->extraObj = null;
        if ($extraId) {
            $extraParams = array('name' => $extraName, 'ts_id' => $extraId);
            $this->extraObj = $this->serviceObj->serviceExtras()->firstOrCreate( $extraParams );
        }   
    }
    
    private function insertOptionData($optionName, $optionId, $optionStatus) {
           
        // Find Or Create Service Option
        $this->optionObj = null;
        if ($optionId) {
                $serviceOptionParams = array(
                        'occupancy_id' => $this->occupancyObj->id,
                        'name' => $optionName,
                        'ts_id' => $optionId,
                        'status' => $optionStatus
                        );
                $this->optionObj = $this->serviceObj->serviceOptions()->firstOrCreate( $serviceOptionParams );

            // Find or Create Meal Option
            if ($this->mealObj) {
                $this->optionObj->mealOptions()->firstOrCreate( ['meal_id' => $this->mealObj->id] );
            }
        }

    }
    
    private function insertPriceData($buyPrice, $sellPrice) {
        // Find or Create Prices 
        $priceParams = array(
            'season_period_id' => $this->seasonPeriodObj->id,
            'buy_price' => $buyPrice,
            'sell_price' => $sellPrice,
            'service_id' => $this->serviceObj->id
            );

        $this->priceObj = null;
        if ($this->extraObj) {
            $this->priceObj = $this->extraObj->prices()->firstOrCreate( $priceParams );
        } elseif ($optionObj) {
            $this->priceObj = $this->optionObj->prices()->firstOrCreate( $priceParams );
        }
    }
    
    private function insertServicePolicyData() {
        // Find or Create Service Policies
        $this->servicePolicyObj = null;
        if ($this->policyObj) {
            $servicePolicyParams = array('charging_policy_id' => $this->policyObj->id);
            $this->servicePolicyObj = $this->priceObj->servicePolicy()->firstOrCreate( $servicePolicyParams );
        }
    }
    
    private function insertPolicyPriceBandData() {
        
        // Find or Create Service Price Bands
        if ($this->priceBandObj && $this->servicePolicyObj) {
            $policyBandParams = array('price_band_id' => $this->priceBandObj->id);
            $this->servicePolicyObj->policyPriceBands()->firstOrCreate( $policyBandParams );
        }
    }
    
    private function insertWeekpricesData($monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday) {
                
        $weekParams = array('monday' => $monday, 'tuesday' => $tuesday,
                'wednesday' => $wednesday, 'thursday' => $thursday, 'friday' => $friday,
                'saturday' =>  $saturday, 'sunday' => $sunday
            );
        $this->priceObj->weekPrices()->firstOrCreate( $weekParams );           
    }
    
}
