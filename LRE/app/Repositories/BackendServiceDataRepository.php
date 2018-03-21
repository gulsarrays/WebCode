<?php

namespace App\Repositories;

use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\ServiceExtra;
use App\Models\Price;
use App\Models\Region;
use App\Models\Supplier;
use App\Models\Meal;
use App\Models\MealOption;
use App\Models\ServiceType;
use App\Models\Currency;
use App\Models\Occupancy;
use App\Models\ServicePolicy;
use App\Models\Contract;
use App\Models\ContractPeriod;
use App\Models\SeasonPeriod;
use App\Models\Season;
use App\Models\Margins;
use App\Models\WeekPrice;
use App\Models\PriceBand;
use App\Models\PolicyPriceBand;
use App\Models\ExchangeRate;
use App\Models\ChargingPolicy;
use BaseController,
    View,
    Input,
    Session,
    Redirect;
use DB;

// price band TSID : 1896
// week day TSID : 1242 / 1345 (same priec for both week days record)

class BackendServiceDataRepository {

    const NO_OF_RECORDS_PER_PAGE = 10;
    const CONTRACT_TSID = '0';
    const CONTRACT_NAME = 'ET-CUSTOM-CONTARCT';
    const CONTRACT_PERIOD_NAME = 'ET-CUSTOM-CONTARCT-PERIOD-NAME';
    const CONTRACT_PERIOD_DURATION = '10'; // in year
    const SEASON_NAME = 'Season 01';

    private $serviceInputData = array();
    private $serviceTypeObj = null;
    private $currencyObj = null;
    private $regionObj = null;
    private $supplierObj = null;
    private $service_id = 0;
    private $service_tsid = 0;
    private $serviceObj = null;

    public function parseInput($input) {
//        if($input == 'on') { // for checkbox
//           $input = 1; 
//        }
        return $input;
    }

/////////////// service Data Add/edit/Delete -  Start ///////////////////////

    /**
     * 
     * @param form data
     * @return NULL
     */
    public function collectServiceFormInput() {
        
        $this->serviceInputData = array();

        $options_arr = array();
        $extras_arr = array();
        $contracts_arr = array();
        $seasons_arr = array();
        $season_period_arr = array();
        $option_prices_arr = array();
        $extra_prices_arr = array();

        $service_id = Input::get('service_id');
        $service_tsid = Input::get('service_tsid');
        $service_name = Input::get('service_name');
        $service_status = Input::get('service_status');
        $supplier_id = Input::get('supplier_id');
        $region_id = Input::get('region_id');
        $currency_id = Input::get('currency_id');
        $service_type_id = Input::get('service_type_id');
        $margin = Input::get('margin');
        $default_room_type = Input::get('default_room_type');
        
        $service_option_row = Input::get('service_option_row');
        $service_extra_row = Input::get('service_extra_row');
        $season_period_row = Input::get('season_period_row');
        $prices_options_row = Input::get('prices_options_row');
        $prices_extras_row = Input::get('prices_extras_row');
        
        $delete_option_prices = Input::get('delete_option_prices');
        $delete_extra_prices = Input::get('delete_extra_prices');
        
//        $delete_option_prices = '16,23';
//        $delete_extra_prices = '1,5';

        if (empty($service_option_row) && !empty($prices_options_row)) {
            foreach ($prices_options_row as $k => $v) {
                if(empty($v['option_name'])) {
                    continue;
                }
                /// option season start ////
                $contract_id = $v['contract_id'];
                $contract_period_id = $v['contract_period_id'];
                $season_id = $v['season_id'];
                $season_period_id = $v['season_period_id'];
                $season_period_name = '';
                $price_currency_id = $v['currency_id'];
                $price_meal_plan_id = $v['meal_plan_id'];
                $season_period_margin = $v['price_margin'];
                $season_period_premium = '';
                $start_date = $v['start_date'];
                $end_date = $v['end_date'];
                $status = $v['status'];
                $is_delete = 0;

                $season_period_arr[] = array(
                    'contract_id' => $this->parseInput($contract_id),
                    'contract_period_id' => $this->parseInput($contract_period_id),
                    'season_id' => $this->parseInput($season_id),
                    'season_period_id' => $this->parseInput($season_period_id),
                    'season_period_name' => $this->parseInput($season_period_name),
                    'season_period_margin' => $this->parseInput($season_period_margin),
                    'season_period_premium' => $this->parseInput($season_period_premium),
                    'season_period_start_date' => $this->parseInput($start_date),
                    'season_period_end_date' => $this->parseInput($end_date),
                    'status' => $this->parseInput($status),
                    'is_delete' => $this->parseInput($is_delete)
                );

                /// option  season end ////
                /// option end ////
                $option_id = $this->parseInput($v['option_id']);
                $option_name = $v['option_name'];
                $occupancy_id = $v['occupancy_id'];
                $status = $v['status'];
                $is_delete = 0;

                $options_arr[] = array(
                    'option_id' => $this->parseInput($option_id),
                    'option_name' => $this->parseInput($option_name),
                    'occupancy_id' => $this->parseInput($occupancy_id),
                    //'service_extra_id' => $this->parseInput($mandatory_extra),
                    'status' => $this->parseInput($status),
                    'is_delete' => $this->parseInput($is_delete)
                );
                ////////////// option - end
                /////////////////// option price - start
                
//print('<xmp>');
//print_r($v);
//print('</xmp>');
//                die();
                //if(weekprices) {

                if(isset($v['weekprices']) ){ 
                    foreach($v['weekprices'] as $k1 => $v1) {
                        
                       if($k1 === 'week_prices_charging_policy_id') {
                          continue; 
                       }
                       

                        $price_id = $v1['week_prices_price_id'];
                        $option_name = $v['option_name'];
                        $option_id = $v['option_id'];
                        $contract_id = $v['contract_id'];
                        $contract_period_id = $v['contract_period_id'];
                        $season_id = $v['season_id'];
                        $season_period_id = $v['season_period_id'];
                        $season_period_dates = $v['start_date'] . '-to-' . $v['end_date'];
                        $meal_plan_id = $v['meal_plan_id'];
                        
                        
                        $price_margin = $v['price_margin'];
                        $price_currency_id = $v['currency_id'];
                        $price_meal_plan_id = $v['meal_plan_id'];
                        $status = $v['status'];
                        $prices_season_period_start = $v['start_date'];
                        $prices_season_period_end = $v['end_date'];
                        $is_delete = 0;
                        
                        $charging_policy_id = $v['weekprices']['week_prices_charging_policy_id'];                       
                        $policy_price_bands_id = '';
                        //$service_policy_id_price_band = $v1['service_policy_id_price_band'];
                        $price_band_id = '';
                        $price_band_min = '';

                        $price_band_max = ''; 
                                                
                        $week_prices_id = $v1['week_prices_id'];
                        $week_prices_monday = (isset($v1['week_prices_monday']) && $v1['week_prices_monday']== 'on') ? 1 : 0;
                        $week_prices_tuesday = (isset($v1['week_prices_tuesday']) && $v1['week_prices_tuesday']== 'on') ? 1 : 0;
                        $week_prices_wednesday = (isset($v1['week_prices_wednesday']) && $v1['week_prices_wednesday']== 'on') ? 1 : 0;
                        $week_prices_thursday = (isset($v1['week_prices_thursday']) && $v1['week_prices_thursday']== 'on') ? 1 : 0;
                        $week_prices_friday = (isset($v1['week_prices_friday']) && $v1['week_prices_friday']== 'on') ? 1 : 0;
                        $week_prices_saturday = (isset($v1['week_prices_saturday']) && $v1['week_prices_saturday']== 'on') ? 1 : 0;
                        $week_prices_sunday = (isset($v1['week_prices_sunday']) && $v1['week_prices_sunday']== 'on') ? 1 : 0; 
                        $buy_price = $v1['week_prices_buy_price'];
                        $sell_price = $v1['week_prices_sell_price'];
                        
                        $price_edited = isset($v1['price_edited']) ? $v1['price_edited'] : 0;               
                        
                        
                        $option_prices_arr[] = array(
                            'price_id' => $this->parseInput($price_id),
                            'buy_price' => $this->parseInput($buy_price),
                            'sell_price' => $this->parseInput($sell_price),
                            'price_margin' => $this->parseInput($price_margin),
                            'price_currency_id' => $this->parseInput($price_currency_id),
                            'price_meal_plan_id' => $this->parseInput($price_meal_plan_id),
                            'prices_season_period_start' => $this->parseInput($prices_season_period_start),
                            'prices_season_period_end' => $this->parseInput($prices_season_period_end),
                            'meal_id' => $this->parseInput($meal_plan_id),
                            'policy_id' => $this->parseInput($charging_policy_id),
                            'option_id' => $this->parseInput($option_id),
                            'option_name' => $this->parseInput($option_name),
                            'season_id' => $this->parseInput($season_id),
                            'season_period_id' => $this->parseInput($season_period_id),
                            'season_period_dates' => $this->parseInput($season_period_dates),
                            'status' => $this->parseInput($status),
                            'is_delete' => $this->parseInput($is_delete),
                            'policy_price_bands_id' => $this->parseInput($policy_price_bands_id),
                            //'service_policy_id_price_band' => $this->parseInput($service_policy_id_price_band),
                            'price_band_id' => $this->parseInput($price_band_id),
                            'price_band_min' => $this->parseInput($price_band_min),
                            'price_band_max' => $this->parseInput($price_band_max),
                            'week_prices_id' => $this->parseInput($week_prices_id),
                            'week_prices_monday' => $this->parseInput($week_prices_monday),
                            'week_prices_tuesday' => $this->parseInput($week_prices_tuesday),
                            'week_prices_wednesday' => $this->parseInput($week_prices_wednesday),
                            'week_prices_thursday' => $this->parseInput($week_prices_thursday),
                            'week_prices_friday' => $this->parseInput($week_prices_friday),
                            'week_prices_saturday' => $this->parseInput($week_prices_saturday),

                            'week_prices_sunday' => $this->parseInput($week_prices_sunday),
                            'price_edited' => $this->parseInput($price_edited)
                        );
                        
                   }

                }else if(isset($v['pricebands']) ){ 

                   foreach($v['pricebands'] as $k1 => $v1) {
                       if($k1 === 'price_bands_charging_policy_id') {
                          continue; 
                       }
                       
                        $price_id = $v1['price_bands_price_id'];
                        $option_name = $v['option_name'];
                        $option_id = $v['option_id'];
                        $contract_id = $v['contract_id'];
                        $contract_period_id = $v['contract_period_id'];
                        $season_id = $v['season_id'];
                        $season_period_id = $v['season_period_id'];
                        $season_period_dates = $v['start_date'] . '-to-' . $v['end_date'];
                        $meal_plan_id = $v['meal_plan_id'];
                        
                        
                        $price_margin = $v['price_margin'];
                        $price_currency_id = $v['currency_id'];
                        $price_meal_plan_id = $v['meal_plan_id'];
                        $status = $v['status'];
                        $prices_season_period_start = $v['start_date'];
                        $prices_season_period_end = $v['end_date'];
                        $is_delete = 0;
                        
                        $charging_policy_id = $v['pricebands']['price_bands_charging_policy_id'];                       
                        $policy_price_bands_id = $v1['policy_price_bands_id'];
                        //$service_policy_id_price_band = $v1['service_policy_id_price_band'];
                        $price_band_id = $v1['price_bands_id'];
                        $price_band_min = $v1['price_bands_min'];
                        $price_band_max = $v1['price_bands_max'];  
                        $buy_price = $v1['price_bands_buy_price'];
                        $sell_price = $v1['price_bands_sell_price'];
                        
                        $price_edited = isset($v1['price_edited']) ? $v1['price_edited'] : 0;               
                        
                        $week_prices_id = '';
                        $week_prices_monday = '';
                        $week_prices_tuesday = '';
                        $week_prices_wednesday = '';
                        $week_prices_thursday = '';
                        $week_prices_friday = '';
                        $week_prices_saturday = '';
                        $week_prices_sunday = '';               
                
                        
                        $option_prices_arr[] = array(
                            'price_id' => $this->parseInput($price_id),
                            'buy_price' => $this->parseInput($buy_price),
                            'sell_price' => $this->parseInput($sell_price),
                            'price_margin' => $this->parseInput($price_margin),
                            'price_currency_id' => $this->parseInput($price_currency_id),
                            'price_meal_plan_id' => $this->parseInput($price_meal_plan_id),
                            'prices_season_period_start' => $this->parseInput($prices_season_period_start),
                            'prices_season_period_end' => $this->parseInput($prices_season_period_end),
                            'meal_id' => $this->parseInput($meal_plan_id),
                            'policy_id' => $this->parseInput($charging_policy_id),
                            'option_id' => $this->parseInput($option_id),
                            'option_name' => $this->parseInput($option_name),
                            'season_id' => $this->parseInput($season_id),
                            'season_period_id' => $this->parseInput($season_period_id),
                            'season_period_dates' => $this->parseInput($season_period_dates),
                            'status' => $this->parseInput($status),
                            'is_delete' => $this->parseInput($is_delete),
                            'policy_price_bands_id' => $this->parseInput($policy_price_bands_id),
                            //'service_policy_id_price_band' => $this->parseInput($service_policy_id_price_band),
                            'price_band_id' => $this->parseInput($price_band_id),
                            'price_band_min' => $this->parseInput($price_band_min),
                            'price_band_max' => $this->parseInput($price_band_max),
                            'week_prices_id' => $this->parseInput($week_prices_id),
                            'week_prices_monday' => $this->parseInput($week_prices_monday),
                            'week_prices_tuesday' => $this->parseInput($week_prices_tuesday),
                            'week_prices_wednesday' => $this->parseInput($week_prices_wednesday),
                            'week_prices_thursday' => $this->parseInput($week_prices_thursday),
                            'week_prices_friday' => $this->parseInput($week_prices_friday),
                            'week_prices_saturday' => $this->parseInput($week_prices_saturday),
                            'week_prices_sunday' => $this->parseInput($week_prices_sunday),
                            'price_edited' => $this->parseInput($price_edited)
                        );
                   }
                }
                else {
                    $price_id = $v['price_id'];
                    $option_name = $v['option_name'];
                    $option_id = $v['option_id'];
                    $contract_id = $v['contract_id'];
                    $contract_period_id = $v['contract_period_id'];
                    $season_id = $v['season_id'];
                    $season_period_id = $v['season_period_id'];
                    $season_period_dates = $v['start_date'] . '-to-' . $v['end_date'];
                    $meal_plan_id = $v['meal_plan_id'];
                    $charging_policy_id = $v['charging_policy_id'];    
                    
                    $price_margin = $v['price_margin'];
                    $price_currency_id = $v['currency_id'];
                    $price_meal_plan_id = $v['meal_plan_id'];
                    $status = $v['status'];
                    $prices_season_period_start = $v['start_date'];
                    $prices_season_period_end = $v['end_date'];
                    $is_delete = 0;
                
                
                    $policy_price_bands_id = '';
                    $service_policy_id_price_band = '';
                    $price_band_id = '';
                    $price_band_min = '';
                    $price_band_max = '';
                
                    $week_prices_id = '';
                    $week_prices_monday = '';
                    $week_prices_tuesday = '';
                    $week_prices_wednesday = '';
                    $week_prices_thursday = '';
                    $week_prices_friday = '';
                    $week_prices_saturday = '';
                    $week_prices_sunday = '';                

                    $option_prices_arr_tmp = array();
                    if(isset($v['buy_price'])) {
                        $buy_price = $v['buy_price'];
                        $option_prices_arr_tmp = array_merge($option_prices_arr_tmp,array('buy_price' => $this->parseInput($buy_price)));
                    }
                    if(isset($v['sell_price'])) {
                        $sell_price = $v['sell_price'];
                        $option_prices_arr_tmp = array_merge($option_prices_arr_tmp,array('sell_price' => $this->parseInput($sell_price)));
                    }
                    
                    $price_edited = isset($v['price_edited']) ? $v['price_edited'] : 0;
                    
                    if(isset($v['pricebands_or_weekprices'])) {
                        $pricebands_or_weekprices = $v['pricebands_or_weekprices'];
                        $option_prices_arr_tmp = array_merge($option_prices_arr_tmp,array('pricebands_or_weekprices' => $this->parseInput($pricebands_or_weekprices)));
                    }
                    $option_prices_arr[] = array_merge($option_prices_arr_tmp, array( 
                        'price_id' => $this->parseInput($price_id),                        
                        'price_margin' => $this->parseInput($price_margin),
                        'price_currency_id' => $this->parseInput($price_currency_id),
                        'price_meal_plan_id' => $this->parseInput($price_meal_plan_id),
                        'prices_season_period_start' => $this->parseInput($prices_season_period_start),
                        'prices_season_period_end' => $this->parseInput($prices_season_period_end),
                        'meal_id' => $this->parseInput($meal_plan_id),
                        'policy_id' => $this->parseInput($charging_policy_id),
                        'option_id' => $this->parseInput($option_id),
                        'option_name' => $this->parseInput($option_name),
                        'season_id' => $this->parseInput($season_id),
                        'season_period_id' => $this->parseInput($season_period_id),
                        'season_period_dates' => $this->parseInput($season_period_dates),
                        'status' => $this->parseInput($status),
                        'is_delete' => $this->parseInput($is_delete),                    
                        'policy_price_bands_id' => $this->parseInput($policy_price_bands_id),
                        'service_policy_id_price_band' => $this->parseInput($service_policy_id_price_band),
                        'price_band_id' => $this->parseInput($price_band_id),
                        'price_band_min' => $this->parseInput($price_band_min),
                        'price_band_max' => $this->parseInput($price_band_max),
                        'week_prices_id' => $this->parseInput($week_prices_id),
                        'week_prices_monday' => $this->parseInput($week_prices_monday),
                        'week_prices_tuesday' => $this->parseInput($week_prices_tuesday),
                        'week_prices_wednesday' => $this->parseInput($week_prices_wednesday),
                        'week_prices_thursday' => $this->parseInput($week_prices_thursday),
                        'week_prices_friday' => $this->parseInput($week_prices_friday),
                        'week_prices_saturday' => $this->parseInput($week_prices_saturday),
                        'week_prices_sunday' => $this->parseInput($week_prices_sunday),
                        'price_edited' => $this->parseInput($price_edited)
                    ));
                    
                    
                    
                    
                    
                }
                

                /////////////////// option price- end
            }
        } 

        if (empty($service_extra_row) && !empty($prices_extras_row)) {
            foreach ($prices_extras_row as $k => $v) {
                if(empty($v['extra_name'])) {
                    continue;
                }
                /////////// extra season -  start

                $contract_id = $v['contract_id'];
                $contract_period_id = $v['contract_period_id'];
                $season_id = $v['season_id'];
                $season_period_id = $v['season_period_id'];
                $season_period_name = '';
                $price_currency_id = $v['currency_id'];
                $season_period_margin = $v['price_margin'];
                $season_period_premium = '';
                $start_date = $v['start_date'];
                $end_date = $v['end_date'];
                $status = $v['status'];
                $is_delete = 0;

                $season_period_arr[] = array(
                    'contract_id' => $this->parseInput($contract_id),
                    'contract_period_id' => $this->parseInput($contract_period_id),
                    'season_id' => $this->parseInput($season_id),
                    'season_period_id' => $this->parseInput($season_period_id),
                    'season_period_name' => $this->parseInput($season_period_name),
                    'season_period_margin' => $this->parseInput($season_period_margin),
                    'season_period_premium' => $this->parseInput($season_period_premium),
                    'season_period_start_date' => $this->parseInput($start_date),
                    'season_period_end_date' => $this->parseInput($end_date),
                    'status' => $this->parseInput($status),
                    'is_delete' => $this->parseInput($is_delete)
                );

                /////////// extra Season -  end
                /////////// extra -  start
                $extras_id = $v['extra_id'];
                $extra_name = $v['extra_name'];
                $status = $v['status'];
                $is_mandatory = $v['is_mandatory'];                
                $is_delete = 0;

                $extras_arr[] = array(
                    'extras_id' => $this->parseInput($extras_id),
                    'extras_name' => $this->parseInput($extra_name),
                    'status' => $this->parseInput($status),
                    'status' => $this->parseInput($status),
                    'mandatory' => $this->parseInput($is_mandatory),
                    'is_delete' => $this->parseInput($is_delete)
                );
                /////////// extra -  End
                /////////// extra Price-  start

                if(isset($v['weekprices']) ){ 
                   foreach($v['weekprices'] as $k1 => $v1) {
                        if($k1 === 'week_prices_charging_policy_id') {
                            continue; 
                        }
                        $price_id = $v1['week_prices_price_id'];
                        $extra_name = $v['extra_name'];
                        $extra_id = $v['extra_id'];
                        $contract_id = $v['contract_id'];
                        $contract_period_id = $v['contract_period_id'];
                        $season_id = $v['season_id'];
                        $season_period_id = $v['season_period_id'];
                        $season_period_dates = $v['start_date'] . '-to-' . $v['end_date'];
                        //$charging_policy_id = $v['charging_policy_id'];
                        
                        $price_margin = $v['price_margin'];
                        $price_currency_id = $v['currency_id'];
                        $status = $v['status'];
                        $is_mandatory = $v['is_mandatory'];
                        $prices_season_period_start = $v['start_date'];
                        $prices_season_period_end = $v['end_date'];
                        $is_delete = 0;

                        $charging_policy_id = $v['weekprices']['week_prices_charging_policy_id']; 
                        $policy_price_bands_id = '';
                        //$service_policy_id_price_band = $v1['service_policy_id_price_band'];

                        $price_band_id = '';
                        $price_band_min = '';
                        $price_band_max = '';  
                                                
                        $week_prices_id = $v1['week_prices_id'];
                        $week_prices_monday = (isset($v1['week_prices_monday']) && $v1['week_prices_monday']== 'on') ? 1 : 0;
                        $week_prices_tuesday = (isset($v1['week_prices_tuesday']) && $v1['week_prices_tuesday']== 'on') ? 1 : 0;
                        $week_prices_wednesday = (isset($v1['week_prices_wednesday']) && $v1['week_prices_wednesday']== 'on') ? 1 : 0;
                        $week_prices_thursday = (isset($v1['week_prices_thursday']) && $v1['week_prices_thursday']== 'on') ? 1 : 0;
                        $week_prices_friday = (isset($v1['week_prices_friday']) && $v1['week_prices_friday']== 'on') ? 1 : 0;
                        $week_prices_saturday = (isset($v1['week_prices_saturday']) && $v1['week_prices_saturday']== 'on') ? 1 : 0;
                        $week_prices_sunday = (isset($v1['week_prices_sunday']) && $v1['week_prices_sunday']== 'on') ? 1 : 0; 
                        $buy_price = $v1['week_prices_buy_price'];
                        $sell_price = $v1['week_prices_sell_price'];
                        
                        $price_edited = isset($v1['price_edited']) ? $v1['price_edited'] : 0;               

                        $extra_prices_arr[] = array(
                            'price_id' => $this->parseInput($price_id),
                            'buy_price' => $this->parseInput($buy_price),
                            'sell_price' => $this->parseInput($sell_price),
                            'price_margin' => $this->parseInput($price_margin),
                            'price_currency_id' => $this->parseInput($price_currency_id),
                            'prices_season_period_start' => $this->parseInput($prices_season_period_start),
                            'prices_season_period_end' => $this->parseInput($prices_season_period_end),
                            'policy_id' => $this->parseInput($charging_policy_id),
                            'extra_id' => $this->parseInput($extra_id),
                            'extra_name' => $this->parseInput($extra_name),
                            'season_id' => $this->parseInput($season_id),
                            'mandatory' => $this->parseInput($is_mandatory),
                            'season_period_id' => $this->parseInput($season_period_id),
                            'season_period_dates' => $this->parseInput($season_period_dates),
                            'status' => $this->parseInput($status),
                            'is_delete' => $this->parseInput($is_delete),
                            'policy_price_bands_id' => $this->parseInput($policy_price_bands_id),

                            //'service_policy_id_price_band' => $this->parseInput($service_policy_id_price_band),

                            'price_band_id' => $this->parseInput($price_band_id),
                            'price_band_min' => $this->parseInput($price_band_min),
                            'price_band_max' => $this->parseInput($price_band_max),
                            'week_prices_id' => $this->parseInput($week_prices_id),
                            'week_prices_monday' => $this->parseInput($week_prices_monday),
                            'week_prices_tuesday' => $this->parseInput($week_prices_tuesday),
                            'week_prices_wednesday' => $this->parseInput($week_prices_wednesday),
                            'week_prices_thursday' => $this->parseInput($week_prices_thursday),
                            'week_prices_friday' => $this->parseInput($week_prices_friday),
                            'week_prices_saturday' => $this->parseInput($week_prices_saturday),

                            'week_prices_sunday' => $this->parseInput($week_prices_sunday),
                            'price_edited' => $this->parseInput($price_edited)

                        );
                   }
                    
                } else if(isset($v['pricebands']) ){ 
                   foreach($v['pricebands'] as $k1 => $v1) {
                        if($k1 === 'price_bands_charging_policy_id') {
                            continue; 
                        }
                        $price_id = $v1['price_bands_price_id'];;
                        $extra_name = $v['extra_name'];
                        $extra_id = $v['extra_id'];
                        $contract_id = $v['contract_id'];
                        $contract_period_id = $v['contract_period_id'];
                        $season_id = $v['season_id'];
                        $season_period_id = $v['season_period_id'];
                        $season_period_dates = $v['start_date'] . '-to-' . $v['end_date'];
                        //$charging_policy_id = $v['charging_policy_id'];
                        
                        $price_margin = $v['price_margin'];
                        $price_currency_id = $v['currency_id'];
                        $status = $v['status'];
                        $is_mandatory = $v['is_mandatory'];
                        $prices_season_period_start = $v['start_date'];
                        $prices_season_period_end = $v['end_date'];
                        $is_delete = 0;

                        $charging_policy_id = $v['pricebands']['price_bands_charging_policy_id']; 
                        $policy_price_bands_id = $v1['policy_price_bands_id'];
                        //$service_policy_id_price_band = $v1['service_policy_id_price_band'];
                        $price_band_id = $v1['price_bands_id'];
                        $price_band_min = $v1['price_bands_min'];
                        $price_band_max = $v1['price_bands_max'];  
                        $buy_price = $v1['price_bands_buy_price'];
                        $sell_price = $v1['price_bands_sell_price'];
                        
                        $price_edited = isset($v1['price_edited']) ? $v1['price_edited'] : 0;               
                        
                        $week_prices_id = '';
                        $week_prices_monday = '';
                        $week_prices_tuesday = '';
                        $week_prices_wednesday = '';
                        $week_prices_thursday = '';
                        $week_prices_friday = '';
                        $week_prices_saturday = '';
                        $week_prices_sunday = '';  

                        $extra_prices_arr[] = array(
                            'price_id' => $this->parseInput($price_id),
                            'buy_price' => $this->parseInput($buy_price),
                            'sell_price' => $this->parseInput($sell_price),
                            'price_margin' => $this->parseInput($price_margin),
                            'price_currency_id' => $this->parseInput($price_currency_id),
                            'prices_season_period_start' => $this->parseInput($prices_season_period_start),
                            'prices_season_period_end' => $this->parseInput($prices_season_period_end),
                            'policy_id' => $this->parseInput($charging_policy_id),
                            'extra_id' => $this->parseInput($extra_id),
                            'extra_name' => $this->parseInput($extra_name),
                            'season_id' => $this->parseInput($season_id),
                            'mandatory' => $this->parseInput($is_mandatory),
                            'season_period_id' => $this->parseInput($season_period_id),
                            'season_period_dates' => $this->parseInput($season_period_dates),
                            'status' => $this->parseInput($status),
                            'is_delete' => $this->parseInput($is_delete),
                            'policy_price_bands_id' => $this->parseInput($policy_price_bands_id),
                            'service_policy_id_price_band' => $this->parseInput($service_policy_id_price_band),
                            'price_band_id' => $this->parseInput($price_band_id),
                            'price_band_min' => $this->parseInput($price_band_min),
                            'price_band_max' => $this->parseInput($price_band_max),
                            'week_prices_id' => $this->parseInput($week_prices_id),
                            'week_prices_monday' => $this->parseInput($week_prices_monday),
                            'week_prices_tuesday' => $this->parseInput($week_prices_tuesday),
                            'week_prices_wednesday' => $this->parseInput($week_prices_wednesday),
                            'week_prices_thursday' => $this->parseInput($week_prices_thursday),
                            'week_prices_friday' => $this->parseInput($week_prices_friday),
                            'week_prices_saturday' => $this->parseInput($week_prices_saturday),
                            'week_prices_sunday' => $this->parseInput($week_prices_sunday),
                            'price_edited' => $this->parseInput($price_edited)
                        );
                   }
                    
                } else {
                    $price_id = $v['price_id'];
                    $extra_name = $v['extra_name'];
                    $extra_id = $v['extra_id'];
                    $contract_id = $v['contract_id'];
                    $contract_period_id = $v['contract_period_id'];
                    $season_id = $v['season_id'];
                    $season_period_id = $v['season_period_id'];
                    $season_period_dates = $v['start_date'] . '-to-' . $v['end_date'];
                    $charging_policy_id = $v['charging_policy_id'];
//                    $buy_price = $v['buy_price'];
//                    $sell_price = $v['sell_price'];
                    $price_margin = $v['price_margin'];
                    $price_currency_id = $v['currency_id'];
                    $status = $v['status'];
                    $is_mandatory = $v['is_mandatory'];
                    $prices_season_period_start = $v['start_date'];
                    $prices_season_period_end = $v['end_date'];
                    $is_delete = 0;

                    $policy_price_bands_id = '';
                    $service_policy_id_price_band = '';
                    $price_band_id = '';
                    $price_band_min = '';
                    $price_band_max = '';


                    $week_prices_id = '';
                    $week_prices_monday = '';
                    $week_prices_tuesday = '';
                    $week_prices_wednesday = '';
                    $week_prices_thursday = '';
                    $week_prices_friday = '';
                    $week_prices_saturday = '';
                    $week_prices_sunday = '';
                    
                    $extra_prices_arr_tmp = array();
                    if(isset($v['buy_price'])) {
                        $buy_price = $v['buy_price'];
                        $extra_prices_arr_tmp = array_merge($extra_prices_arr_tmp,array('buy_price' => $this->parseInput($buy_price)));
                    }
                    if(isset($v['sell_price'])) {
                        $sell_price = $v['sell_price'];
                        $extra_prices_arr_tmp = array_merge($extra_prices_arr_tmp,array('sell_price' => $this->parseInput($sell_price)));
                    }
                    
                    $price_edited = isset($v['price_edited']) ? $v['price_edited'] : 0;
                    
                    if(isset($v['pricebands_or_weekprices'])) {
                        $pricebands_or_weekprices = $v['pricebands_or_weekprices'];
                        $extra_prices_arr_tmp = array_merge($extra_prices_arr_tmp,array('pricebands_or_weekprices' => $this->parseInput($pricebands_or_weekprices)));
                    }
                    
                    $extra_prices_arr[] = array_merge($extra_prices_arr_tmp, array(
                        'price_id' => $this->parseInput($price_id),
//                        'buy_price' => $this->parseInput($buy_price),
//                        'sell_price' => $this->parseInput($sell_price),
                        'price_margin' => $this->parseInput($price_margin),
                        'price_currency_id' => $this->parseInput($price_currency_id),
                        'prices_season_period_start' => $this->parseInput($prices_season_period_start),
                        'prices_season_period_end' => $this->parseInput($prices_season_period_end),
                        'policy_id' => $this->parseInput($charging_policy_id),
                        'extra_id' => $this->parseInput($extra_id),
                        'extra_name' => $this->parseInput($extra_name),
                        'season_id' => $this->parseInput($season_id),
                        'mandatory' => $this->parseInput($is_mandatory),
                        'season_period_id' => $this->parseInput($season_period_id),
                        'season_period_dates' => $this->parseInput($season_period_dates),
                        'status' => $this->parseInput($status),
                        'is_delete' => $this->parseInput($is_delete),
                        'policy_price_bands_id' => $this->parseInput($policy_price_bands_id),
                        'service_policy_id_price_band' => $this->parseInput($service_policy_id_price_band),
                        'price_band_id' => $this->parseInput($price_band_id),
                        'price_band_min' => $this->parseInput($price_band_min),
                        'price_band_max' => $this->parseInput($price_band_max),
                        'week_prices_id' => $this->parseInput($week_prices_id),
                        'week_prices_monday' => $this->parseInput($week_prices_monday),
                        'week_prices_tuesday' => $this->parseInput($week_prices_tuesday),
                        'week_prices_wednesday' => $this->parseInput($week_prices_wednesday),
                        'week_prices_thursday' => $this->parseInput($week_prices_thursday),
                        'week_prices_friday' => $this->parseInput($week_prices_friday),
                        'week_prices_saturday' => $this->parseInput($week_prices_saturday),
                        'week_prices_sunday' => $this->parseInput($week_prices_sunday),
                        'price_edited' => $this->parseInput($price_edited)
                    ));
                }

                /////////// extra Price - end
            }
        } 

        $this->serviceInputData = array(
            'service_id' => $this->parseInput($service_id),
            'service_tsid' => $this->parseInput($service_tsid),
            'service_name' => $this->parseInput($service_name),
            'service_status' => $this->parseInput($service_status),
            'supplier_id' => $this->parseInput($supplier_id),
            'region_id' => $this->parseInput($region_id),
            'currency_id' => $this->parseInput($currency_id),
            'service_type_id' => $this->parseInput($service_type_id),
            'default_room_type' => $this->parseInput($default_room_type),
            'options' => $options_arr,
            'extras' => $extras_arr,
            'contracts' => $contracts_arr,
            'seasons' => $seasons_arr,
            'season_periods' => $season_period_arr,
            'option_prices' => $option_prices_arr,
            'extra_prices' => $extra_prices_arr,
            'delete_option_prices' => $delete_option_prices,
            'delete_extra_prices' => $delete_extra_prices
        );
        
//print('<xmp>');
//print_r($_POST);
//print_r($this->serviceInputData);
//print('</xmp>');
//die('12333');

//        
//        $this->deleteOptions();
//        $this->deleteExtras();
    }

