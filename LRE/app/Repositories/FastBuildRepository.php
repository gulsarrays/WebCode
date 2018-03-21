<?php

namespace App\Repositories;

use App\Models\FastbuildService;
use App\Models\FastbuildServiceOption;
use App\Models\FastbuildPrice;
use App\Models\Region;
use App\Models\FastbuildRegion;
use App\Models\FastbuildSupplier;
use App\Models\Meal;
use App\Models\FastbuildMealOption;
use App\Models\ServiceType;
use App\Models\Currency;
use App\Models\Occupancy;
use App\Models\ChargingPolicy;
use App\Models\FastbuildServicePolicy;
use App\Models\FastbuildContract;
use App\Models\FastbuildContractPeriod;
use App\Models\FastbuildSeasonPeriod;
use App\Models\FastbuildSeason;
use DB;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;

class FastBuildRepository {
    const POLICYID = 38; // Fast 

    function createCity($params) {
        die('5444444444444');
        $this->transferFastBuilds();
        die('5666666');
        $tsId = $params["region_tsid"];
        $name = $params["region_name"];
        $parentId = $params["parent_region_id"];

//        $parentObj = FastbuildRegion::where('ts_id', $parentId)->first();
        $parentObj = Region::where('ts_id', $parentId)->first();
        $regionParams = array('ts_id' => $tsId, 'name' => $name, 'parent_id' => ($parentObj ? $parentObj->id : 0));

        try {
//            $regionObj = FastbuildRegion::firstOrCreate($regionParams);
            $regionObj = Region::firstOrCreate($regionParams);
            $region_arr[] = (int)$regionObj->id;
            $response = array("Success" => "City has been created Successfully!",
                    'region_id' => $region_arr);
        } catch (\Exception $e) {
            $response = array("Error" => "Caught exception: " . $e->getMessage());
        }

        return $response;
    }