    /**
     * 
     * @param array
     * @return int
     */
    public function updateServiceData() {

        //$this->updateRegionTable();
        //$this->getUniqueRoomTypes();
        
        DB::beginTransaction(); //Start transaction!
        try {
            $mealObj = null;
            $this->serviceTypeObj = ServiceType::where('id', $this->serviceInputData['service_type_id'])->first();
            $this->currencyObj = Currency::where('id', $this->serviceInputData['currency_id'])->first();
            $this->regionObj = Region::where('id', $this->serviceInputData['region_id'])->first();
            $this->supplierObj = Supplier::where('id', $this->serviceInputData['supplier_id'])->first();

            $service_id = $this->processServiceTableData();
            $newExtrasArr = $this->processServiceExtrasTableData();
            $newOptionArr = $this->processServiceOptionsTableData($newExtrasArr);
            $newSeasonPeriodArr = $this->processSeasonPeriodsTableData();
            $err = $this->processOptionPriceTableData($newSeasonPeriodArr, $newOptionArr);
            if(!empty($err) && $err == 'use_delete_action') {
                //DB::rollback();
                //return $err;
            }
            $err = $this->processExtraPriceTableData($newSeasonPeriodArr, $newExtrasArr);
            if(!empty($err) && $err == 'use_delete_action') {
                //DB::rollback();
                //return $err;
            }
            
            $this->updateIsDefaultForOptionsAndExtras();

        } catch (Exception $ex) {
            //failed logic here
            DB::rollback();
            throw $ex;
        }
        DB::commit();
        
//        if(!empty($err) && $err == 'use_delete_action') {
//            return $err;
//        }
        return $this->service_tsid;
    }

    /*
     * @param form data
     * @return null
     */

    private function processServiceTableData() {

        // Find or Create Service
        $serviceParams = array(
            'ts_id' => $this->serviceInputData['service_tsid'],
            'name' => $this->serviceInputData['service_name'],
            'region_id' => $this->regionObj->id,
            'currency_id' => isset($this->currencyObj->id) ? $this->currencyObj->id : 0,
            'service_type_id' => $this->serviceTypeObj->id,
            'supplier_id' => $this->supplierObj->id,
            'status' => $this->serviceInputData['service_status']
        );

        $serviceObj = Service::where('ts_id', $this->serviceInputData['service_tsid'])->first();
        if (empty($serviceObj)) { // Add
            $serviceObj = Service::firstOrCreate($serviceParams);
        } else { // Edit          
            foreach ($serviceParams as $key => $value) {
                $serviceObj->$key = $value;
            }
            $serviceObj->save();
        }

        if (empty($this->serviceInputData['service_tsid'])) {
            $serviceObj->ts_id = $serviceObj->id;
            $serviceObj->save();
        }
        $this->service_id = $serviceObj->id;
        $this->service_tsid = $serviceObj->ts_id;
    }

    /*
     * @param form data
     * @return array
     */