    function createService($params) {
//        die('5444444444444');
        $this->transferFastBuilds();
        die('5666666');

        DB::beginTransaction(); //Start transaction!
        try {
            $regionTsId = $params["region_tsid"];
            $serviceTsId = $params["service_tsid"];
            $serviceName = $params["service_name"];
            $serviceTypeTsId = $params["service_type"];
            $currency = $params["currency"];
            $supplierName = $params["supplier_name"];
            $mealName = $params["meals"];
            
            $mealObj = null;
            $serviceTypeObj = ServiceType::where('ts_id', $serviceTypeTsId)->first();
            $currencyObj = Currency::where('code', $currency)->first();
            if ($mealName) {
                $mealObj = Meal::where('name', $mealName)->first();
            }
//            $regionObj = FastbuildRegion::where('ts_id', $regionTsId)->first();
            $regionObj = Region::where('ts_id', $regionTsId)->first();
            
            if(empty($regionObj)){
                return array("Error" => "Region not exits Rates DB.");
            }

            $supplierObj = FastbuildSupplier::firstOrCreate(array('name' => $supplierName, 'region_id' => $regionObj->id));

            // Find or Create Service
            $serviceParams = array('ts_id' => $serviceTsId,
                'name' => $serviceName,
                'region_id' => $regionObj->id,
                //'currency_id' => $currencyObj->id,
                'service_type_id' => $serviceTypeObj->id,
                'supplier_id' => $supplierObj->id
            );            
            
            
            $serviceObj = FastbuildService::where('ts_id', $serviceTsId)->first();
            if(empty($serviceObj)) {                
                $serviceObj = FastbuildService::Create(array('ts_id' => $serviceTsId,'region_id' => $regionObj->id, 'service_type_id' => $serviceTypeObj->id, 'supplier_id' => $supplierObj->id));
            }             
            
            foreach ($serviceParams as $key => $value) {
                $serviceObj->$key = $value;
            }
            $serviceObj->save();

            foreach ($params["option"] as $key => $option) {
                
               
                $option_id = !empty($option["option_id"]) ? $option["option_id"] : 0;
                $occupancyId = $option["occupancy_id"];
                $occupancyObj = Occupancy::find($occupancyId);
                $optionName = $option["option_name"];            
                $startDate = $option["start_date"];
                $endDate = $option["end_date"];
                $optionIsDefault = (!empty($option["is_default"]) ? $option["is_default"] : 'NO');           
                $policy_tsid = !empty($option["charging_policy_id"]) ? $option["charging_policy_id"] : 0 ;
                $policy_id = self::POLICYID;

                $policy_tsid_Obj = ChargingPolicy::where('ts_id', $policy_tsid)->first();
                
                if(!empty($policy_tsid_Obj)) {                
                    $policy_id =  $policy_tsid_Obj->id;              
                }
                
                // Find Or Create Service Option
                $optionObj = null;
                if ($optionName) {
                    $optionParams = array('occupancy_id' => $occupancyObj->id, 'name' => $optionName, 'service_id' => $serviceObj->id, 'is_default' => $optionIsDefault);
                    if(!empty($option_id)) {
                         //$optionObj = ServiceOption::firstOrCreate(array('service_id' => $serviceObj->id,'occupancy_id' => $occupancyObj->id));
                        $optionObj = FastbuildServiceOption::firstOrCreate(array('id' => $option_id));
                        
                        foreach ($optionParams as $key => $value) {
                            $optionObj->$key = $value;
                        }
                        $optionObj->save();                        
                    } else {
                        //$optionObj = ServiceOption::firstOrCreate($optionParams);
                        $optionObj = FastbuildServiceOption::Create($optionParams);
                    }
                    $option_arr[] = (int)$optionObj->id;

                    // Find or Create Meal Option
                    if ($mealObj) {
                        //MealOption::firstOrCreate(['meal_id' => $mealObj->id, 'service_option_id' => $optionObj->id]);
                        $mealOptionParams = array('meal_id' => $mealObj->id, 'service_option_id' => $optionObj->id);
                        $mealOptionObj = FastbuildMealOption::where($mealOptionParams)->get();
                        
                        if(empty($mealOptionObj->id)) {                            
                            $mealOptionObj = FastbuildMealOption::firstOrCreate(array('meal_id' => $mealObj->id, 'service_option_id' => $optionObj->id));
                        } else {
                            foreach ($mealOptionParams as $key => $value) {
                                $mealOptionObj->$key = $value;
                            }
                            $mealOptionObj->save();
                        }
                        
//                        $mealOptionObj = MealOption::firstOrCreate(array('meal_id' => $mealObj->id, 'service_option_id' => $optionObj->id)); 
//                        foreach ($mealOptionParams as $key => $value) {
//                            $mealOptionObj->$key = $value;
//                        }
//                        $mealOptionObj->save();
                    }
                    
                    // Find or Create Contracts & Seasons
                    $start = $option["start_date"];
                    $end = $option["end_date"];
                    //$contractObj = Contract::firstOrCreate(array('name' => "Fastbuild Contract " . $optionObj->id, 'service_id' => $serviceObj->id));
                    $contractParams = array('name' => "Fastbuild Contract " . $optionObj->id, 'service_id' => $serviceObj->id);
                    $contractObj = FastbuildContract::firstOrCreate($contractParams);
                    foreach ($contractParams as $key => $value) {
                        $contractObj->$key = $value;
                    }
                    $contractObj->save();
                    
                    
                    $contractPeriodParams = array('name' => "Fastbuild Contract Period" . $optionObj->id, 'start' => date("Y/m/d", strtotime($start)), 'end' => date("Y/m/d", strtotime($end)), 'contract_id' => $contractObj->id);
                    $contractPeriodObj = FastbuildContractPeriod::firstOrCreate(array('contract_id' => $contractObj->id));
                    foreach ($contractPeriodParams as $key => $value) {
                        $contractPeriodObj->$key = $value;
                    }
                    $contractPeriodObj->save(); 
                    
                    
                    $seasonParams = array('name' => "Fastbuild Season " . $optionObj->id, 'contract_period_id' => $contractPeriodObj->id);
                    $seasonObj = FastbuildSeason::firstOrCreate(array('contract_period_id' => $contractPeriodObj->id));
                    foreach ($seasonParams as $key => $value) {
                        $seasonObj->$key = $value;
                    }
                    $seasonObj->save();
                    

                    $seasonPeriodParams = array('start' => date("Y/m/d", strtotime($start)), 'end' => date("Y/m/d", strtotime($end)), 'season_id' => $seasonObj->id);
                    $seasonPeriodObj = FastbuildSeasonPeriod::firstOrCreate(array('season_id' => $seasonObj->id));
                    foreach ($seasonPeriodParams as $key => $value) {
                        $seasonPeriodObj->$key = $value;
                    }
                    $seasonPeriodObj->save();
                    

                    // Find or Create Prices
                    $buyPrice = $option["buy_price"];
                    $sellPrice = $option["sell_price"];
                    $priceParams = array('season_period_id' => $seasonPeriodObj->id,
//                        'buy_price' => $buyPrice,
//                        'sell_price' => $sellPrice,
                        'service_id' => $serviceObj->id,
                        'priceable_id' => $optionObj->id,
                        //'currency_id' => $currencyObj->id,
                        'priceable_type' => 'App\Models\ServiceOption'
                    );
                    $priceObj = null;
                    if ($optionObj) {
                        
                        
                        
                        $priceObj = FastbuildPrice::where($priceParams)->first();
                        if(!empty($priceObj)) {
                            $priceParams = array('season_period_id' => $seasonPeriodObj->id,
                                'buy_price' => $buyPrice,
                                'sell_price' => $sellPrice,
                                'service_id' => $serviceObj->id,
                                'priceable_id' => $optionObj->id,
                                'currency_id' => $currencyObj->id,
                                'season_period_start' => $startDate,
                                'season_period_end' => $endDate,
                                'meal_plan_id' => (isset($mealObj->id)) ? $mealObj->id : 0,
                                'priceable_type' => 'App\Models\ServiceOption'
                            );
                                                        
                            foreach ($priceParams as $key => $value) {
                                $priceObj->$key = $value;
                            }
                            $priceObj->save();
                        } else {
                            
                            $priceParams = array('season_period_id' => $seasonPeriodObj->id,
                                'buy_price' => $buyPrice,
                                'sell_price' => $sellPrice,
                                'service_id' => $serviceObj->id,
                                'priceable_id' => $optionObj->id,
                                'currency_id' => $currencyObj->id,
                                'season_period_start' => $startDate,
                                'season_period_end' => $endDate,
                                'meal_plan_id' => (isset($mealObj->id)) ? $mealObj->id : 0,
                                'priceable_type' => 'App\Models\ServiceOption'
                            );
                            $priceObj = FastbuildPrice::firstOrCreate($priceParams);
                        }

                    }
                    
                    // Find or Create Service Policies
                    if ($priceObj) {
                        $policyParams = array('charging_policy_id' => $policy_id, 'price_id' => $priceObj->id);
                        
                        $servicePolicyObj = FastbuildServicePolicy::where('price_id', $priceObj->id)->first();
                        if(!empty($servicePolicyObj)) {
                            foreach ($policyParams as $key => $value) {
                                $servicePolicyObj->$key = $value;
                            }
                            $servicePolicyObj->save();  
                            
                        } else {
                            
                            $servicePolicyObj = FastbuildServicePolicy::Create(array('charging_policy_id' => $policy_id, 'price_id' => $priceObj->id));
                            foreach ($policyParams as $key => $value) {
                                $servicePolicyObj->$key = $value;
                            }
                            $servicePolicyObj->save();  
                        }
                    }
                }
            }
//            if(!empty($option_id)) {
//                $response = array(
//                    'Success' => "Service " . $serviceObj->ts_id . " / " . $serviceObj->name . " has been updated...\n",
//                    'option_ids' => $option_arr
//                    );
//            } else {
                $response = array(
                    'Success' => "Service " . $serviceObj->ts_id . " / " . $serviceObj->name . " has been created...\n",
                    'option_ids' => $option_arr
                    );
            //}
            
        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            
            $response = array("Error" => "Caught exception: " . $e->getMessage());
        }
        DB::commit();

        return $response;
    }