    private function processOptionPriceTableData($newSeasonPeriodArr = array(), $newOptionArr = array()) {   
        foreach ($this->serviceInputData['option_prices'] as $key => $optionPrice) {

            if (!empty($newSeasonPeriodArr)) {
                foreach ($newSeasonPeriodArr as $newSeasonPeriodID => $newSeasonPeriodDates) {
                    if ($newSeasonPeriodDates == $optionPrice["season_period_dates"]) {
                        $optionPrice['season_period_id'] = $newSeasonPeriodID;
                        break;
                    }
                }
            }

            if (!empty($newOptionArr['option'])) {
                foreach ($newOptionArr['option'] as $newOptionName => $newOptionId) {
                    if ($newOptionName == $optionPrice["option_name"]) {
                        $optionPrice['option_id'] = $newOptionId;
                        break;
                    }
                }
            }

            $optionPriceObj = null;
            $priceable_type = 'App\Models\ServiceOption';
            $optionPriceStatus = $optionPrice["status"];
            $optionPriceIsDelete = $optionPrice["is_delete"];

            if ($optionPriceIsDelete == 1) {
                MealOption::where('service_option_id', $optionPrice['option_id'])->delete(); //delete query   
                ServicePolicy::where('id', $optionPrice['price_id'])->where('charging_policy_id', $optionPrice['policy_id'])->delete(); //delete query   
                Price::where('id', $optionPrice['price_id'])->delete(); //delete query                        
            } else if (isset($optionPrice['price_id'])) {
                
                if ( (!empty($optionPrice['week_prices_monday']) || !empty($optionPrice['week_prices_tuesday']) || !empty($optionPrice['week_prices_wednesday']) || !empty($optionPrice['week_prices_thursday']) || !empty($optionPrice['week_prices_friday']) || !empty($optionPrice['week_prices_saturday']) || !empty($optionPrice['week_prices_sunday']))  && (int) $optionPrice['price_band_id'] == 0) { // Week prices
                    $optionPrice['price_id'] = $this->processWeekPricesTableData($optionPrice, $priceable_type);
                }

                $optionPriceParams = array(
                    'priceable_id' => $optionPrice['option_id'],
                    'priceable_type' => $priceable_type,
                    'season_period_id' => $optionPrice['season_period_id'],
                    'currency_id' => $optionPrice['price_currency_id'],
                    'season_period_start' => $optionPrice['prices_season_period_start'],
                    'season_period_end' => $optionPrice['prices_season_period_end'],
                    'status' => $optionPriceStatus,
                    'service_id' => $this->service_id
                );
                
                if(isset($optionPrice['buy_price'])) {                        
                    $optionPriceParams = array_merge($optionPriceParams,array('buy_price' => $optionPrice['buy_price']));
                }
                if(isset($optionPrice['sell_price'])) {                        
                    $optionPriceParams = array_merge($optionPriceParams,array('sell_price' => $optionPrice['sell_price']));
                }
                if(isset($optionPrice['meal_plan_id'])) {                        
                    $optionPriceParams = array_merge($optionPriceParams,array('meal_plan_id' => $optionPrice['meal_plan_id']));
                }
                if(isset($optionPrice['price_margin'])) {                        
                    $optionPriceParams = array_merge($optionPriceParams,array('margin' => $optionPrice['price_margin']));
                }

                if ((int) $optionPrice['price_id'] > 0) { // edit
                    $optionPriceObj = Price::where('id', $optionPrice['price_id'])->first();
                    if (empty($optionPriceObj)) {
                        
                        $optionPriceParams = array_merge($optionPriceParams,array('id' => $optionPrice['price_id']));
                        $optionPriceObj = Price::firstOrCreate($optionPriceParams);
                        $this->serviceInputData['option_prices'][$key]["price_id"] = $optionPriceObj->id;
                        $optionPrice['price_id'] = $optionPriceObj->id;
                    } else {
                        
                        if($optionPrice['price_edited'] == 1) {
                            $optionPriceParams1 = (array)$optionPriceParams;
//                            echo 'price_edited : '.$optionPrice['price_edited'].'<br>';
//                            echo 'price_id : '.$optionPrice['price_id'].'<br>';
//                        die('98111111111111');
//                            unset($optionPriceParams1['margin']);                        
//                            $optionPriceObj1 =  DB::table('prices')->where($optionPriceParams1)->get();
                            $optionPriceObj1 =  DB::table('prices')->where($optionPriceParams1)->get();
//
//                            print('<xmp>');
//                            print_r($optionPriceParams1);
//                            print_r($optionPriceObj1);
//                            print('</xmp>');
////                            die('98111111111111');


                            if(empty($optionPriceObj1)) {
//                                die('updateeeeeeee');
                                foreach ($optionPriceParams as $key => $value) {
                                    $optionPriceObj->$key = $value;
                                }
                                $optionPriceObj->save();
                            } else {
//                                die('NOT updateeeeeeee');
                                //return 'use_delete_action';
                            }
                        }
                    }
                } else { // add
                    $optionPriceObj = Price::firstOrCreate($optionPriceParams);
                    $this->serviceInputData['option_prices'][$key]["price_id"] = $optionPriceObj->id;
                    $optionPrice['price_id'] = $optionPriceObj->id;
                }

                $servicePolicyObj = null;
                if (!empty($optionPrice['policy_id']) && (int) $optionPrice['policy_id'] > 0) {

                    $servicePolicyParams = array(
                        'price_id' => $optionPriceObj->id,
                        'charging_policy_id' => $optionPrice['policy_id'],
                        'status' => $optionPriceStatus
                    );

                    if ((int) $optionPrice['price_id'] > 0) { // edit
                        $servicePolicyObj = ServicePolicy::where('price_id', $optionPrice['price_id'])->first();
                        if (empty($servicePolicyObj)) {
                            $servicePolicyParams = array(
                                'price_id' => $optionPriceObj->id,
                                'charging_policy_id' => $optionPrice['policy_id'],
                                'status' => $optionPriceStatus
                            );
                            $servicePolicyObj = ServicePolicy::firstOrCreate($servicePolicyParams);
                        } else {
                            foreach ($servicePolicyParams as $key => $value) {
                                $servicePolicyObj->$key = $value;
                            }
                            $servicePolicyObj->save();
                        }
                    } else { // add
                        $servicePolicyObj = ServicePolicy::firstOrCreate($servicePolicyParams);
                    }
                }


                $mealOptionObj = null;
                if (isset($optionPrice['meal_id']) && !empty($optionPrice['meal_id']) && (int) $optionPrice['meal_id'] > 0) {
                    $mealOptionParams = array(
                        'service_option_id' => $optionPrice['option_id'],
                        'meal_id' => $optionPrice['meal_id'],
                        'status' => $optionPriceStatus,
                        'season_period_id' => $optionPrice['season_period_id']
                    );

                    $processMealOption = true;
                    if (!empty($newOptionArr['mealOption'])) {
                        foreach ($newOptionArr['mealOption'] as $newMealOptionName => $newMealOptionId) {
                            if ($newMealOptionName == $optionPrice['option_id']) {
                                $processMealOption = false;
                                break;
                            }
                        }
                    }

                    if ($processMealOption === true) {
                        $mealOptionObj = MealOption::where('service_option_id', $optionPrice['option_id'])->first();

                        if (empty($mealOptionObj)) {
                            $mealOptionObj = MealOption::Create($mealOptionParams);
                        } else {
                            foreach ($mealOptionParams as $key => $value) {
                                $mealOptionObj->$key = $value;
                            }
                            $mealOptionObj->save();
                        }
                    }
                }

                if ((int) $optionPrice['price_band_min'] > 0 && (int) $optionPrice['price_band_max'] > 0) { // add price band 
                    $optionPrice['price_id'] = $this->processPriceBandsTableData($optionPrice, $priceable_type, $servicePolicyObj->id);
                }
                
            }
            if(isset($optionPrice['pricebands_or_weekprices']) && !empty($optionPrice['pricebands_or_weekprices'])) {
                
                $priceObjTmp =  DB::table('prices')->where('priceable_id', '=', $optionPrice['option_id'])->where('service_id', '=', $this->service_id)->where('season_period_id', '=', $optionPrice['season_period_id'])->get();
                
                foreach($priceObjTmp as $priceTmp) {
                                      
                    $tmp_buy_price = $priceTmp->buy_price;
                    $tmp_sell_price = $priceTmp->sell_price;
                    $tmp_margin = $optionPrice['price_margin'];                    
                    
                    $revenue_margin = 1-($tmp_margin/100);
                    $revenue_sell_price = $tmp_buy_price / $revenue_margin ;                
                
                    // update price with respect t margin
                    DB::table('prices')
                        ->where('id', $priceTmp->id)
                        ->update(array('margin' => $tmp_margin,'sell_price' => $revenue_sell_price,'status' => $optionPriceStatus));
                    
                    // update charging policy 
                    DB::table('service_policies')
                        ->where('price_id', $priceTmp->id)
                        ->update(array('charging_policy_id' => $optionPrice['policy_id'],'status' => $optionPriceStatus));
                    
                }                                
            }
            
        }
    }

    /*
     * @param form data
     * @return array
     */

    private function processExtraPriceTableData($newSeasonPeriodArr = array(), $newExtrasArr = array()) {

        foreach ($this->serviceInputData['extra_prices'] as $key => $extraPrice) {
            
            if (!empty($newSeasonPeriodArr)) {
                foreach ($newSeasonPeriodArr as $newSeasonPeriodID => $newSeasonPeriodDates) {
                    if ($newSeasonPeriodDates == $extraPrice["season_period_dates"]) {
                        $extraPrice['season_period_id'] = $newSeasonPeriodID;
                        break;
                    }
                }
            }

            if (!empty($newExtrasArr)) {
                foreach ($newExtrasArr as $newExtrasName => $newExtrasId) {
                    if ($newExtrasName == $extraPrice["extra_name"]) {
                        $extraPrice['extra_id'] = $newExtrasId;
                        break;
                    }
                }
            }

            $extraPriceObj = null;
            $priceable_type = 'App\Models\ServiceExtra';

            $extraPriceIsDelete = $extraPrice["is_delete"];
            $extraPriceStatus = $extraPrice["status"];


            if ($extraPriceIsDelete == 1) {
                ServicePolicy::where('id', $extraPrice['price_id'])->where('charging_policy_id', $extraPrice['policy_id'])->delete(); //delete query   
                Price::where('id', $extraPrice['price_id'])->delete(); //delete query
            } else if (isset($extraPrice['price_id'])) {
              
                if ((!empty($extraPrice['week_prices_monday']) || !empty($extraPrice['week_prices_tuesday']) || !empty($extraPrice['week_prices_wednesday']) || !empty($extraPrice['week_prices_thursday']) || !empty($extraPrice['week_prices_friday']) || !empty($extraPrice['week_prices_saturday']) || !empty($extraPrice['week_prices_sunday']))  &&(int) $extraPrice['price_band_id'] == 0) { // Week prices 
                    
                    $extraPrice['price_id'] = $this->processWeekPricesTableData($extraPrice, $priceable_type);
                }

                $extraPriceParams = array(
                    'priceable_id' => $extraPrice['extra_id'],
                    'priceable_type' => $priceable_type,
                    'season_period_id' => $extraPrice['season_period_id'],
                    'currency_id' => $extraPrice['price_currency_id'],
                    'season_period_start' => $extraPrice['prices_season_period_start'],
                    'season_period_end' => $extraPrice['prices_season_period_end'],
                    'status' => $extraPriceStatus,
                    'service_id' => $this->service_id
                );
                
                if(isset($extraPrice['buy_price'])) {                        
                    $extraPriceParams = array_merge($extraPriceParams,array('buy_price' => $extraPrice['buy_price']));
                }
                if(isset($extraPrice['buy_price'])) {                        
                    $extraPriceParams = array_merge($extraPriceParams,array('sell_price' => $extraPrice['sell_price']));
                }
                if(isset($extraPrice['price_margin'])) {                        
                    $extraPriceParams = array_merge($extraPriceParams,array('margin' => $extraPrice['price_margin']));
                }
            
                if ((int) $extraPrice['price_id'] > 0) { // edit
                    $extraPriceObj = Price::where('id', $extraPrice['price_id'])->first();
                    if (empty($extraPriceObj)) {
                        $extraPriceParams = array_merge($extraPriceParams,array('id' => $extraPrice['price_id']));
                        $extraPriceObj = Price::firstOrCreate($extraPriceParams);
                        $extraPrice['price_id'] = $extraPriceObj->id;
                    } else {             
                        if($extraPrice['price_edited'] == 1) {                            
                            $extraPriceParams1 = (array)$extraPriceParams;                        
                            unset($extraPriceParams1['margin']);                        
                            $extraPriceObj1 =  DB::table('prices')->where($extraPriceParams1)->get();                            
                            if(empty($extraPriceObj1)) {                                 
                                foreach ($extraPriceParams as $key => $value) {
                                    $extraPriceObj->$key = $value;
                                }
                                $extraPriceObj->save();
                            } else {
                                //return 'use_delete_action';
                            }
                        }      
                    }
                } else { // add  
                    $extraPriceObj = Price::firstOrCreate($extraPriceParams);
                    $extraPrice['price_id'] = $extraPriceObj->id;
                }

                $servicePolicyObj = null;
                if (!empty($extraPrice['policy_id']) && (int) $extraPrice['policy_id'] > 0) {

                    $servicePolicyParams = array(
                        'price_id' => $extraPriceObj->id,
                        'charging_policy_id' => $extraPrice['policy_id'],
                        'status' => $extraPriceStatus
                    );

                    if ((int) $extraPrice['price_id'] > 0) { // edit
                        $servicePolicyObj = ServicePolicy::where('price_id', $extraPrice['price_id'])->first();
                        if (empty($servicePolicyObj)) {
                            $servicePolicyParams = array(
                                'price_id' => $extraPriceObj->id,
                                'charging_policy_id' => $extraPrice['policy_id'],
                                'status' => $extraPriceStatus
                            );
                            $servicePolicyObj = ServicePolicy::firstOrCreate($servicePolicyParams);
                        } else {
                            foreach ($servicePolicyParams as $key => $value) {
                                $servicePolicyObj->$key = $value;
                            }
                            $servicePolicyObj->save();
                        }
                    } else { // add
                        $servicePolicyObj = ServicePolicy::firstOrCreate($servicePolicyParams);
                    }
                }

                if ((int) $extraPrice['price_band_min'] > 0 && (int) $extraPrice['price_band_max'] > 0) { // add price band 
                    $extraPrice['price_id'] = $this->processPriceBandsTableData($extraPrice, $priceable_type, $servicePolicyObj->id);
                }
            }
            
            if(isset($extraPrice['pricebands_or_weekprices']) && !empty($extraPrice['pricebands_or_weekprices'])) {
                
                $priceObjTmp =  DB::table('prices')->where('priceable_id', '=', $extraPrice['extra_id'])->where('service_id', '=', $this->service_id)->where('season_period_id', '=', $extraPrice['season_period_id'])->get();
                
                foreach($priceObjTmp as $priceTmp) {
                                      
                    $tmp_buy_price = $priceTmp->buy_price;
                    $tmp_sell_price = $priceTmp->sell_price;
                    $tmp_margin = $extraPrice['price_margin'];                    
                    
                    $revenue_margin = 1-($tmp_margin/100);
                    $revenue_sell_price = $tmp_buy_price / $revenue_margin ;                
                
                    // update price with respect t margin
                    DB::table('prices')
                        ->where('id', $priceTmp->id)
                        ->update(array('margin' => $tmp_margin,'sell_price' => $revenue_sell_price,'status' => $extraPriceStatus));
                    
                    // update charging policy 
                    DB::table('service_policies')
                        ->where('price_id', $priceTmp->id)
                        ->update(array('charging_policy_id' => $extraPrice['policy_id'],'status' => $extraPriceStatus));
                    
                }                                
            }
            
        }
    }

    /*
     * @param form data array
     * @return null
     */

    private function processPriceBandsTableData($optionPrice = array(), $priceable_type = 'App\Models\ServiceOption', $service_policy_id = '') {

        $pricebandObj = null;
        $priceBandParams = array(
            'min' => $optionPrice['price_band_min'],
            'max' => $optionPrice['price_band_max'],
            'status' => $optionPrice['status']
        );
       
        if ((int) $optionPrice['price_band_id'] > 0) {  // edit
            
            $pricebandObj = PriceBand::where('min', $optionPrice['price_band_min'])->where('max', $optionPrice['price_band_max'])->first();
            if (empty($pricebandObj)) {  // add                    
                $priceBandParams = array(
                    'id' => $optionPrice['price_band_id'],
                    'min' => $optionPrice['price_band_min'],
                    'max' => $optionPrice['price_band_max'],
                    'status' => $optionPrice['status']
                );
                
                $pricebandObj = PriceBand::firstOrCreate($priceBandParams);
                $optionPrice['service_policy_id_price_band'] = $service_policy_id;
            } else { // edit                
                foreach ($priceBandParams as $key => $value) {
                    $pricebandObj->$key = $value;
                }
                $pricebandObj->save();
                $optionPrice['service_policy_id_price_band'] = $service_policy_id;
            }
        } else {  // add
            
            $pricebandObj = PriceBand::firstOrCreate($priceBandParams);
            $optionPrice['service_policy_id_price_band'] = $service_policy_id;
        }

        $policyPriceBandObj = null;
        $policyPriceBandParams = array(
            'service_policy_id' => $optionPrice['service_policy_id_price_band'],
            'price_band_id' => $pricebandObj->id,
            'status' => $optionPrice['status']
        );


        if ((int) $optionPrice['policy_price_bands_id'] > 0) { // edit
            $policyPriceBandObj = PolicyPriceBand::where('id', $optionPrice['policy_price_bands_id'])->first();
            if (empty($policyPriceBandObj)) {                
                $policyPriceBandParams = array(
                    'id' => $optionPrice['policy_price_bands_id'],
                    'service_policy_id' => $optionPrice['service_policy_id_price_band'],
                    'price_band_id' => $pricebandObj->id,
                    'status' => $optionPrice['status']
                );                
                $policyPriceBandObj = PolicyPriceBand::firstOrCreate($policyPriceBandParams);
            } else {

                foreach ($policyPriceBandParams as $key => $value) {
                    $policyPriceBandObj->$key = $value;
                }
                $policyPriceBandObj->save();
            }
        } else { // add           
            $policyPriceBandObj = PolicyPriceBand::firstOrCreate($policyPriceBandParams);
        }
    }

    /*
     * @param form data array
     * @return null
     */