    function transferFastBuilds()
    {
        $service_ts_id = 499999;
        $servicesArrObj = DB::table('services')->where('ts_id', '>=', $service_ts_id)->get();
            if(!empty($servicesArrObj)) {
                foreach ($servicesArrObj as $servicesObj) {
                    // DB::beginTransaction(); //Start transaction!
                    try {

                        $service_ts_id = $servicesObj->ts_id;
                        $services_id = $servicesObj->id;
                        $service_id = $services_id;
                        echo $service_ts_id.' => '.$services_id.'<br>';


                        $service_options = DB::table('service_options')->where('service_id', '=', $service_id)->get();

                        DB::statement('INSERT INTO fastbuild_suppliers SELECT * FROM suppliers where id = "'.$servicesObj->supplier_id.'"');
                        DB::statement('INSERT INTO fastbuild_services SELECT * FROM services where ts_id = "'.$service_ts_id.'"');


                        foreach($service_options as $service_option){
                            DB::statement('INSERT INTO fastbuild_service_options SELECT * FROM service_options where id = "'.$service_option->id.'"');
                            DB::statement('INSERT INTO fastbuild_meal_options SELECT * FROM meal_options where service_option_id = "'.$service_option->id.'"');

    //                        $meal_options = DB::table('meal_options')->where('service_option_id', '=', $service_option->id)->delete();
    //                        $service_options = DB::table('service_options')->where('id', '=', $service_option->id)->delete();
                        }

                        //$service_extras = DB::table('service_extras')->where('service_id', '=', $service_id)->delete();
                        DB::statement('INSERT INTO fastbuild_service_extras SELECT * FROM service_extras where service_id = "'.$service_id.'"');


                        $contracts = DB::table('contracts')->where('service_id', '=', $service_id)->get();
                        foreach($contracts as $contract) {
                            DB::statement('INSERT INTO fastbuild_contracts SELECT * FROM contracts where id = "'.$contract->id.'"');

                            $contract_periods = DB::table('contract_periods')->where('contract_id', '=', $contract->id)->get();
                            foreach($contract_periods as $contract_period) {
                                DB::statement('INSERT INTO fastbuild_contract_periods SELECT * FROM contract_periods where id = "'.$contract_period->id.'"');
                                $seasons = DB::table('seasons')->where('contract_period_id', '=', $contract_period->id)->get();
                                foreach($seasons as $season) {
                                    DB::statement('INSERT INTO fastbuild_seasons SELECT * FROM seasons where id = "'.$season->id.'"');
                                    $season_periods = DB::table('season_periods')->where('season_id', '=', $season->id)->get();
                                    foreach($season_periods as $season_period) {
                                        DB::statement('INSERT INTO fastbuild_season_periods SELECT * FROM season_periods where id = "'.$season_period->id.'"');
                                        //DB::table('season_periods')->where('id', '=', $season_period->id)->delete();
                                    }

                                    //DB::table('seasons')->where('id', '=', $season->id)->delete();
                                }

                                //DB::table('contract_periods')->where('id', '=', $contract_period->id)->delete();
                            }

                            //DB::table('contracts')->where('id', '=', $contract->id)->delete();
                        }



                        $prices = DB::table('prices')->where('service_id', '=', $service_id)->get();

                        foreach($prices as $price) {
                            DB::statement('INSERT INTO fastbuild_prices SELECT * FROM prices where id = "'.$price->id.'"');

                            $service_policies = DB::table('service_policies')->where('price_id', '=', $price->id)->get();
                            foreach($service_policies as $service_policy) {
                                $policy_price_bands = DB::table('policy_price_bands')->where('service_policy_id', '=', $service_policy->id)->get();
                                DB::statement('INSERT INTO fastbuild_service_policies SELECT * FROM service_policies where id = "'.$service_policy->id.'"');
                                //DB::table('service_policies')->where('id', '=', $service_policy->id)->delete();

                                DB::statement('INSERT INTO fastbuild_policy_price_bands SELECT * FROM policy_price_bands where service_policy_id = "'.$service_policy->id.'"');
                                //DB::table('policy_price_bands')->where('service_policy_id', '=', $service_policy->id)->delete();
                            }
                            DB::statement('INSERT INTO fastbuild_week_prices SELECT * FROM week_prices where price_id = "'.$price->id.'"');
                            //DB::table('week_prices')->where('price_id', '=', $price->id)->delete();


                            //DB::table('prices')->where('id', '=', $price->id)->delete();
                        }

    //                    $contracts = DB::table('contracts')->where('service_id', '=', $service_id)->get();
    //                    foreach($contracts as $contract) {
    //                        $contract_periods = DB::table('contract_periods')->where('contract_id', '=', $contract->id)->get();
    //                        foreach($contract_periods as $contract_period) {
    //                            $seasons = DB::table('seasons')->where('contract_period_id', '=', $contract_period->id)->get();
    //                            foreach($seasons as $season) {
    //                                $season_periods = DB::table('season_periods')->where('season_id', '=', $season->id)->get();
    //                                foreach($season_periods as $season_period) {
    //                                    DB::statement('INSERT INTO fastbuild_season_periods SELECT * FROM season_periods where id = "'.$season_period->id.'"');
    //                                    //DB::table('season_periods')->where('id', '=', $season_period->id)->delete();
    //                                }
    //                                DB::statement('INSERT INTO fastbuild_seasons SELECT * FROM seasons where id = "'.$season->id.'"');
    //                                //DB::table('seasons')->where('id', '=', $season->id)->delete();
    //                            }
    //                            DB::statement('INSERT INTO fastbuild_contract_periods SELECT * FROM contract_periods where id = "'.$contract_period->id.'"');
    //                            //DB::table('contract_periods')->where('id', '=', $contract_period->id)->delete();
    //                        }
    //                        DB::statement('INSERT INTO fastbuild_contracts SELECT * FROM contracts where id = "'.$contract->id.'"');
    //                        //DB::table('contracts')->where('id', '=', $contract->id)->delete();
    //                    }

                        //DB::table('services')->where('ts_id', '=', $service_ts_id)->delete();



                    } catch (Exception $ex) {
                        //failed logic here
    //                    DB::rollback();
                        throw $ex;
                    }
//                DB::commit();

                echo "Service Id : ".$service_ts_id.' deleted <br>';
                }

            }

    }

}