    private function processWeekPricesTableData($optionPrice = array(), $priceable_type = 'App\Models\ServiceOption') {

//        if($priceable_type == 'App\Models\ServiceOption') {
//            return false;
//        }
//        print('<xmp>');
//        print_r($optionPrice);
//       // print_r($_POST);
//        print('</xmp>');
//        return false;
//        die('966');
        
        //if (!empty($optionPrice['week_prices_id']) && (int) $optionPrice['price_band_id'] == 0) { // Week prices
            $weekPricesObj = null;
            $weekPricesParams = array(
                'price_id' => $optionPrice['price_id'],
                'monday' => $optionPrice['week_prices_monday'],
                'tuesday' => $optionPrice['week_prices_tuesday'],
                'wednesday' => $optionPrice['week_prices_wednesday'],
                'thursday' => $optionPrice['week_prices_thursday'],
                'friday' => $optionPrice['week_prices_friday'],
                'saturday' => $optionPrice['week_prices_saturday'],
                'sunday' => $optionPrice['week_prices_sunday'],
            );
//echo '988 <br>';
            if ((int) $optionPrice['week_prices_id'] > 0) { // edit
               // echo 'edittttttt <br>';
                
                $servicePolicyObj = null; 
                $servicePolicyParams = array(
                    'price_id' => $optionPrice['price_id'],
                    'charging_policy_id' => $optionPrice['policy_id'],
                    'status' => $optionPrice['status']
                );
                
//               print('<xmp>');
//                print_r($servicePolicyParams);
//                print('</xmp>');
//                
//                        die('1533333');
                
                
                $servicePolicyObj = ServicePolicy::where('price_id', $optionPrice['price_id'])->first();
                if (empty($servicePolicyObj)) {
                    $servicePolicyParams = array(
                        'price_id' => $optionPrice['price_id'],
                        'charging_policy_id' => $optionPrice['policy_id'],
                        'status' => $optionPrice['status']
                    );
                    $servicePolicyObj = ServicePolicy::firstOrCreate($servicePolicyParams);
                } else {
                    foreach ($servicePolicyParams as $key => $value) {
                        $servicePolicyObj->$key = $value;
                    }
                    $servicePolicyObj->save();
                }  
                
                //die('137888888888888888');
                $weekPricesObj = DB::table('week_prices')
                    ->join('prices', 'prices.id', '=', 'week_prices.price_id')
                    ->select('week_prices.id as week_price_id','prices.id as prices_id')
                    ->where('prices.id', '=', $optionPrice['price_id'])
                    ->get();                
                
                if (count($weekPricesObj) > 1 && $optionPrice['price_edited'] == 1) { // need new entry - as same price id is used for twice
                    //echo $optionPrice['price_id'] . " ==> " . '$weekPricesObj : ' . count($weekPricesObj) . '<br>';

                
                    $pricesObj = Price::where('id', $optionPrice['price_id'])->first();

                    if ($pricesObj->buy_price != $optionPrice['buy_price'] || $pricesObj->sell_price != $optionPrice['sell_price']) {
//                        echo $pricesObj->buy_price." -> ".$optionPrice['buy_price'].'<br>';
//                        echo $pricesObj->sell_price." -> ".$optionPrice['sell_price'].'<br>';

                        if ($priceable_type == 'App\Models\ServiceOption') {
                            $option_id = $optionPrice['option_id'];
                        } else if ($priceable_type == 'App\Models\ServiceExtra') {
                            $option_id = $optionPrice['extra_id'];
                        }
                        $optionPriceParams = array(
                            //'priceable_id' => $option_id,
                            'priceable_type' => $priceable_type,
                            'season_period_id' => $optionPrice['season_period_id'],
                            'buy_price' => $optionPrice['buy_price'],
                            'sell_price' => $optionPrice['sell_price'],
                            'margin' => $optionPrice['price_margin'],
                            'status' => $optionPrice["status"],
                            'service_id' => $this->service_id,
                            'currency_id' => $this->serviceInputData['currency_id'],
                            'meal_plan_id' => isset($optionPrice['meal_id']) ? $optionPrice['meal_id'] : 0,
                            'season_period_start' => $optionPrice['prices_season_period_start'],
                            'season_period_end' => $optionPrice['prices_season_period_end']
                        );


//                        print('<xmp>');
//                        print_r($optionPriceParams);
//                        //print_r($_POST);
//                        print('</xmp>');
                        //die('1005555555555');
                        $pricesObj = Price::where($optionPriceParams)->get();



                        if (empty($pricesObj->id)) {
                            //echo 'ifffffffffffff';
                            $pricesObj = Price::firstOrCreate($optionPriceParams);
                            //$queries = DB::getQueryLog();
//$last_query = end($queries);
//print('<xmp>');
//                        print_r($last_query);
//                        print('</xmp>');
                                    //die('error');
                        }
//                        print('<xmp>');
//                        print_r($pricesObj->id);
//                        print('</xmp>');
                        //die('1005555555555');
                        $optionPrice['price_id'] = $pricesObj->id;
                        
                        $servicePolicyObj = null; 
                        $servicePolicyParams = array(
                            'price_id' => $optionPrice['price_id'],
                            'charging_policy_id' => $optionPrice['policy_id'],
                            'status' => $optionPrice['status']
                        );
                        $servicePolicyObj = ServicePolicy::where('price_id', $optionPrice['price_id'])->first();
                        
                       
                        
                        
                        
                        if (empty($servicePolicyObj)) {
                            $servicePolicyParams = array(
                                'price_id' => $optionPrice['price_id'],
                                'charging_policy_id' => $optionPrice['policy_id'],
                                'status' => $optionPrice['status']
                            );
                            $servicePolicyObj = ServicePolicy::firstOrCreate($servicePolicyParams);
                        } else {
                            foreach ($servicePolicyParams as $key => $value) {
                                $servicePolicyObj->$key = $value;
                            }
                            $servicePolicyObj->save();
                        }  
                        
                        
                    }
                }


                $weekPricesObj = WeekPrice::where('id', $optionPrice['week_prices_id'])->first();
                if (empty($weekPricesObj)) {
                    //die('1054');
                    $weekPricesParams = array(
                        'id' => $optionPrice['week_prices_id'],
                        'price_id' => $optionPrice['price_id'],
                        'monday' => $optionPrice['week_prices_monday'],
                        'tuesday' => $optionPrice['week_prices_tuesday'],
                        'wednesday' => $optionPrice['week_prices_wednesday'],
                        'thursday' => $optionPrice['week_prices_thursday'],
                        'friday' => $optionPrice['week_prices_friday'],
                        'saturday' => $optionPrice['week_prices_saturday'],
                        'sunday' => $optionPrice['week_prices_sunday']
                    );
                    $weekPricesObj = WeekPrice::firstOrCreate($weekPricesParams);
                } else {
                    
                    $weekPricesParams = array(
                        'price_id' => $optionPrice['price_id'],
                        'monday' => $optionPrice['week_prices_monday'],
                        'tuesday' => $optionPrice['week_prices_tuesday'],
                        'wednesday' => $optionPrice['week_prices_wednesday'],
                        'thursday' => $optionPrice['week_prices_thursday'],
                        'friday' => $optionPrice['week_prices_friday'],
                        'saturday' => $optionPrice['week_prices_saturday'],
                        'sunday' => $optionPrice['week_prices_sunday']
                    );
                    
//                    print('<xmp>');
//                    print_r($weekPricesParams);
//                    print('</xmp>');
                    
                    foreach ($weekPricesParams as $key => $value) {
                        $weekPricesObj->$key = $value;
                    }
                    $weekPricesObj->save();
                }
                
            } else { // add   
            
                //die('1083');
                
                if ($priceable_type == 'App\Models\ServiceOption') {
                            $option_id = $optionPrice['option_id'];
                } else if ($priceable_type == 'App\Models\ServiceExtra') {
                    $option_id = $optionPrice['extra_id'];
                }
                $optionPriceParams = array(
                    'priceable_id' => $option_id,
                    'priceable_type' => $priceable_type,
                    'season_period_id' => $optionPrice['season_period_id'],
                    'buy_price' => $optionPrice['buy_price'],
                    'sell_price' => $optionPrice['sell_price'],
                    'margin' => $optionPrice['price_margin'],
                    'status' => $optionPrice["status"],
                    'service_id' => $this->service_id,
                    'currency_id' => $this->serviceInputData['currency_id'],
                    'meal_plan_id' => isset($optionPrice['meal_id']) ? $optionPrice['meal_id'] : 0,
                    'season_period_start' => $optionPrice['prices_season_period_start'],
                    'season_period_end' => $optionPrice['prices_season_period_end']
                );
                $pricesObj = Price::where($optionPriceParams)->get();
                
//                print('<xmp>');
//                print_r($this->serviceInputData['currency_id']);
//                //print_r($this->serviceInputData['meal_id']);
////                print_r($this->serviceInputData['prices_season_period_start']);
////                print_r($this->serviceInputData['season_period_end']);
//                //print_r($this->serviceInputData);
//                print_r($optionPriceParams);
//                print('</xmp>');
//                
//                        die('149999999999');
                        
                        
                if (empty($pricesObj->id)) {
                    $pricesObj = Price::firstOrCreate($optionPriceParams);
                }
                
                $optionPrice['price_id'] = $pricesObj->id;
                        
                $servicePolicyObj = null; 
                $servicePolicyParams = array(
                    'price_id' => $optionPrice['price_id'],
                    'charging_policy_id' => $optionPrice['policy_id'],
                    'status' => $optionPrice['status']
                );
                $servicePolicyObj = ServicePolicy::where('price_id', $optionPrice['price_id'])->first();
                if (empty($servicePolicyObj)) {
                    $servicePolicyParams = array(
                        'price_id' => $optionPrice['price_id'],
                        'charging_policy_id' => $optionPrice['policy_id'],
                        'status' => $optionPrice['status']
                    );
                    $servicePolicyObj = ServicePolicy::firstOrCreate($servicePolicyParams);
                } else {
                    foreach ($servicePolicyParams as $key => $value) {
                        $servicePolicyObj->$key = $value;
                    }
                    $servicePolicyObj->save();
                }     
                     
                
                $weekPricesParams = array(
                    'price_id' => $optionPrice['price_id'],
                    'monday' => $optionPrice['week_prices_monday'],
                    'tuesday' => $optionPrice['week_prices_tuesday'],
                    'wednesday' => $optionPrice['week_prices_wednesday'],
                    'thursday' => $optionPrice['week_prices_thursday'],
                    'friday' => $optionPrice['week_prices_friday'],
                    'saturday' => $optionPrice['week_prices_saturday'],
                    'sunday' => $optionPrice['week_prices_sunday'],
                );
                
//                print('<xmp>');
//                print_r($weekPricesParams);
//                print('</xmp>');
//                
//                        die('1533333');
                $weekPricesObj = WeekPrice::firstOrCreate($weekPricesParams);
            }
        //}

//        echo 'processWeekPricesTableData';
//        die('1402');


        return $optionPrice['price_id'];
    }

     /*
     * @param form data
     * @return array
     */

    private function processSeasonPeriodsTableData() {
        $newSeasonPeriodArr = array();

        foreach ($this->serviceInputData['season_periods'] as $key => $seasonPeriod) {

            if ((int) $seasonPeriod['season_period_id'] == 0) { // new record
                $seasonPeriod['season_id'] = $this->getSeasonIdForNewSeasonPeriod($this->service_id, $seasonPeriod);
            }

            $seasonStart = $seasonPeriod['season_period_start_date'];
            $seasonEnd = $seasonPeriod['season_period_end_date'];
            $seasonPeriodStatus = $seasonPeriod["status"];
            $seasonPeriodIsDelete = $seasonPeriod["is_delete"];

            $seasonPeriodParams = array(
                'season_id' => $seasonPeriod['season_id'],
                'name' => $seasonPeriod['season_period_name'],
                'start' => $seasonStart,
                'end' => $seasonEnd,
                'status' => $seasonPeriodStatus
            );

            if ($seasonPeriodIsDelete == 1) {
                SeasonPeriod::where('id', $seasonPeriod['season_period_id'])->delete(); //delete query
            } else if ((int) $seasonPeriod['season_period_id'] > 0) { // edit
                $seasonPeriodObj = SeasonPeriod::where('id', $seasonPeriod['season_period_id'])->first();
                if (empty($seasonPeriodObj)) {
                    $seasonPeriodParams = array(
                        'id' => $seasonPeriod['season_period_id'],
                        'name' => $seasonPeriod['season_period_name'],
                        'season_id' => $seasonPeriod['season_id'],
                        'start' => $seasonStart,
                        'end' => $seasonEnd,
                        'status' => $seasonPeriodStatus
                    );
                    $seasonPeriodObj = SeasonPeriod::firstOrCreate($seasonPeriodParams);
                    $seasonPeriod['season_period_id'] = $seasonPeriodObj->id;
                    $newSeasonPeriodArr[$seasonPeriodObj->id] = $seasonStart . '-to-' . $seasonEnd;
                } else {



                    if($seasonPeriodStatus == 0) {
                        $tmpPriceObj = DB::table('prices')->where('season_period_start', '=', $seasonStart)->where('season_period_end', '=', $seasonEnd)->where('service_id', '=', $this->service_id)->where('status', '=', 1)->get();

                       if(empty($tmpPriceObj)) {
                            $seasonPeriodStatus = 0;
                            $seasonPeriodParams['status'] = 0;
                        } else {                            
                            $seasonPeriodStatus = 1;
                            $seasonPeriodParams['status'] = 1;
                        }
                    }
                    foreach ($seasonPeriodParams as $key => $value) {
                        $seasonPeriodObj->$key = $value;
                    }
                    $seasonPeriodObj->save();
                }
            } else { // add
                $seasonPeriodObj = SeasonPeriod::firstOrCreate($seasonPeriodParams);
                $seasonPeriod['season_period_id'] = $seasonPeriodObj->id;
                $newSeasonPeriodArr[$seasonPeriodObj->id] = $seasonStart . '-to-' . $seasonEnd;
            }
        }

        return $newSeasonPeriodArr;
    }

    /*
     * @param form data
     * @return array
     */

    private function processServiceExtrasTableData() {
        $newExtrasArr = array();

        foreach ($this->serviceInputData['extras'] as $key => $extra) {
            $extraObj = null;
            $extraName = $extra['extras_name'];
            $extraStatus = $extra["status"];
            $extraIsDelete = $extra["is_delete"];
            $extraIsMandatory = $extra["mandatory"];

            if (!empty($extraName)) {
                $extraParams = array(
                    'name' => $extraName,
                    //'is_default' => $extraIsDefault,
                    'status' => $extraStatus,
                    'mandatory' => $extraIsMandatory,
                    'service_id' => $this->service_id
                );

                if ($extraIsDelete == 1) {

                    ServiceOption::where('service_id', $this->service_id)->where('service_extra_id', $extra['extras_id'])->update(['service_extra_id' => NULL]);
                    ; //update query
                    ServiceExtra::where('id', $extra['extras_id'])->delete(); //delete query

                    $newExtrasArr[$extra['extras_id']] = NULL;
                } else if ((int) $extra['extras_id'] > 0) { // edit
                    $extraObj = ServiceExtra::where('id', $extra['extras_id'])->first();
                    if (empty($extraObj)) {
                        $extraParams = array(
                            'id' => $extra['extras_id'],
                            'name' => $extraName,
                            //'is_default' => $extraIsDefault,
                            'status' => $extraStatus,
                            'mandatory' => $extraIsMandatory,
                            'service_id' => $this->service_id
                        );
                        $extraObj = ServiceExtra::firstOrCreate($extraParams);
                        $newExtrasArr[$extraObj->name] = $extraObj->id;

                        $this->serviceInputData['extra_prices'][$key]["extra_id"] = $extraObj->id;
                    } else {

                        if($extraStatus == 0) {
                            $tmpPriceObj = DB::table('prices')->where('priceable_id', $extra['extras_id'])->where('priceable_type', 'App\Models\ServiceExtra')->where('service_id', '=', $this->service_id)->where('status', '=', 1)->get();

                            if(empty($tmpPriceObj)) {
                                $extraStatus = 0;
                                $extraParams['status'] = 0;
                            } else {
                                $extraStatus = 1;
                                $extraParams['status'] = 1;
                            }
                        }
                        foreach ($extraParams as $key => $value) {
                            $extraObj->$key = $value;
                        }
                        $extraObj->save();
                    }
                    
                } else { // add
                    $extraObj = ServiceExtra::firstOrCreate($extraParams);
                    $newExtrasArr[$extraObj->name] = $extraObj->id;
                }
            }
        }
        return $newExtrasArr;
    }

    /*
     * @param form data
     * @return array
     */

    private function processServiceOptionsTableData($newExtrasArr = array()) {



        $newOptionArr = array();
        foreach ($this->serviceInputData['options'] as $key => $option) {
            $optionName = $option["option_name"];
            $optionStatus = $option["status"];
            $optionIsDelete = $option["is_delete"];
            $optionIsDefault = $this->isDefaultOption($optionName);

            // Find Or Create Service Option
            $optionObj = null;
            if (!empty($optionName)) {
                $optionParams = array(
                    'occupancy_id' => $option["occupancy_id"],
                    'name' => $option["option_name"],
                    'service_extra_id' => (!empty($option["service_extra_id"])) ? $option["service_extra_id"] : NULL,
                    //'is_default' => $optionIsDefault,
                    'status' => $optionStatus,
                    'service_id' => $this->service_id
                );

                if ($optionIsDelete == 1) {
                    MealOption::where('service_option_id', $option["option_id"])->delete(); //delete query
                    ServiceOption::where('id', $option["option_id"])->delete(); //delete query

                    $newOptionArr['mealOption'][$option["option_id"]] = NULL;
                } else if ((int) $option["option_id"] > 0) { // edit
                    $optionObj = ServiceOption::where('id', $option["option_id"])->first();
                    if (empty($optionObj)) {
                        $optionParams = array(
                            'id' => $option["option_id"],
                            'occupancy_id' => $option["occupancy_id"],
                            'name' => $option["option_name"],
                            'service_extra_id' => (!empty($option["service_extra_id"])) ? $option["service_extra_id"] : NULL,
                            //'is_default' => $optionIsDefault,
                            'status' => $optionStatus,
                            'service_id' => $this->service_id
                        );

                        $optionObj = ServiceOption::firstOrCreate($optionParams);
                        $newOptionArr['option'][$optionObj->name] = $optionObj->id;
                    } else {
                        if($optionStatus == 0) {
                            $tmpPriceObj = DB::table('prices')->where('priceable_id', $option["option_id"])->where('priceable_type', 'App\Models\ServiceOption')->where('service_id', '=', $this->service_id)->where('status', '=', 1)->get();

                            if(empty($tmpPriceObj)) {
                                $optionStatus = 0;
                                $optionParams['status'] = 0;
                            } else {
                                $optionStatus = 1;
                                $optionParams['status'] = 1;
                            }
                        }
                        foreach ($optionParams as $key => $value) {
                            $optionObj->$key = $value;
                        }
                        $optionObj->save();
                        
                    }
                } else { // add
                    $optionObj = ServiceOption::firstOrCreate($optionParams);
                    $newOptionArr['option'][$optionObj->name] = $optionObj->id;
                }
            }
        }

        return $newOptionArr;
    }

    
    private function updateIsDefaultForOptionsAndExtras() {
        
        $default_room_type = $this->serviceInputData['default_room_type'];
        $service_id = $this->serviceInputData['service_id'];
          
        DB::table('service_options')
            ->where('service_id', $service_id)
            ->update(array('is_default' => 'NO'));
        
        $optionsWithAboveOptionName = DB::table('service_options')->where('name', 'like', "$default_room_type%")->where('service_id', '=', $service_id)->get();

        foreach ($optionsWithAboveOptionName as $option) {
            DB::table('service_options')
                    ->where('id', $option->id)
                    ->update(['is_default' => 'YES', 'is_default_updated_outofCSV' => 1]);
        }
    }

    /**
     * 
     * @param array
     * @return int
     */
    private function getSeasonIdForNewSeasonPeriod($serviceId = NULL, $seasonPeriodArr) {

        $season_id = 0;
        $createNewContract = true;
        $contractsObj = $this->getContractsForService($serviceId);

        foreach ($contractsObj as $contractObj) {
            $contractPeriodsObj = $this->getContractPeriodsForContracts($contractObj->id);
            foreach ($contractPeriodsObj as $contractPeriodObj) {
                $isBetween = $this->isBetween($seasonPeriodArr, $contractPeriodObj);
                if ($isBetween !== false && $season_id == 0) {
                    $createNewContract = false;
                    $season_id = $isBetween;
                }
            }
        }

        if ($createNewContract === true) {

            $duration = self::CONTRACT_PERIOD_DURATION; // in year
            $start_date = $seasonPeriodArr['season_period_start_date'];

            $endDate = strtotime($seasonPeriodArr['season_period_start_date']);
            $end_date = date('Y-m-d', strtotime("+$duration years", $endDate));

            $contract_id = $this->createNewContract($serviceId, $start_date, $end_date);
            $contract_period_id = $this->createNewContractPeriod($contract_id, $start_date, $end_date);
            $season_id = $this->createNewSeason($contract_period_id);
        }
        return $season_id;
    }

    /**
     * 
     * @param int
     * @param array
     * @return object
     */
    public function getContractsForService($serviceId = NULL, $whereParams = array()) {
        $whereStr = '';
        if (!empty($whereParams) && array_key_exists('contract_id', $whereParams)) {
            $whereStr .= " AND id = '" . $whereParams['contract_id'] . "'";
        }
        return DB::select("select * from contracts where service_id = '" . $serviceId . "'" . $whereStr);
    }

    /**
     * 
     * @param int
     * @param array
     * @return object
     */
    public function getContractPeriodsForContracts($contractId = NULL, $whereParams = array()) {
        return DB::select("select * from contract_periods where contract_id = '" . $contractId . "'");
    }

    /**
     * 
     * @param array
     * @param object
     * @return int
     */
    private function isBetween($seasonPeriodArr, $contractPeriodObj) {

        $season_period_start = strtotime($seasonPeriodArr['season_period_start_date']);
        $season_period_end = strtotime($seasonPeriodArr['season_period_end_date']);
        $contract_period_start = strtotime($contractPeriodObj->start);
        $contract_period_end = strtotime($contractPeriodObj->end);
        $season_id = false;

        if (($season_period_start >= $contract_period_start) && ($season_period_end <= $contract_period_end)) {
            $seasonObj = DB::table('seasons')->where('contract_period_id', '=', $contractPeriodObj->id)->orderBy('id', 'desc')->first();
            $season_id = $seasonObj->id;
        }
        return $season_id;
    }

    /**
     * 
     * @param int
     * @return int
     */
    private function createNewContract($serviceId, $start_date, $end_date) {
        $ts_id = self::CONTRACT_TSID;
        $service_id = $serviceId;
        $start_date = date("jS M Y", strtotime($start_date));
        $end_date = date("jS M Y", strtotime($end_date));
        $name = self::CONTRACT_NAME . "($start_date - $end_date)";

        $contract_id = DB::table('contracts')->insertGetId(
                ['ts_id' => $ts_id, 'service_id' => $service_id, 'name' => $name]
        );
        return $contract_id;
    }

    /**
     * 
     * @param int
     * @param date
     * @return int
     */
    private function createNewContractPeriod($contractId, $startDate, $endDate) {
        $ts_id = self::CONTRACT_TSID;
        $contract_id = $contractId;
        $name = self::CONTRACT_PERIOD_NAME;
        $start = $startDate;
        $end = $endDate;

        $contract_period_id = DB::table('contract_periods')->insertGetId(
                ['ts_id' => $ts_id, 'contract_id' => $contract_id, 'name' => $name, 'start' => $start, 'end' => $end]
        );
        return $contract_period_id;
    }

    /**
     * 
     * @param int
     * @return int
     */
    private function createNewSeason($contractPeriodId) {
        $ts_id = self::CONTRACT_TSID;
        $contract_period_id = $contractPeriodId;
        $name = self::SEASON_NAME;

        $season_id = DB::table('seasons')->insertGetId(
                ['ts_id' => $ts_id, 'contract_period_id' => $contract_period_id, 'name' => $name]
        );
        return $season_id;
    }
    
    private function deleteOptions() {
        
        $delete_option_prices_arr = explode(',',$this->serviceInputData['delete_option_prices']);
        
        foreach($delete_option_prices_arr as $price_id) {
            $priceObj = DB::select("select prices.priceable_id as option_id, prices.season_period_id  as prices_season_period_id, prices.service_id as service_id, prices.currency_id as prices_currency_id, prices.meal_plan_id as prices_meal_plan_id, service_policies.id as service_policy_id, service_policies.charging_policy_id as charging_policy_id, week_prices.id as week_prices_id, policy_price_bands.id as policy_price_bands_id from prices left join service_policies on (service_policies.price_id = prices.id) left join week_prices on (week_prices.price_id = prices.id) left join policy_price_bands on (policy_price_bands.service_policy_id = service_policies.id ) left join meal_options on (meal_options.service_option_id = prices.priceable_id AND meal_options.season_period_id = prices.season_period_id) where prices.id = '".$price_id."' AND prices.priceable_type LIKE '%ServiceOption'");
            
            if(!empty($priceObj) && isset($priceObj->option_id)) {                            
                $option_id = $priceObj->option_id;
                $policy_id = $priceObj->charging_policy_id;
                $service_policy_id = $priceObj->service_policy_id;
            
//              MealOption::where('service_option_id', $option_id)->delete(); //delete query   
//              ServicePolicy::where('price_id', $price_id)->where('charging_policy_id', $policy_id)->delete(); //delete query   
//              Price::where('id', $price_id)->delete(); //delete query 
                
//                DB::table('meal_options')
//                    ->where('service_option_id', $option_id)
//                    ->update(['status' => 2]);//                
//                
//                DB::table('policy_price_bands')
//                    ->where('service_policy_id', $service_policy_id)
//                    ->update(['status' => 2]);
//                
//                DB::table('service_policies')
//                    ->where('price_id', $price_id)
//                    ->where('charging_policy_id', $policy_id)
//                    ->update(['status' => 2]);
//                    
//                DB::table('week_prices')
//                    ->where('price_id', $price_id)
//                    ->update(['status' => 2]);
//                
//                DB::table('prices')
//                    ->where('id', $price_id)
//                    ->update(['status' => 2]);
                
                
            }
       

        }
        
        
                
        
    }
    private function deleteExtras() {

        $delete_extra_prices_arr = explode(',',$this->serviceInputData['delete_extra_prices']);
        foreach($delete_extra_prices_arr as $price_id) {
            
            $priceObj = DB::select("select prices.priceable_id as extra_id, prices.season_period_id  as prices_season_period_id, prices.service_id as service_id, prices.currency_id as prices_currency_id, prices.meal_plan_id as prices_meal_plan_id, service_policies.id as service_policy_id, service_policies.charging_policy_id as charging_policy_id from prices left join service_policies on (service_policies.price_id = prices.id) left join week_prices on (week_prices.price_id = prices.id) left join policy_price_bands on (policy_price_bands.service_policy_id = service_policies.id ) where prices.id = '".$price_id."' AND prices.priceable_type LIKE '%ServiceExtra'");
                    
            if(!empty($priceObj) && isset($priceObj->option_id)) {
                $extra_id = $priceObj->extra_id;
                $policy_id = $priceObj->charging_policy_id;
                $service_policy_id = $priceObj->service_policy_id;

                //ServicePolicy::where('price_id', $price_id)->where('charging_policy_id', $policy_id)->delete(); //delete query   
                //Price::where('id', $price_id)->delete(); //delete query
                
//                DB::table('policy_price_bands')
//                    ->where('service_policy_id', $service_policy_id)
//                    ->update(['status' => 2]);
//                    
//                DB::table('service_policies')
//                    ->where('price_id', $price_id)
//                    ->where('charging_policy_id', $policy_id)
//                    ->update(['status' => 2]);
//                    
//                DB::table('week_prices')
//                    ->where('price_id', $price_id)
//                    ->update(['status' => 2]);
//                    
//                DB::table('prices')
//                    ->where('id', $price_id)
//                    ->update(['status' => 2]);
                
            }
            
        }
                
    }
    
    public function deleteWeekPrices() {
        $service_id = Input::get('service_id'); 
        $option_id = Input::get('option_id'); 
        $price_id = Input::get('price_id'); 
        $week_prices_id = Input::get('week_prices_id'); 
        $policy_price_bands_id = Input::get('policy_price_bands_id');            
        $isPriceBandOrWeekPrices = Input::get('isPriceBandOrWeekPrices');            
        $dataFor = Input::get('dataFor');    
        $seasonPeriodId = Input::get('seasonPeriodId');        
        
        $getWeekpricesData = $this->getWeekpricesData($service_id,$option_id,$seasonPeriodId,$dataFor);
        
        $pricesDataObj = DB::table('week_prices')
            ->where('price_id', $price_id)->get();       
        
        if(count($getWeekpricesData) > 1 && count($pricesDataObj) == 1) { 
            DB::table('prices')
            ->where('id', $price_id)
            ->update(['status' => 2]);
        }

        DB::table('week_prices')
            ->where('id', $week_prices_id)
            ->update(['status' => 2]);
        
        
        
        if(!empty($getWeekpricesData)) {
            return true;
        }
        return false;
        
    }
    public function deletePriceBands() {
        
        $service_id = Input::get('service_id'); 
        $option_id = Input::get('option_id'); 
        $price_id = Input::get('price_id'); 
        $week_prices_id = Input::get('week_prices_id'); 
        $policy_price_bands_id = Input::get('policy_price_bands_id');            
        $isPriceBandOrWeekPrices = Input::get('isPriceBandOrWeekPrices');            
        $dataFor = Input::get('dataFor');    
        $seasonPeriodId = Input::get('seasonPeriodId');    
        
        $getPriceBandsData = $this->getPriceBandsData($service_id,$option_id,$seasonPeriodId,$dataFor);
        
        $pricesDataObj = DB::table('service_policies')
            ->where('price_id', $price_id)->get();       
        
              
        if(count($getPriceBandsData) > 1 && count($pricesDataObj) == 1) {
            DB::table('prices')
            ->where('id', $price_id)
            ->update(['status' => 2]);
        }
        
        DB::table('policy_price_bands')
            ->where('id', $policy_price_bands_id)
            ->update(['status' => 2]);
                
        if(!empty($getPriceBandsData)) {
            return true;
        }
        return false;
    }

/////////////// service Data Add/edit/Delete -  End ///////////////////////

    public function getAllSeasonPeriodsForPerticularContracts($serviceId = NULL, $contractId = NULL) {
        $seasonPeriodArr = array();

        $serviceId = empty($serviceId) ? Input::get('service_id') : $serviceId;
        $contractId = empty($contractId) ? Input::get('contract_id') : $contractId;

        $contractPeriodObjArr = $this->getContractPeriodsForContracts($contractId);
        foreach ($contractPeriodObjArr as $contractPeriodObj) {
            $seasonObjArr = $this->getSeasonsForContractPeriods($contractPeriodObj->id);
            foreach ($seasonObjArr as $seasonObj) {
                $seasonPeriodObjArr = $this->getSeasonPeriodsForSeason($serviceId, $seasonObj->id);
                foreach ($seasonPeriodObjArr as $seasonPeriodObj) {
                    $seasonPeriodArr['seasonPeriods'][] = array(
                        'service_id' => $serviceId,
                        'contract_id' => $contractId,
                        'contract_period_id' => $contractPeriodObj->id,
                        'season_id' => $seasonObj->id,
                        'season_name' => $seasonObj->name,
                        'season_period_id' => $seasonPeriodObj->season_period_id,
                        'season_period_start' => $seasonPeriodObj->season_period_start_date,
                        'season_period_end' => $seasonPeriodObj->season_period_end_date,
                        'season_period_status' => $seasonPeriodObj->season_period_status
                    );
                    $seasonPeriodArr['seasonPeriodDates'][] = $seasonPeriodObj->season_period_start_date . " - " . $seasonPeriodObj->season_period_end_date;
                }
            }
        }

        $ajax_call = Input::get('ajax_call');
        if (!empty($ajax_call) && $ajax_call == 1) {
            return json_encode($seasonPeriodArr);
        }
        return $seasonPeriodArr;
    }

    public function getSeasonsForContractPeriods($contractPeriodId = NULL, $whereParams = array()) {
        $whereStr = '';
        if (!empty($whereParams) && array_key_exists('season_name', $whereParams)) {
            $whereStr .= " AND name = '" . $whereParams['season_name'] . "'";
        }
        return DB::select("select * from seasons where contract_period_id = '" . $contractPeriodId . "'" . $whereStr);
    }

    public function getSeasonPeriodsForSeason($service_id = NULL, $seasonId = NULL, $whereParams = array()) {

        $seasonPeriods = DB::table('season_periods')
                ->join('seasons', 'seasons.id', '=', 'season_periods.season_id')
                ->join('contract_periods', 'contract_periods.id', '=', 'seasons.contract_period_id')
                ->select('season_periods.id as season_period_id', 'season_periods.name as season_period_name', 'season_periods.season_id', 'season_periods.status as season_period_status', 'season_periods.start as season_period_start_date', 'season_periods.end as season_period_end_date', 'contract_periods.id as contract_period_id', 'contract_periods.contract_id as contract_id')
                ->where('season_periods.season_id', '=', $seasonId)
                ->get();


        return $seasonPeriods;
    }

    public function getAllSeasonPeriodsForPerticularService($serviceId = NULL) {
        $seasonPeriodArr = array();
        $serviceId = empty($serviceId) ? Input::get('service_id') : $serviceId;

        $contractObjArr = $this->getContractsForService($serviceId);
        foreach ($contractObjArr as $contractObj) {
            $contractPeriodObjArr = $this->getContractPeriodsForContracts($contractObj->id);
            $seasonPeriodArr['contract'][] = $this->getAllSeasonPeriodsForPerticularContracts($serviceId, $contractObj->id);
            foreach ($contractPeriodObjArr as $contractPeriodObj) {
                $seasonObjArr = $this->getSeasonsForContractPeriods($contractPeriodObj->id);
                foreach ($seasonObjArr as $seasonObj) {
                    $seasonPeriodObjArr = $this->getSeasonPeriodsForSeason($serviceId, $seasonObj->id);
                    foreach ($seasonPeriodObjArr as $seasonPeriodObj) {
                        $seasonPeriodArr['seasonPeriods'][] = array(
                            'service_id' => $serviceId,
                            'contract_id' => $contractObj->id,
                            'contract_period_id' => $contractPeriodObj->id,
                            'season_id' => $seasonObj->id,
                            'season_period_id' => $seasonPeriodObj->season_period_id,
                            'season_period_start' => $seasonPeriodObj->season_period_start_date,
                            'season_period_end' => $seasonPeriodObj->season_period_end_date,
                            'season_period_status' => $seasonPeriodObj->season_period_status
                        );
                        $seasonPeriodArr['seasonPeriodDates'][] = $seasonPeriodObj->season_period_start_date . " - " . $seasonPeriodObj->season_period_end_date;
                        $seasonPeriodArr['contractId'][] = $contractObj->id;
                        $seasonPeriodArr['contractPeriodId'][] = $contractPeriodObj->id;
                    }
                }
            }
        }

        if (!empty($seasonPeriodArr['contractId'])) {
            $seasonPeriodArr['contractId'] = array_unique($seasonPeriodArr['contractId']);
        }
        if (!empty($seasonPeriodArr['contractPeriodId'])) {
            $seasonPeriodArr['contractPeriodId'] = array_unique($seasonPeriodArr['contractPeriodId']);
        }

        $ajax_call = Input::get('ajax_call');
        if (!empty($ajax_call) && $ajax_call == 1) {
            return json_encode($seasonPeriodArr);
        }

        return $seasonPeriodArr;
    }

    public function getOptionsWithPriceForSeasonPeriod($serviceId = NULL, $seasonPeriodId = NULL, $seasonPeriodsArrObj = null, $whereParams = array()) {

        $dataArrObj = array();
        
        $str_where_params = '';
        if(!empty($whereParams)) {

            if(!empty($whereParams['from'])) {
                $str_where_params .= " AND prices.season_period_start BETWEEN '".$whereParams['from']."' AND '".$whereParams['to']."' ";
            }
            
            if(isset($whereParams['status']) && $whereParams['status'] != '') {
                $str_where_params .= " AND prices.status = '".$whereParams['status']."' ";
            } 
                        
        }

        $rawDataArrObj = DB::select("select service_options.id as option_id, service_options.ts_id as option_tsId, service_options.name as option_name, service_options.service_extra_id as mandatory_extra, service_options.multiple_service_extra_id as multiple_mandatory_extra, service_options.is_default as is_default, service_options.status as option_status, service_options.occupancy_id as occupancy_id, occupancies.name as occupancy_name, meal_options.meal_id as meal_plan_id, meals.name as meal_plan_name, prices.id as price_id, prices.buy_price as buy_price, prices.sell_price as sell_price, prices.margin as price_margin, prices.status as price_status, prices.currency_id as price_currency_id, currencies.code as currency_code, prices.meal_plan_id as price_meal_plan_id, prices.season_period_start as prices_season_period_start, prices.season_period_end as prices_season_period_end, charging_policies.name as policy_name, charging_policies.id as policy_id, policy_price_bands.id as policy_price_bands_id, policy_price_bands.service_policy_id as service_policy_id_price_band, policy_price_bands.price_band_id as price_band_id, price_bands.min as price_band_min, price_bands.max as price_band_max, (CASE WHEN price_bands.max > 0  AND policy_price_bands.status = 1 THEN 'YES' ELSE 'NO'END) AS PRICEBAND_EXISTS, (CASE WHEN (week_prices.monday =1 OR week_prices.tuesday =1 OR week_prices.wednesday =1 OR week_prices.thursday =1 OR week_prices.friday =1  OR week_prices.saturday =1 OR week_prices.sunday =1) AND week_prices.status =1 THEN 'YES' ELSE 'NO'END) AS WEEKDAYPRICES_EXISTS, week_prices.monday as week_prices_monday,week_prices.tuesday as week_prices_tuesday,week_prices.wednesday as week_prices_wednesday,week_prices.thursday as week_prices_thursday,week_prices.friday as week_prices_friday,week_prices.saturday as week_prices_saturday,week_prices.sunday as week_prices_sunday, week_prices.id as week_prices_id from occupancies, service_options join prices on (service_options.id = prices.priceable_id) Join service_policies on (service_policies.price_id = prices.id) join charging_policies on (service_policies.charging_policy_id = charging_policies.id) left join meal_options on (meal_options.service_option_id = service_options.id) left join meals on (prices.meal_plan_id = meals.id) left join policy_price_bands on (service_policies.id = policy_price_bands.service_policy_id) left join price_bands on (policy_price_bands.price_band_id = price_bands.id) left join week_prices on (week_prices.price_id = prices.id) left join currencies on (prices.currency_id = currencies.id) where service_options.service_id = '" . $serviceId . "' AND occupancies.id = service_options.occupancy_id AND prices.service_id = '" . $serviceId . "' AND service_options.id = prices.priceable_id and prices.season_period_id = '" . $seasonPeriodId . "' AND prices.priceable_type LIKE '%ServiceOption' $str_where_params group by service_options.id"); // remove group by if needed

    
        if (!empty($rawDataArrObj)) {
            foreach ($rawDataArrObj as $dataObj) {  
               
                
                if((int)$dataObj->option_status == 2) {
                    continue;
                }
                if((int)$dataObj->price_meal_plan_id > 0) {
                    $mealObj = DB::table('meals')
                                ->where('meals.id', '=', $dataObj->price_meal_plan_id)
                                ->get();
                    $dataObj->meal_plan_id = $mealObj[0]->id;
                    $dataObj->meal_plan_name = $mealObj[0]->name;
                }
                if (!empty($dataObj->week_prices_id) && !array_key_exists($dataObj->week_prices_id, $dataArrObj)) {
                    //$dataArrObj[$dataObj->week_prices_id] = $dataObj;
                    $obj_merged = (object) array_merge((array) $dataObj, (array) $seasonPeriodsArrObj);
                    $dataArrObj[$dataObj->price_id] = $obj_merged;
                } else if (empty($dataObj->week_prices_id) && !array_key_exists($dataObj->price_id, $dataArrObj)) {
                    //$dataArrObj[$dataObj->price_id] = $dataObj;
                    $obj_merged = (object) array_merge((array) $dataObj, (array) $seasonPeriodsArrObj);
                    $dataArrObj[$dataObj->price_id] = $obj_merged;
                }
                
            }
        }        
        return $dataArrObj;
    }

    public function getExtrasWithPriceForSeasonPeriod($serviceId = NULL, $seasonPeriodId = NULL, $seasonPeriodsArrObj = null, $whereParams = array()) {

        $dataArrObj = array();
        
        $str_where_params = '';
        if(!empty($whereParams)) {

            if(!empty($whereParams['from'])) {
                $str_where_params .= " AND prices.season_period_start BETWEEN '".$whereParams['from']."' AND '".$whereParams['to']."' ";
            }
            if(isset($whereParams['status']) && $whereParams['status'] != '') {
                $str_where_params .= " AND prices.status = '".$whereParams['status']."' ";
            }
        }
        


        // price band + weekday prices => cross check for TSID = 1242
        $rawDataArrObj = DB::select("select service_extras.id as extra_id, service_extras.ts_id as extra_tsId, service_extras.name as extra_name, service_extras.mandatory as extra_is_mandatory, service_extras.status as extra_status, prices.id as price_id, prices.buy_price as buy_price, prices.sell_price as sell_price, prices.margin as price_margin,  prices.season_period_id, prices.status as price_status, prices.currency_id as price_currency_id, currencies.code as currency_code, prices.season_period_start as prices_season_period_start, prices.season_period_end as prices_season_period_end, charging_policies.name as policy_name, charging_policies.id as policy_id, policy_price_bands.id as policy_price_bands_id, policy_price_bands.service_policy_id as service_policy_id_price_band, policy_price_bands.price_band_id as price_band_id, price_bands.min as price_band_min, price_bands.max as price_band_max, (CASE WHEN price_bands.max > 0 AND policy_price_bands.status = 1 THEN 'YES' ELSE 'NO'END) AS PRICEBAND_EXISTS, (CASE WHEN (week_prices.monday =1 OR week_prices.tuesday =1 OR week_prices.wednesday =1 OR week_prices.thursday =1 OR week_prices.friday =1  OR week_prices.saturday =1 OR week_prices.sunday =1 ) AND week_prices.status =1 THEN 'YES' ELSE 'NO'END) AS WEEKDAYPRICES_EXISTS, week_prices.monday as week_prices_monday,week_prices.tuesday as week_prices_tuesday,week_prices.wednesday as week_prices_wednesday,week_prices.thursday as week_prices_thursday,week_prices.friday as week_prices_friday,week_prices.saturday as week_prices_saturday,week_prices.sunday as week_prices_sunday, week_prices.id as week_prices_id from service_extras join prices on (service_extras.id = prices.priceable_id) Join service_policies on (service_policies.price_id = prices.id) join charging_policies on (service_policies.charging_policy_id = charging_policies.id) left join policy_price_bands on (service_policies.id = policy_price_bands.service_policy_id) left join price_bands on (policy_price_bands.price_band_id = price_bands.id) left join week_prices on (week_prices.price_id = prices.id) left join currencies on (prices.currency_id = currencies.id) where service_extras.service_id = '" . $serviceId . "' AND prices.service_id = '" . $serviceId . "' AND prices.season_period_id = '" . $seasonPeriodId . "' AND prices.priceable_type LIKE '%ServiceExtra' $str_where_params group by service_extras.id order by service_extras.id,prices.id");
        
        if (!empty($rawDataArrObj)) {
            foreach ($rawDataArrObj as $dataObj) {
                if((int)$dataObj->extra_status == 2) {
                    continue;
                }
                $obj_merged = (object) array_merge((array) $dataObj, (array) $seasonPeriodsArrObj);
                //$dataArrObj[$dataObj->price_id] = $obj_merged;
                $dataArrObj[] = $obj_merged;
            }
        }


        return $dataArrObj;
    }

    public function getServiceIdFromTSID($service_ts_id) {
        $ajax_call = Input::get('ajax_call');

        $servicesObj = DB::table('services')->where('ts_id', '=', $service_ts_id)->get();
        $services_id = $servicesObj[0]->id;

        return $services_id;
    }

    public function bulkUploadServiceDataWithCSV() {
    /*    
        $destinationPath = app_path()."/../FilesForOpertaions/"; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
        $fileName = 'upload_service_data_n.csv'; // renameing image
        Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
        
        $argv[1] = app_path()."/../FilesForOpertaions/upload_service_data_n.csv";
        
*/
        $argv[1] = app_path()."/../FilesForOpertaions/service_price_with_weekday_India_29thMarch2016.csv";
        $argv[1] = app_path()."/../FilesForOpertaions/service_price_with_weekday_India_11thMay2016.csv";
        $argv[1] = app_path()."/../FilesForOpertaions/service_price_with_weekday_India_11thMay2016_week_prices.csv";
        $rows = array_map('str_getcsv', file( $argv[1] ));


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
//            mysqli_real_escape_string($escapestr)
            
            
                    
            $region = trim($row["REGIONNAME"]);
            
            $serviceId = trim($row["SERVICEID"]);
            $serviceName = trim($row["SERVICELONGNAME"]);
            $serviceType = trim($row["SERVICETYPENAME"]);
            $supplierId = trim($row["SUPPLIERID"]);
            $supplierName = trim($row["SUPPLIERNAME"]);
            $mealName = trim($row["MEALPLANNAME"]);
            $optionId = trim($row["OPTIONID"]);
            $optionName = trim($row["OPTIONNAME"]);
            $extraId = trim($row["EXTRAID"]);
            $extraName = trim($row["EXTRANAME"]);
            $occupancyId = trim($row["OCCUPANCYTYPEID"]);
            $occupancyName = trim($row["OCCUPANCYTYPENAME"]);
            $policyId = trim($row["CHARGINGPOLICYID"]);
            $policyName = trim($row["CHARGINGPOLICYNAME"]);
            $seasonId = trim($row["SEASONTYPEID"]);
            $seasonName = trim($row["SEASONTYPENAME"]);
            $seasonStart = trim($row["SEASONSTARTDATE"]);
            $seasonEnd = trim($row["SEASONENDDATE"]);
            $contractId = trim($row["ORGANISATIONSUPPLIERCONTRACTID"]);
            $contractName = trim($row["ORGANISATIONSUPPLIERCONTRACTNAME"]);
            $contractPeriodId = trim($row["CONTRACTDURATIONID"]);
            $contractPeriodName = trim($row["CONTRACTDURATIONNAME"]);
            $contractStart = trim($row["CONTRACTDURATIONSTARTDATE"]);
            $contractEnd = trim($row["CONTRACTDURATIONENDDATE"]);
            $currency = trim($row["CURRENCYISOCODE"]);

            

            
            if (array_key_exists("WEEKDAYPRICES_EXISTS", $row)) {
                $weekdayPrice = trim($row["WEEKDAYPRICES_EXISTS"]);
                $monday = trim($row["PRICEDAYMONDAY"]);
                $tuesday = trim($row["PRICEDAYTUESDAY"]);
                $wednesday = trim($row["PRICEDAYWEDNESDAY"]);
                $thursday = trim($row["PRICEDAYTHURSDAY"]);
                $friday = trim($row["PRICEDAYFRIDAY"]);
                $saturday = trim($row["PRICEDAYSATURDAY"]);
                $sunday = trim($row["PRICEDAYSUNDAY"]);
            }

            $buyPrice = trim($row["BUYPRICE"]);
            $margin = trim($row["MARGIN"]);
            $sellPrice = trim($row["SELLING"]);

            // Priceband details
            if (array_key_exists("PRICEBANDMIN", $row)) {
                $minPriceBand = trim($row["PRICEBANDMIN"]);
                $maxPriceBand = trim($row["PRICEBANDMAX"]);
                $buyPrice = trim($row["BUYPRICE"]);
                $sellPrice = trim($row["SELLING"]);
            }

            $buyPrice = round($buyPrice, 2);
            $sellPrice = round($sellPrice, 2);

            $optionStatus = ((isset($row["Option-status"]) && ($row["Option-status"] == "Unavailable")) ? 0 : 1);

            print('<xmp>');
            print_r($row);
            print('</xmp>');
            

            
            $serviceTypeObj = ServiceType::firstOrCreate(array('name' => $serviceType));            
            $currencyObj = Currency::firstOrCreate(array('code' => $currency));
            $regionObj = Region::firstOrCreate(array('name' => $region));
            
            
            //$supplierObj = $regionObj->suppliers()->firstOrCreate(array('name' => $supplierName, 'ts_id' => $supplierId));
            
            $supplierObj = Supplier::where('ts_id', $supplierId)->where('region_id', $regionObj->id)->first();
            if (empty($supplierObj)) { // Add
                $supplierObj = $regionObj->suppliers()->create(array('name' => $supplierName, 'ts_id' => $supplierId));
            } else { // Edit    
                $supplierParams = array('name' => $supplierName);
                foreach ($supplierParams as $key => $value) {
                    $supplierObj->$key = $value;
                }
                $supplierObj->save();
            }
            
            
        

            if ($occupancyId) {
                // $occupancyObj = Occupancy::firstOrCreate(array('id' => $occupancyId, 'name' => $occupancyName));
                //$occupancyObj = Occupancy::firstOrCreate(array('id' => $occupancyId));
                $occupancyObj = Occupancy::where('id', $occupancyId)->first();
            } else {
                $occupancyObj = Occupancy::find(14);
            }

            $mealObj = null;
            if ($mealName) {
                $mealObj = Meal::firstOrCreate(array('name' => $mealName));
            }

            // Find or Create Service
            $serviceParams = array('ts_id' => $serviceId,
                                    'name' => trim($serviceName),
                                    'region_id' => $regionObj->id,
                                    //'currency_id' => $currencyObj->id,
                                    'service_type_id' => $serviceTypeObj->id,
                                    'supplier_id' => $supplierObj->id
                                ); 
            //$serviceObj = Service::firstOrCreate( $serviceParams );
            
            $serviceObj = Service::where('ts_id', $serviceId)->first();
            if (empty($serviceObj)) { // Add
                $serviceObj = Service::create( $serviceParams );
            } else { // Edit    
                
                foreach ($serviceParams as $key => $value) {
                    $serviceObj->$key = $value;
                }
                $serviceObj->save();
            }
            

            // Find or Create Policies
            $policyObj = null;
            if ($policyId) {
                
                $roomBased = 0;
                $dayDuration = 1;
                if (preg_match("/room|unit/i", $policyName)) {
                    $roomBased = 1;
                }

                if( preg_match('!\d+!', $policyName, $matches)){
                    $dayDuration = $matches[0];
                }
                
                $policyParams = array('ts_id' => $policyId,
                                      'name' => $policyName,
                                      'room_based' => $roomBased, 
                                      'day_duration' => $dayDuration);
                
                $policyObj = ChargingPolicy::where('ts_id', $policyId)->first();
                if (empty($policyObj)) {                    
                    $policyObj = ChargingPolicy::create( $policyParams );
                } else {
                    foreach ($policyParams as $key => $value) {
                        $policyObj->$key = $value;
                    }
                    $policyObj->save();
                }
            }

            // Find or Create Price Bands
            $priceBandObj = null;
            if (isset($minPriceBand)) {
                $priceBandParams = array('min' => $minPriceBand, 'max' => $maxPriceBand);
                $priceBandObj = PriceBand::firstOrCreate( $priceBandParams );
            }

            
            // Find or Create Contracts
            //$contractObj = $serviceObj->contracts()->firstOrCreate(array('ts_id' => $contractId, 'name' => $contractName));
            $contractParams = array('ts_id' => $contractId, 'name' => $contractName, 'service_id' => $serviceObj->id);
            $contractObj = Contract::where('ts_id', $contractId)->where('service_id', $serviceObj->id)->first();
            if (empty($contractObj)) {                    
                $contractObj = Contract::create( $contractParams );
            } else {
                foreach ($contractParams as $key => $value) {
                    $contractObj->$key = $value;
                }
                $contractObj->save();
            }
            

            $contractPeriodParams = array( 'ts_id' => $contractPeriodId, 'name' => $contractPeriodName, 'start' =>  date("Y/m/d", strtotime($contractStart)), 'end' => date("Y/m/d", strtotime($contractEnd)), 'contract_id' => $contractObj->id );
            //$contractPeriodObj = $contractObj->contractPeriods()->firstOrCreate( $contractPeriodParams );
            
            $contractPeriodObj = ContractPeriod::where('ts_id', $contractPeriodId)->where('contract_id', $contractObj->id)->first();
            if (empty($contractPeriodObj)) {                    
                $contractPeriodObj = ContractPeriod::create( $contractPeriodParams );
            } else {
                foreach ($contractPeriodParams as $key => $value) {
                    $contractPeriodObj->$key = $value;
                }
                $contractPeriodObj->save();
            }

            // Find or Create Season
            //$seasonObj = $contractPeriodObj->seasons()->firstOrCreate(array('ts_id' => $seasonId, 'name' => $seasonName));
            $seasonParams = array('ts_id' => $seasonId, 'name' => $seasonName, 'contract_period_id' => $contractPeriodObj->id );
            $seasonObj = Season::where('ts_id', $seasonId)->where('contract_period_id', $contractPeriodObj->id )->first();
            if (empty($seasonObj)) {                    
                $seasonObj = Season::create( $seasonParams );
            } else {
                foreach ($seasonParams as $key => $value) {
                    $seasonObj->$key = $value;
                }
                $seasonObj->save();
            }
            
         
            $seasonPeriodParams = array( 'start' =>  date("Y/m/d", strtotime($seasonStart)), 'end' => date("Y/m/d", strtotime($seasonEnd)), 'season_id' => $seasonObj->id);
            //$seasonPeriodObj = $seasonObj->seasonPeriods()->firstOrCreate( $seasonPeriodParams );
            $seasonPeriodObj = SeasonPeriod::firstOrCreate( $seasonPeriodParams );
            
            //die('2346');   
            // Find or Create Service Extras
            $extraObj = null;
            if ($extraId) {
                $extraParams = array('name' => $extraName, 'ts_id' => $extraId, 'service_id' => $serviceObj->id);
                //$extraObj = $serviceObj->serviceExtras()->firstOrCreate( $extraParams );
                $extraObj = ServiceExtra::where('ts_id', $extraId)->where('service_id', $serviceObj->id )->first();
                if (empty($extraObj)) {                    
                    $extraObj = ServiceExtra::create( $extraParams );
                } else {
                    foreach ($extraParams as $key => $value) {
                        $extraObj->$key = $value;
                    }
                    $extraObj->save();
                }
            }

            // Find Or Create Service Option
            $optionObj = null;
            if ($optionId) {
                $serviceOptionParams = array('occupancy_id' => $occupancyObj->id,
                                        'name' => $optionName,
                                        'ts_id' => $optionId,
                                        'status' => $optionStatus,
                                        'service_id' => $serviceObj->id
                                    );
                //$optionObj = $serviceObj->serviceOptions()->firstOrCreate( $serviceOptionParams );
                $optionObj = ServiceOption::where('ts_id', $optionId)->where('service_id', $serviceObj->id )->first();
                if (empty($optionObj)) {                    
                    $optionObj = ServiceOption::create( $serviceOptionParams );
                } else {
                    foreach ($serviceOptionParams as $key => $value) {
                        $optionObj->$key = $value;
                    }
                    $optionObj->save();
                }

                // Find or Create Meal Option
                if ($mealObj) {
                    $mealOptionParams = array('service_option_id' => $optionObj->id,
                                        'meal_id' => $mealObj->id,
                                        'season_period_id' => $seasonPeriodObj->id
                                    );
                    //$optionObj->mealOptions()->firstOrCreate( ['meal_id' => $mealObj->id] );
                    $mealOptionObj = MealOption::where('service_option_id', $optionObj->id)->where('season_period_id', $seasonPeriodObj->id )->first();
                    if (empty($mealOptionObj)) {                    
                        $mealOptionObj = MealOption::create( $mealOptionParams );
                    } else {
                        foreach ($mealOptionParams as $key => $value) {
                            $mealOptionObj->$key = $value;
                        }
                        $mealOptionObj->save();
                    }
                }
            }

            // Find or Create Prices
            $priceParams = array('season_period_id' => $seasonPeriodObj->id,   
                                 'currency_id' => $currencyObj->id,                                 
                                 'season_period_start' => $seasonPeriodObj->start,
                                 'season_period_end' => $seasonPeriodObj->end,
                                 'service_id' => $serviceObj->id
                                );

            $priceObj = null;
            if ($extraObj) {
                
                $priceParams = array_merge($priceParams,array('priceable_id' => $extraObj->id));
                
                //$priceObj = $extraObj->prices()->firstOrCreate( $priceParams );
                
                $priceObj = Price::where($priceParams)->first();
                if (empty($priceObj)) {                     
                    $priceParams = array_merge($priceParams,array('priceable_id' => $extraObj->id,
                                 'priceable_type' => 'App\Models\ServiceExtra','buy_price' => $buyPrice,'sell_price' => $sellPrice));
                    $priceObj = Price::create( $priceParams );
                } else {
                    $priceParams = array_merge($priceParams,array('margin' => '','buy_price' => $buyPrice,'sell_price' => $sellPrice));  
                    foreach ($priceParams as $key => $value) {
                        $priceObj->$key = $value;
                    }
                    $priceObj->save();
                }
                    
                /*
                try {
                    $priceObj = $extraObj->prices()->firstOrCreate( $priceParams );
                } catch (Exception $exc) {
                    $priceObj = $extraObj->prices()->where('season_period_id', $seasonPeriodObj->id)->where('service_id', $serviceObj->id)->where('buy_price', round($buyPrice, 2))->where('sell_price', round($sellPrice, 2))->first();
                }*/

            } elseif ($optionObj) {
                //$priceObj = $optionObj->prices()->firstOrCreate( $priceParams );
                
                $priceParams = array_merge($priceParams,array('priceable_id' => $optionObj->id));
                
                //$priceObj = $extraObj->prices()->firstOrCreate( $priceParams );
                
                $priceObj = Price::where($priceParams)->first();
                if (empty($priceObj)) {                     
                    $priceParams = array_merge($priceParams,array('priceable_id' => $optionObj->id,
                                 'priceable_type' => 'App\Models\ServiceOption','buy_price' => $buyPrice,'sell_price' => $sellPrice));
                    $priceObj = Price::create( $priceParams );
                } else {
                    $priceParams = array_merge($priceParams,array('margin' => '','buy_price' => $buyPrice,'sell_price' => $sellPrice));  
                    foreach ($priceParams as $key => $value) {
                        $priceObj->$key = $value;
                    }
                    $priceObj->save();
                }
                
                /*
                try {
                    $priceObj = $optionObj->prices()->firstOrCreate( $priceParams );
                } catch (Exception $exc) {
                    $priceObj = $optionObj->prices()->where('season_period_id', $seasonPeriodObj->id)->where('service_id', $serviceObj->id)->where('buy_price', round($buyPrice, 2))->where('sell_price', round($sellPrice, 2))->first();

                }
                */
                
            }

            // Find or Create Service Policies
            $servicePolicyObj = null;
            if ($policyObj) {
                $servicePolicyParams = array('charging_policy_id' => $policyObj->id, 'price_id' => $priceObj->id);
                //$servicePolicyObj = $priceObj->servicePolicy()->firstOrCreate( $servicePolicyParams );
                
                $servicePolicyObj = ServicePolicy::where('price_id', $priceObj->id)->first();
                if (empty($servicePolicyObj)) { 
                    $servicePolicyObj = ServicePolicy::create( $servicePolicyParams );
                } else {                     
                    foreach ($servicePolicyParams as $key => $value) {
                        $servicePolicyObj->$key = $value;
                    }
                    $servicePolicyObj->save();
                }
                
            }

            // Find or Create Service Price Bands
            if ($priceBandObj && $servicePolicyObj) {
                $policyBandParams = array('price_band_id' => $priceBandObj->id,'service_policy_id' => $servicePolicyObj->id);
                //$servicePolicyObj->policyPriceBands()->firstOrCreate( $policyBandParams );
                
                $PolicyPriceBandObj = PolicyPriceBand::where('service_policy_id', $servicePolicyObj->id)->first();
                if (empty($PolicyPriceBandObj)) { 
                    $PolicyPriceBandObj = PolicyPriceBand::create( $policyBandParams );
                } else {                     
                    foreach ($policyBandParams as $key => $value) {
                        $PolicyPriceBandObj->$key = $value;
                    }
                    $PolicyPriceBandObj->save();
                }
            }

            // Week Prices
            if(isset($weekdayPrice) && $weekdayPrice === 'YES') {
                $weekParams = array('monday' => $monday,
                                    'tuesday' => $tuesday,
                                    'wednesday' => $wednesday, 
                                    'thursday' => $thursday,
                                    'friday' => $friday,
                                    'saturday' =>  $saturday,
                                    'sunday' => $sunday,
                                    'price_id' => $priceObj->id
                                );
                WeekPrice::firstOrCreate( $weekParams );
                
//                $weekPriceObj = WeekPrice::where($weekParams)->first();
//                if (empty($weekPriceObj)) { 
//                    $weekPriceObj = WeekPrice::create( $weekParams );
//                } else {                     
//                    foreach ($weekParams as $key => $value) {
//                        $weekPriceObj->$key = $value;
//                    }
//                    $weekPriceObj->save();
//                }
                
                
            }

            echo "Service ".$serviceObj->id." / ".$serviceObj->name." has been created...\n";
          }
         
    }

    public function bulkImportServiceDataInCSV() {

        $services = $this->getServiceData(NULL, NULL, true);
        $out = '';

        $csvHeaderArray = array('REGIONNAME', 'SERVICEID', 'SERVICELONGNAME', 'SERVICETYPENAME', 'SUPPLIERID', 'SUPPLIERNAME', 'MEALPLANNAME', 'OPTIONID', 'OPTIONNAME', 'EXTRAID', 'EXTRANAME', 'OCCUPANCYTYPEID', 'OCCUPANCYTYPENAME', 'CHARGINGPOLICYID', 'CHARGINGPOLICYNAME', 'SEASONTYPEID', 'SEASONTYPENAME', 'SEASONSTARTDATE', 'SEASONENDDATE', 'ORGANISATIONSUPPLIERCONTRACTID', 'ORGANISATIONSUPPLIERCONTRACTNAME', 'CONTRACTDURATIONID', 'CONTRACTDURATIONNAME', 'CONTRACTDURATIONSTARTDATE', 'CONTRACTDURATIONENDDATE', 'CURRENCYISOCODE', 'WEEKDAYPRICES_EXISTS', 'PRICEDAYMONDAY', 'PRICEDAYTUESDAY', 'PRICEDAYWEDNESDAY', 'PRICEDAYTHURSDAY', 'PRICEDAYFRIDAY', 'PRICEDAYSATURDAY', 'PRICEDAYSUNDAY', 'BUYPRICE', 'MARGIN', 'SELLING');
        foreach ($csvHeaderArray as $value) {
            $out .= '"' . $value . '",';
        }
        $out .= "\n";

        foreach ($services as $key => $service) {

            $region_name = $this->parseDateForCSV($service->region_name);
            $service_ts_id = $this->parseDateForCSV($service->ts_id);
            $service_name = $this->parseDateForCSV($service->service_name);
            $service_type_name = $this->parseDateForCSV($service->service_type);
            $supplier_id = $this->parseDateForCSV($service->supplier_tsid);
            $supplier_name = $this->parseDateForCSV($service->supplier_name);
            $meal_name = $this->parseDateForCSV($service->meal_name);
            $ts_option_id = $this->parseDateForCSV($service->ts_option_id);
            $option_name = $this->parseDateForCSV($service->option_name);
            $extra_ts_id = ''; //$this->parseDateForCSV($service->extra_tsid);
            $extra_name = ''; //$this->parseDateForCSV($service->extra_name);
            $occupancy_id = $this->parseDateForCSV($service->occupancy_id);
            $occupancy_name = $this->parseDateForCSV($service->occupancy_name);
            $policy_tsid = $this->parseDateForCSV($service->policy_tsid);
            $policy_name = $this->parseDateForCSV($service->policy_name);
            $season_type_id = $this->parseDateForCSV($service->ts_id);
            $season_type_name = $this->parseDateForCSV($service->season_name);
            $season_start_date = $this->parseDateForCSV($service->season_period_start);
            $season_end_date = $this->parseDateForCSV($service->season_period_end);
            $contract_ts_id = $this->parseDateForCSV($service->contract_tsid);
            $contract_name = $this->parseDateForCSV($service->contract_name);
            $contract_period_tsid = $this->parseDateForCSV($service->contract_periods_tsid);
            $contract_period_name = $this->parseDateForCSV($service->contract_period_name);
            $contract_period_start = $this->parseDateForCSV($service->contract_period_start);
            $contract_period_end = $this->parseDateForCSV($service->contract_period_end);
            $currency_code = $this->parseDateForCSV($service->currency_code);
            $week_prices_exists = ''; //$this->parseDateForCSV($service->week_prices_exists);
            $monday_prices = $this->parseDateForCSV($service->monday);
            $tuesday_prices = $this->parseDateForCSV($service->tuesday);
            $wednesday_price = $this->parseDateForCSV($service->wednesday);
            $thursday_price = $this->parseDateForCSV($service->thursday);
            $friday_price = $this->parseDateForCSV($service->friday);
            $saturday_price = $this->parseDateForCSV($service->saturday);
            $sunday_price = $this->parseDateForCSV($service->sunday);
            $buy_price = $this->parseDateForCSV($service->buy_price);
            $sell_price = $this->parseDateForCSV($service->sell_price);
            $margin = '1'; //$this->parseDateForCSV($service->sell_price);
            $minPriceBand = ''; //$this->parseDateForCSV($service->PRICEBANDMIN);
            $maxPriceBand = ''; //$this->parseDateForCSV($service->PRICEBANDMAX);

            $out .= '"' . $region_name . '",';
            $out .= '"' . $service_ts_id . '",';
            $out .= '"' . $service_name . '",';
            $out .= '"' . $service_type_name . '",';
            $out .= '"' . $supplier_id . '",';
            $out .= '"' . $supplier_name . '",';
            $out .= '"' . $meal_name . '",';
            $out .= '"' . $ts_option_id . '",';
            $out .= '"' . $option_name . '",';
            $out .= '"' . $extra_ts_id . '",';
            $out .= '"' . $extra_name . '",';
            $out .= '"' . $occupancy_id . '",';
            $out .= '"' . $occupancy_name . '",';
            $out .= '"' . $policy_tsid . '",';
            $out .= '"' . $policy_name . '",';
            $out .= '"' . $season_type_id . '",';
            $out .= '"' . $season_type_name . '",';
            $out .= '"' . $season_start_date . '",';
            $out .= '"' . $season_end_date . '",';
            $out .= '"' . $contract_ts_id . '",';
            $out .= '"' . $contract_name . '",';
            $out .= '"' . $contract_period_tsid . '",';
            $out .= '"' . $contract_period_name . '",';
            $out .= '"' . $contract_period_start . '",';
            $out .= '"' . $contract_period_end . '",';
            $out .= '"' . $currency_code . '",';
            $out .= '"' . $week_prices_exists . '",';
            $out .= '"' . $monday_prices . '",';
            $out .= '"' . $tuesday_prices . '",';
            $out .= '"' . $wednesday_price . '",';
            $out .= '"' . $thursday_price . '",';
            $out .= '"' . $friday_price . '",';
            $out .= '"' . $saturday_price . '",';
            $out .= '"' . $sunday_price . '",';
            //$out .= '"'.$minPriceBand.'",';
            //$out .= '"'.$maxPriceBand.'",';
            $out .= '"' . $buy_price . '",';
            $out .= '"' . $margin . '",';
            $out .= '"' . $sell_price . '"';




//            
//            
//    
//    // Priceband details
//    if (array_key_exists("PRICEBANDMIN", $row)) {
//	    $minPriceBand = $row["PRICEBANDMIN"];
//	    $maxPriceBand = $row["PRICEBANDMAX"];
//	    $buyPrice = $row["BUYPRICEBANDAMOUNT"];
//	    $sellPrice = $row["SELLINGPRICEBANDAMOUNT"];
//	}
            //$optionStatus = ((isset($row["Option-status"]) && ($row["Option-status"] == "Unavailable")) ? 0 : 1);
            //////////////////////////////////


            $out .= chr(10);
        }


        /*
         * while ($l = mssql_fetch_array($results, MSSQL_ASSOC)) {

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
          $out .= '"'.$value.'",';
          }
          $out .= chr(10);
          }
          mssql_free_result($results);
          mssql_close($db); */
// Output to browser with the CSV mime type
        header("Content-type: text/x-csv");
        header("Content-Disposition: attachment; filename=service_price_with_weekday_india_16Dec2015.csv");
        echo $out;
    }

    private function parseDateForCSV($value) {
        $value = str_replace('"', '\"', $value);
        $value = str_replace(chr(10), '', $value);
        $value = str_replace(chr(13), '', $value);
        $value = trim($value);
        return $value;
    }
    
    public function getUniqueRoomTypes($serviceId) {
        $serviceTypesArr = array('1');        
        $serviceOptions = DB::table('service_options')
                ->join('services', 'service_options.service_id', '=', 'services.id')
                ->join('service_types', 'service_types.id', '=', 'services.service_type_id')
                ->whereIn('service_types.id',$serviceTypesArr) 
                ->where('services.id','=',$serviceId) 
                ->select('services.id as service_id', 'services.ts_id as service_tsid', 'service_options.id as option_id', 'service_options.name as option_name', 'service_types.id as service_type_id', 'service_types.name as service_type')
                ->orderBy('option_name', 'asc')
                ->get();
        $option_name_arr = array();
        foreach($serviceOptions as $optionData) {
            $option_name = $optionData->option_name;
            $index = strpos($option_name,'(');
            $option_name_str = substr($option_name, 0, $index);
            $option_name_str = trim($option_name_str);
            if(!in_array($option_name_str,$option_name_arr)) {
               $option_name_arr[] = trim($option_name_str);
            }
           
        }
        return $option_name_arr;
    }
    
    public function getPriceBandsData($serviceId,$optionId,$seasonPeriodId,$dataFor='ServiceOption',$status=1) {       
        return DB::select("select prices.service_id as service_id, prices.`priceable_id` as option_id, prices.id as price_id, prices.buy_price , prices.sell_price, prices.margin as price_margin,  service_policies.id as service_policies_id, charging_policies.name as policy_name, charging_policies.id as policy_id, policy_price_bands.id as policy_price_bands_id, price_bands.id as price_bands_id, price_bands.min as price_bands_min, price_bands.max as price_bands_max  from prices,service_policies, charging_policies, policy_price_bands, price_bands  where prices.service_id = '".$serviceId."' and prices.priceable_id = '".$optionId."' and prices.priceable_type LIKE '%".$dataFor."' and service_policies.price_id = prices.id and service_policies.charging_policy_id = charging_policies.id and policy_price_bands.service_policy_id = service_policies.id and policy_price_bands.price_band_id = price_bands.id and prices.season_period_id = '".$seasonPeriodId."' and policy_price_bands.status = '".$status."' order by price_bands.min, price_bands.max");
       
    }
    public function getWeekpricesData($serviceId,$optionId,$seasonPeriodId,$dataFor='ServiceOption',$status=1) {
         
       return DB::select("select prices.service_id as service_id, prices.`priceable_id` as option_id, prices.id as price_id, prices.buy_price , prices.sell_price, prices.margin as price_margin, service_policies.id as service_policies_id, charging_policies.name as policy_name, charging_policies.id as policy_id, week_prices.id as week_prices_id, week_prices.monday as week_prices_monday,week_prices.tuesday as week_prices_tuesday,week_prices.wednesday as week_prices_wednesday,week_prices.thursday as week_prices_thursday,week_prices.friday as week_prices_friday,week_prices.saturday as week_prices_saturday,week_prices.sunday as week_prices_sunday from prices,service_policies, charging_policies, week_prices  where prices.service_id = '".$serviceId."' and prices.priceable_id = '".$optionId."' and prices.priceable_type LIKE '%".$dataFor."' and service_policies.price_id = prices.id and service_policies.charging_policy_id = charging_policies.id and prices.season_period_id = '".$seasonPeriodId."' and week_prices.price_id = prices.id and week_prices.status = '".$status."' order by week_prices_monday,week_prices_tuesday,week_prices_wednesday,week_prices_thursday,week_prices_friday,week_prices_saturday,week_prices_sunday ");
    }
    
    public function linkOptionsWithExtras() {
        $serviceId = Input::get('service_id');
        $option_page_no = Input::get('option_page_no');
        $extra_page_no = Input::get('extra_page_no');
        
        $options_date_range_from = Input::get('options_date_range_from');
        $options_date_range_to = Input::get('options_date_range_to');
        $prices_options_table_status = Input::get('prices_options_table_status');
        
        $extras_date_range_from = Input::get('extras_date_range_from');
        $extras_date_range_to = Input::get('extras_date_range_to');
        $prices_extras_table_status = Input::get('prices_extras_table_status');
        
        $option_id = Input::get('option_id');
        $link_extra_id = Input::get('link_extra_id');
        $link_extra_id = substr($link_extra_id,0, -1);        
        
        $option_id_arr = explode(',',$option_id);
        $link_extra_id_arr = explode(',',$link_extra_id);    
        $link_extra_id_arr = array_unique($link_extra_id_arr);    
        $link_extra_id = implode(',', $link_extra_id_arr);
               
        $link_operation = Input::get('link_operation');   
        
        foreach($option_id_arr as $k => $v) {       
           
            foreach($link_extra_id_arr as $k1 => $v1) {    
                
                if($link_operation == '0') {
                    
                    DB::table('service_options')
                            ->where('id', $option_id)
                            ->where('service_id', $serviceId)
                            ->update(['service_extra_id' => null]);
                                        
                    DB::table('service_extras')
                                ->where('id', $v1)
                                ->where('service_id', $serviceId)
                                ->update(['mandatory' => 0]);
                    
                    $tmpObj = DB::table('service_options')
                                ->where('id', $option_id)
                                ->where('service_id', $serviceId)
                                ->where('multiple_service_extra_id' , $link_extra_id)
                                ->get();
                    
                   
                    if(empty($tmpObj)) {
                        DB::table('service_options')
                                ->where('id', $option_id)
                                ->where('service_id', $serviceId)
                                ->update(['multiple_service_extra_id' => $link_extra_id]);
                    }
                    

                } else { 

                    DB::table('service_options')
                                ->where('id', $option_id)
                                ->where('service_id', $serviceId)
                                ->update(['service_extra_id' => $v1]);
                    
                    DB::table('service_extras')
                                ->where('id', $v1)
                                ->where('service_id', $serviceId)
                                ->update(['mandatory' => 1]);
                    
                    $tmpObj = DB::table('service_options')
                                ->where('id', $option_id)
                                ->where('service_id', $serviceId)
                                ->where('multiple_service_extra_id' , $link_extra_id)
                                ->get();
                    
                   
                    if(empty($tmpObj)) {
                        DB::table('service_options')
                                ->where('id', $option_id)
                                ->where('service_id', $serviceId)
                                ->update(['multiple_service_extra_id' => $link_extra_id]);
                    }
                    
                }
            }
        }
    }
       
    public function isDefaultOption($optionName) {
        $default_room_type = $this->serviceInputData['default_room_type'];
        
        $option_name = $optionName;
        $index = strpos($option_name,'(');
        $option_name_str = substr($option_name, 0, $index);
        
        if($option_name_str ===$default_room_type ) {
            return 'YES';
        } else {
            return 'NO';
        }
        
    }

    private function updateRegionTable() {
        //$regions = DB::table('regions_rates')->get();
        $regions = DB::table('regions')->get();
        foreach ($regions as $region) {
            $array1[] = $region->ts_id;
        }
        $regions_tmb = DB::table('region_tmb')->get();
        foreach ($regions_tmb as $region) {
            $array2[] = $region->region_tsid;
        }

        //$arr = array_intersect($array1, $array2);
        $arr = array_diff($array2, $array1);

        foreach ($arr as $reg) {
            $regions_tmb = DB::table('region_tmb')->where('region_tsid', '=', $reg)->get();
            //$regions = DB::table('regions_rates')->where('ts_id', '=', $regions_tmb[0]->region_parent_id)->get();
            $regions = DB::table('regions')->where('ts_id', '=', $regions_tmb[0]->region_parent_id)->get();
//            print('$regions_tmb : <xmp>');
//            print_r($regions_tmb);
//            print_r($regions);
//            print('</xmp>');
            //echo "<br>====================<br> insert into regions (ts_id, name, parent_id) values('".$regions_tmb[0]->region_tsid."','".$regions_tmb[0]->region_name."','".$regions[0]->id."');  <br><br>";
            echo "insert into regions (ts_id, name, parent_id) values('" . $regions_tmb[0]->region_tsid . "','" . trim($regions_tmb[0]->region_name) . "','" . $regions[0]->id . "');<br>";
        }

    }

    public function updateOptionsIsDefaultForAllOccupany() {
        $occupancyArr = array(2, 3);
        $optionsWithIsDefaultYes = DB::table('service_options')->where('is_default', '=', 'YES')->whereIn('occupancy_id', $occupancyArr)->get();
        foreach ($optionsWithIsDefaultYes as $optionWithIsDefaultYes) {
            $optionName = preg_replace('/\(Double\)|-Double/i', '', $optionWithIsDefaultYes->name);
            $optionsWithAboveOptionName = DB::table('service_options')->where('name', 'like', "$optionName%")->where('service_id', '=', $optionWithIsDefaultYes->service_id)->whereNotIn('occupancy_id', $occupancyArr)->get();


            foreach ($optionsWithAboveOptionName as $option) {
                if ($option->is_default == 'NO') {
                    DB::table('service_options')
                            ->where('id', $option->id)
                            ->update(['is_default' => 'YES', 'is_default_updated_outofCSV' => 1]);

                    echo "Is defult option updated for " . $option->name . "<br><br> \n ";
                }
            }
        }

        echo "All DONE !!!!! ";
    }

    private function populateMarginTablePerServicePerSeason() {
        // ==== for option

        $serviceArr = array('2780', '2781', '2782');

        $serviceData = DB::table('services')
                ->join('prices', 'prices.service_id', '=', 'services.id')
                ->join('season_periods', 'season_periods.id', '=', 'prices.season_period_id')
                /* ->whereIn('services.id',$serviceArr) */
                ->select('services.id as service_id', 'services.ts_id as service_tsid', 'services.currency_id as currency_id', 'prices.id as price_id', 'prices.season_period_id as season_period_id', 'season_periods.name as season_period_name', 'prices.margin')
                ->orderBy('season_period_id', 'asc')
                ->get();


        $count = 0;
        $prev_season_period_id = 0;
        $total_margin = 0;
        foreach ($serviceData as $service) {


            if (($prev_season_period_id == $service->season_period_id) || ($prev_season_period_id == 0)) {
                $prev_service_id = $service->service_id;
                $prev_season_period_id = $service->season_period_id;
                $prev_currency_id = $service->currency_id;
                $total_margin += $service->margin;
                $count++;
            } else {

                try {
                    if ($count == 0) {
                        $count = 1;
                    }
                    $avg_margin = $total_margin / ($count);
                    $avg_margin = round($avg_margin, 4);
                    $marginParams = array(
                        'service_id' => $prev_service_id,
                        'season_period_id' => $prev_season_period_id,
                        'currency_id' => $prev_currency_id,
                        'margin' => $avg_margin,
                        'premium' => '0.0000'
                    );

                    $marginObj = Margins::firstOrCreate($marginParams);

                    echo "OPTION - margin and currency updated for season period id " . $prev_season_period_id . " for Service Id : " . $prev_service_id . "<br>\n ";

                    $prev_season_period_id = $service->season_period_id;
                    $prev_service_id = $service->service_id;
                    $prev_currency_id = $service->currency_id;

                    $count = 0;
                    $total_margin = 0;
                } catch (Exception $err) {
                    throw $err;
                }
            }

//            print('<xmp>');
//            print_r($service);
//            print('</xmp>');
        }


        /// for last record - start
        if (1) {
            try {
                if ($count == 0) {
                    $count = 1;
                }
                $avg_margin = $total_margin / ($count);
                $avg_margin = round($avg_margin, 4);
                $marginParams = array(
                    'service_id' => $prev_service_id,
                    'season_period_id' => $prev_season_period_id,
                    'currency_id' => $prev_currency_id,
                    'margin' => $avg_margin,
                    'premium' => '0.0000'
                );

                $marginObj = Margins::firstOrCreate($marginParams);
                echo "OPTION - margin and currency updated for season period id " . $prev_season_period_id . " for Service Id : " . $prev_service_id . "<br>\n ";
            } catch (Exception $err) {
                throw $err;
            }
        }
        /// for last record -  end

        echo "All DONE !!!!! ";
    }
    
    private function getAllFastBuildIds() {
        $servicesObj = DB::table('services')->where('ts_id', '>', '499999')->get();
        foreach($servicesObj as $services) {
            $fastBuildArr[] = $services->ts_id;
        }
        
        print('<xmp>');
        print_r(json_encode($fastBuildArr));
        print('</xmp>');
        die('2418');
        
        
        $argv[1] = "/var/www/html/tmbratesapi/Options_iNactive.csv";

        if( !isset( $argv[1] ) ){
            echo "Expecting CSV File\n";
            echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
            exit;
        }
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            if(count($row) != count($header)) {        
                continue;
            }
            $csv[] = array_combine($header, $row);
        }
        $count = 0;
        foreach($csv as $row) {
                if(!is_array($row)) {
                   continue; 
                }
                $serviceTsId = trim($row["SERVICEID"]);
                $serviceOptionsTSid = trim($row["SERVICEOPTIONINSERVICEID"]);
                echo $serviceTsId." => ".$serviceOptionsTSid.'<br>';
//                $serviceTsId_arr[] = $serviceTsId;
//                $serviceOptionsTSid[] = $serviceOptionsTSid;
                $service_options = DB::table('service_options')
                        ->join('services', 'services.id', '=', 'service_options.service_id')
                        ->select('service_options.id as options_id', 'service_options.ts_id  as options_tsid', 'services.id  as service_id', 'services.ts_id  as service_tsid')
                        ->where('service_options.ts_id', '=', $serviceOptionsTSid)
                        ->where('services.ts_id', '=', $serviceTsId)
                        ->where('services.id', '=', 'service_options.service_id')
                        ->get();
                
                //select `service_options`.`id` as `options_id`, `service_options`.`ts_id` as `as`, `services`.`id` as `as`, `services`.`ts_id` as `as` from `service_options` inner join `services` on `services`.`id` = `service_options`.`service_id` where `service_options`.`ts_id` = 4390 and `services`.`ts_id` = 1440 and `services`.`id` = service_options.service_id
                
                $queries = DB::getQueryLog();
                $last_query = end($queries);

                print('<xmp>');
                print_r($last_query);
                print('</xmp>');
                
                //die('24566666');
//                if(empty($service_options)) {
////                    print_r($row);
////                    die('45');
//                } else {
//                    $count++;
//                }

        //        if($option->is_default == 'NO') {
        //            DB::table('service_options')
        //                ->where('id', $option->id)
        //                ->update(['is_default' => 'YES','is_default_updated_outofCSV' => 1]);
        //            echo "Is defult option updated for ".$option->name." \n ";
        //        }     
        }

        echo 'Count : '.$count.'<br>';
        die('lin no 30');
        
    }
    
    public function deleteServicesPermanently() {
   
        //$argv[1] = "/var/www/html/tmbratesapi/Changes_after_March_1st_in_TS-Reupload.csv";
        $argv[1] = app_path()."/../FilesForOpertaions/Changes_after_March_1st_in_TS-Reupload.csv";
        $argv[1] = app_path()."/../FilesForOpertaions/xdelete_servics.csv";
        
        
        $destinationPath = app_path()."/../FilesForOpertaions/"; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
        $fileName = 'xdelete_servics_n.csv'; // renameing image
        Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
        
        $argv[1] = app_path()."/../FilesForOpertaions/xdelete_servics_n.csv";
        

        if( !isset( $argv[1] ) ){
            echo "Expecting CSV File\n";
            echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
            exit;
        }
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            if(count($row) != count($header)) {        
                continue;
            }
            $csv[] = array_combine($header, $row);
        }

        $str_service_ts_id = '';
        $count = 0;
        foreach($csv as $row) {
            if(!is_array($row)) {
               continue; 
            }
            
            $service_ts_id = $row['SERVICEID'];
            $str_service_ts_id .= $service_ts_id.",";
            $servicesObj = DB::table('services')->where('ts_id', '=', $service_ts_id)->get();
            if(!empty($servicesObj)) {
                DB::beginTransaction(); //Start transaction!
                try {
                    
                    $services_id = $servicesObj[0]->id;
                    $service_id = $services_id;                

                    $service_options = DB::table('service_options')->where('service_id', '=', $service_id)->get();
                    foreach($service_options as $service_option){                       
                        $meal_options = DB::table('meal_options')->where('service_option_id', '=', $service_option->id)->delete();
                        $service_options = DB::table('service_options')->where('id', '=', $service_option->id)->delete();
                    }
                    
                    $service_extras = DB::table('service_extras')->where('service_id', '=', $service_id)->delete();
                    $prices = DB::table('prices')->where('service_id', '=', $service_id)->get();
                    foreach($prices as $price) {
                        $service_policies = DB::table('service_policies')->where('price_id', '=', $price->id)->get();
                        foreach($service_policies as $service_policy) {
                            $policy_price_bands = DB::table('policy_price_bands')->where('service_policy_id', '=', $service_policy->id)->get();
                            DB::table('service_policies')->where('id', '=', $service_policy->id)->delete();
                        }
                        DB::table('week_prices')->where('price_id', '=', $price->id)->delete();
                        DB::table('prices')->where('id', '=', $price->id)->delete();
                    }

                    $contracts = DB::table('contracts')->where('service_id', '=', $service_id)->get();
                    foreach($contracts as $contract) {            
                        $contract_periods = DB::table('contract_periods')->where('contract_id', '=', $contract->id)->get();
                        foreach($contract_periods as $contract_period) {
                            $seasons = DB::table('seasons')->where('contract_period_id', '=', $contract_period->id)->get();
                            foreach($seasons as $season) {
                                $season_periods = DB::table('season_periods')->where('season_id', '=', $season->id)->get();
                                foreach($season_periods as $season_period) {
                                    DB::table('season_periods')->where('id', '=', $season_period->id)->delete();
                                }                    
                                DB::table('seasons')->where('id', '=', $season->id)->delete();
                            }                
                            DB::table('contract_periods')->where('id', '=', $contract_period->id)->delete();                
                        }
                        DB::table('contracts')->where('id', '=', $contract->id)->delete();
                    }  
                    
                    DB::table('services')->where('ts_id', '=', $service_ts_id)->delete();
                    
                } catch (Exception $ex) {
                    //failed logic here
                    DB::rollback();
                    throw $ex;
                }
                DB::commit();
                
                echo "Service Id : ".$service_ts_id.' deleted <br>';
            }
            
        }
      
        $str_service_ts_id = substr($str_service_ts_id,0,-1);
        $tmp_arr =  explode(',',$str_service_ts_id);
        
        echo "<br><br>total count : ".count($tmp_arr)."<br><br>";
        echo "<br><br>".$str_service_ts_id."<br><br>";
    }
    
    public function updateExchangeRatesFromCSV() {
   
        $destinationPath = app_path()."/../FilesForOpertaions/"; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
        $fileName = 'update_exchange_rates_n.csv'; // renameing image
        Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
              
        $argv[1] = app_path()."/../FilesForOpertaions/update_exchange_rates_n.csv";

        if( !isset( $argv[1] ) ){
            echo "Expecting CSV File\n";
            echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
            exit;
        }
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            if(count($row) != count($header)) {        
                continue;
            }
            $csv[] = array_combine($header, $row);
        }
        
        $str_service_ts_id = '';
        $count = 0;
        $str_update = '';
        $str_insert = '';
        $count_insert = 0;
        $count_update = 0;
        foreach($csv as $row) {
            if(!is_array($row)) {
               continue; 
            }           
//            $count++;
//            if($count > 1) {
//                break;
//            }
            
            if(!empty($row)) {
                DB::beginTransaction(); //Start transaction!
                
               try {
                                      
                    $from_currency = $row['Service Currency'];
                    $to_currency = $row['Guest Currency'];
                    $new_rate = $row['Exchange Rate in TS'];
                    
                    $exchangeRatesObj = DB::table('exchange_rates')->where('from_currency', '=', $from_currency)->where('to_currency', '=', $to_currency)->get();
            
                   if(!empty($exchangeRatesObj)) {
                       $exchange_rates = DB::table('exchange_rates')->where('from_currency', '=', $from_currency)->where('to_currency', '=', $to_currency)->update(['rate' => $new_rate]);
                       $str_update .= $from_currency . " => ". $to_currency ." updated. <br>";
                       $count_update++;
                   } else {
                        $exchangeRates_params = array(
                            'from_currency' => $from_currency,
                            'to_currency' => $to_currency,
                            'rate' => $new_rate,
                            'status' => 1
                            );
 
                        $exchangeRatesObj = ExchangeRate::firstOrCreate($exchangeRates_params); 
                        $str_insert .= $from_currency . " => ". $to_currency ." inserted. <br>";
                        $count_insert++;
                   }
                  
               } catch (Exception $ex) {
                    //failed logic here
                    DB::rollback();
                    throw $ex;
                }
                DB::commit();
            }
            
        }
        
        echo "<br><br> $count_insert - New currencies inserted<br>$str_insert<br><br>";
        echo "<br><br> ========================================= <br><br>";
        echo "<br><br> $count_update - New currencies updated<br>$str_update<br><br>";
    }    
    
    public function optionsExtraMapping() {
             
        $destinationPath = app_path()."/../FilesForOpertaions/"; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
        $fileName = 'options_extra_mapping_n.csv'; // renameing image
        Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
              
        $argv[1] = app_path()."/../FilesForOpertaions/options_extra_mapping_n.csv";     
        
        if( !isset( $argv[1] ) ){
            echo "Expecting CSV File\n";
            echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
            exit;
        }
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            if(count($row) != count($header)) {        
                continue;
            }
            $csv[] = array_combine($header, $row);
        }
        $count = 0;
        foreach($csv as $row) {
            if(!is_array($row)) {
               continue; 
            }

            $options_tsid = trim($row["options_tsid"]);
            $extra_tsid = trim($row["extra_tsid"]);

            $service_options = DB::select("select service_options.id as options_id, service_options.ts_id as options_tsid from service_options where service_options.ts_id = '".$options_tsid."'");
            $service_extras = DB::select("select service_extras.id as extras_id, 	service_extras.ts_id as extras_tsid from service_extras where service_extras.ts_id = '".$extra_tsid."'");

            if(!empty($service_options[0]->options_id) && !empty($service_extras[0]->extras_id)) {
                $option_id = $service_options[0]->options_id;
                $extra_id = $service_extras[0]->extras_id;
                //$extra_id = 0;
                $sstr = "update service_options set service_extra_id = '".$extra_id."' where id = '".$option_id."';";
                echo $sstr.'<br>';

                DB::table('service_options')
                    ->where('id', $option_id)
                    ->update(['service_extra_id' => $extra_id]);
            }  
        }
    }    
    
    // Make sure to add the TMB database credentails in below "updateCity()" function
    public function updateCity() {  
          
        $destinationPath = app_path()."/../FilesForOpertaions/"; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
        $fileName = 'updateCity_n.csv'; // renameing image
        Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
              
        $argv[1] = app_path()."/../FilesForOpertaions/updateCity_n.csv"; 

        if( !isset( $argv[1] ) ){
            echo "Expecting CSV File\n";
            echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
            exit;
        }
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        
        $header_check = array('region_id', 'region_tsid', 'region_name','region_parent_id', 'status', 'created_date');
        
        
        if($header_check !== $header) {
            echo "CVS header must be same like 'region_id','region_tsid', 'region_name','region_parent_id', 'status', 'created_date' <br>";
            exit;
        } 
        
        
        $csv = array();
        foreach ($rows as $row) {
            if(count($row) != count($header)) {        
                continue;
            }
            $csv[] = array_combine($header, $row);
        }
        $count = 0;
        
        foreach($csv as $row) {
            if(!is_array($row)) {
               continue; 
            }

            $region_id = trim($row["region_id"]);
            $region_tsid = trim($row["region_tsid"]);
            $region_name = trim($row["region_name"]);
            $region_parent_tsid = trim($row["region_parent_id"]);
            $status = trim($row["status"]);
            
            ///////////////// RATES DB /////////////////
            
            $region_parent_id = 0;

            $region_parent_id_obj = DB::select("select * from regions where regions.ts_id = '".$region_parent_tsid."'"); 
            if(!empty($region_parent_id_obj)) {
                $region_parent_id = $region_parent_id_obj[0]->id;
            }            
            
            // Add/update regions table 
            $regionObj = DB::select("select * from regions where regions.ts_id = '".$region_tsid."'");
            if(!empty($regionObj)) { 
                // edit
                DB::table('regions')
                    ->where('ts_id', $region_tsid)
                    ->update(['name' => $region_name, 'parent_id' => $region_parent_id, 'status' => $status]);                
            } else {
                // insert new region
                $region_id = DB::table('regions')->insertGetId(
                            ['ts_id' => $region_tsid, 'name' => $region_name, 'parent_id' => $region_parent_id, 'status' => $status]
                            );                
            }
            
            ///////////////// RATES DB /////////////////
            
            ///////////////// TMB DB /////////////////
            
            //
            //MSSQL connection string details.
            $dbhost = $_ENV['TMB_DB_HOST'];
            $dbuser = $_ENV['TMB_DB_USER'];
            $dbpass = $_ENV['TMB_DB_PASS'];
            $dbname = $_ENV['TMB_DB_NAME'];
            $db = mysqli_connect($dbhost, $dbuser, $dbpass);
            if (!$db) {
                die('Could not connect to mssql - check your connection details & make sure that ntwdblib.dll is the right version!');
            }
            
            $db_selected = mysqli_select_db($db, $dbname);
            if (!$db_selected) {
                die('Could not select mssql db');
            }            
            
            $str_regions = "SELECT * FROM `region` WHERE `region_tsid` = $region_tsid ";
            $res = mysqli_query($db,$str_regions) or die(mysqli_error($db));
            
            if(mysqli_num_rows($res) > 0) {
                $update_qry = "update region set region_name = '".$region_name."', region_parent_id = '".$region_parent_tsid."', status = '".$status."' where region_tsid = '".$region_tsid."'";
                mysqli_query($db, $update_qry) or die(mysqli_error($db));
            } else {
                $insert_qry = "insert into region (region_tsid,region_name,region_parent_id,status) values ('".$region_tsid."', '".$region_name."', '".$region_parent_tsid."', '".$status."')";
                mysqli_query($db, $insert_qry) or die(mysqli_error($db));
            }            
            
            ///////////////// TMB DB /////////////////            
        }
    }    
    
    public function Options_iNactive() {
        
        $destinationPath = app_path()."/../FilesForOpertaions/"; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
        $fileName = 'Options_iNactive_n.csv'; // renameing image
        Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
              
        $argv[1] = app_path()."/../FilesForOpertaions/Options_iNactive_n.csv";
        

        if( !isset( $argv[1] ) ){
            echo "Expecting CSV File\n";
            echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
            exit;
        }
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            if(count($row) != count($header)) {        
                continue;
            }
            $csv[] = array_combine($header, $row);
        }
        $count = 0;
        foreach($csv as $row) {
            if(!is_array($row)) {
               continue; 
            }
            $serviceTsId = trim($row["SERVICEID"]);

            if($serviceTsId == '11983' || $serviceTsId =='13762') {
                continue; 
            }
            $serviceOptionsTSid = trim($row["SERVICEOPTIONINSERVICEID"]);
            //$serviceType = trim($row["ServiceType"]);
            //echo $serviceTsId." => ".$serviceOptionsTSid." =>".$serviceType.'<br>';
            //$serviceTsId_arr[] = $serviceTsId;
            //$serviceOptionsTSid[] = $serviceOptionsTSid;
                
                
            //$service_options = DB::select("select service_options.id as options_id, service_options.ts_id as service_options_tsid, services.id as services_id, services.ts_id as services_tsid from service_options inner join services on services.id = service_options.service_id inner join service_types on service_types.id = services.service_type_id where service_options.ts_id = '".$serviceOptionsTSid."' and services.ts_id = '".$serviceTsId."' and service_types.name = '".$serviceType."' and services.id = service_options.service_id ");
            $service_options = DB::select("select service_options.id as options_id, service_options.ts_id as service_options_tsid, services.id as services_id, services.ts_id as services_tsid from service_options inner join services on services.id = service_options.service_id inner join service_types on service_types.id = services.service_type_id where service_options.ts_id = '".$serviceOptionsTSid."' and services.ts_id = '".$serviceTsId."' and services.id = service_options.service_id ");
            if(!empty($service_options)) {
                $option_id = $service_options[0]->options_id;
                $service_options_tsid = $service_options[0]->service_options_tsid;
$sstr = '';
                $sstr = "update service_options set status = 0 where ts_id = '".$service_options_tsid."'; <br>";
                $sstr .= "update prices set status = 0 where priceable_type = 'App\Models\ServiceOption' and priceable_id = '".$option_id."' ;";
                echo $sstr.'<br>';
                $prices = DB::table('prices')->where('priceable_id', $option_id)->where('priceable_type', 'App\Models\ServiceOption')->get();
                foreach($prices as $price) {
                    $service_policies = DB::table('service_policies')->where('price_id', '=', $price->id)->get();
                    foreach($service_policies as $service_policy) {
                        $policy_price_bands = DB::table('policy_price_bands')->where('service_policy_id', '=', $service_policy->id)->get();
                        DB::table('service_policies')->where('id', '=', $service_policy->id)->delete();
                    }
                    DB::table('week_prices')->where('price_id', '=', $price->id)->delete();
                    DB::table('prices')->where('id', '=', $price->id)->delete();
                }
                DB::table('meal_options')->where('service_option_id', '=', $option_id)->delete();
                DB::table('prices')
                    ->where('priceable_id', $option_id)
                    ->where('priceable_type', 'App\Models\ServiceOption')
                    ->delete();
                DB::table('service_options')
                    ->where('id', $option_id)
                    ->delete();
//                DB::table('service_options')
//                    ->where('id', $option_id)
//                    ->update(['status' => '0']);
//                DB::table('prices')
//                    ->where('priceable_id', $option_id)
//                    ->where('priceable_type', 'App\Models\ServiceOption')
//                    ->update(['status' => '0']);

                $count++;
            }
        }
    }

    public function updateServiceShortNameFromCSV() {

        $destinationPath = app_path()."/../FilesForOpertaions/"; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
        $fileName = 'update_service_short_names_n.csv'; // renameing image
        Input::file('file')->move($destinationPath, $fileName); // uploading file to given path

        $argv[1] = app_path()."/../FilesForOpertaions/$fileName";

        if( !isset( $argv[1] ) ){
            echo "Expecting CSV File\n";
            echo "Usage :  \033[1mphp run.php <Full Path To CSV File>\033[0m \n";
            exit;
        }
        $rows = array_map('str_getcsv', file( $argv[1] ));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            if(count($row) != count($header)) {
                continue;
            }
            $csv[] = array_combine($header, $row);
        }


//        print('<xmp>');
//        print_r($csv);
//        print('</xmp>');
//
//        die('3650000000000');

        $str_service_ts_id = '';
        $count = 0;
        $str_update = '';
        $str_insert = '';
        $count_insert = 0;
        $count_update = 0;
        foreach($csv as $row) {
            if(!is_array($row)) {
               continue;
            }
//            $count++;
//            if($count > 1) {
//                break;
//            }

        
            if(!empty($row['Service Short Name'])) {
//                DB::beginTransaction(); //Start transaction!

//               try {

                    $service_tsid = $row['Service ID'];
                    $service_short_name = $row['Service Short Name'];

                    $sstr = "update services set short_name = '".$service_short_name."' where ts_id = '".$service_tsid."';";
                echo $sstr.'<br>';


//               } catch (Exception $ex) {
//                    //failed logic here
//                    DB::rollback();
//                    throw $ex;
//                }
//                DB::commit();
            }

        }

        echo "<br><br> $count_insert - New currencies inserted<br>$str_insert<br><br>";
        echo "<br><br> ========================================= <br><br>";
        echo "<br><br> $count_update - New currencies updated<br>$str_update<br><br>";
    }

}
