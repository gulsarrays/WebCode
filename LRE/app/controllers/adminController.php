<?php

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
//use DB;
use App\Repositories\BackendServiceDataRepository;

class adminController extends BaseController {

    const NO_OF_RECORDS_PER_PAGE = 10;
    const CONTRACT_TSID = '0';
    const CONTRACT_NAME = 'ET-CUSTOM-CONTARCT';
    const CONTRACT_PERIOD_NAME = 'ET-CUSTOM-CONTARCT-PERIOD-NAME';
    const CONTRACT_PERIOD_DURATION = '10'; // in year
    const SEASON_NAME = 'Season 01';
    const DEFAULT_CURRENCY_ID = '33';
    const DEFAULT_CURRENCY_CODE = 'USD';

    public function __construct(BackendServiceDataRepository $serviceDataRepo) {
        $this->serviceDataRepo = $serviceDataRepo;
    }
    
    ///////////// New Design -  Start /////////////
    public function viewService() {
        
        $service_ts_id = Input::get('service_tsid');
        
        if((int)$service_ts_id > 0) {
            $service_id = $this->serviceDataRepo->getServiceIdFromTSID($service_ts_id);
        } else {
            $service_ts_id = 0;
            $service_id = 0;
        }
          /*      
        if (isset($_GET['service_tsid'])) {
            $service_ts_id = $_GET['service_tsid'];
            $service_id = $this->serviceDataRepo->getServiceIdFromTSID($service_ts_id);
        } else if (isset($_POST['selected_service_tsid'])) {
            $service_ts_id = $_POST['selected_service_tsid'];
            $service_id = $_POST['selected_service_id'];
        } else {
            $service_ts_id = 0;
            $service_id = 0;
        }
        */
        
        $dataToView = array(
            'service_ts_id' => $service_ts_id,
            'service_id' => $service_id,
            'suppliers' => $this->getAllUniqueSuppliersByName(),
            'regions' => $this->getAllRegions(),
            'currencies' => $this->getAllCurrencies(),
            'serviceTypes' => $this->getAllServiceTypes(),
            'occupancies' => $this->getAllOccupancies(),
            'chargingPolicies' => $this->getAllChargingPolicies(),
            'roomTypes' => $this->serviceDataRepo->getUniqueRoomTypes($service_id),
            'services' => ( ($service_ts_id > 0) ? $this->getServiceData($service_id) : '')
        );
        
        return View::make('pages.viewService', $dataToView);
    }
    ///////////// New Design -  End ///////////////
    

    public function listContracts() {

//          $this->updateOptionsIsDefaultForAllOccupany();
//            $this->populateMarginTablePerServicePerSeason();
//die('355555555555555');

        $services = $this->getServiceList();
        $total_pages = ceil($services['total_services'] / self::NO_OF_RECORDS_PER_PAGE);
        array_pop($services);

        $dataToView = array(
            'regions' => $this->getAllRegions(),
            'serviceTypes' => $this->getAllServiceTypes(),
            'services' => $services
        );
        return View::make('pages.listContracts', $dataToView);
    }

    public function listSearchContracts() {

        if (Input::get('checkValues') != '') {
            $this->updateServiceList();
        }

        $services = $this->getServiceList();
        $total_pages = ceil($services['total_services'] / self::NO_OF_RECORDS_PER_PAGE);
        array_pop($services);
        $data = array(
            'status' => 'success',
            'services' => $services,
            'total_pages' => $total_pages
        );
        return json_encode($data);
    }

    public function updateServiceList() {
        $checkValues = Input::get('checkValues');
        $apply_status = Input::get('apply_status');
        if ($apply_status === 'Active') {
            $apply_status = 1;
        } else {
            $apply_status = 0;
        }
        $apply_margin = Input::get('apply_margin');
        $services = $this->getServiceListBySearchCriteria('', '', '', '0,1', $checkValues);
        foreach ($services as $serviceData) {
            $buyPrice = $serviceData->buy_price;
            $sellPrice = $serviceData->sell_price;

            $pricesOprionsData = DB::select("select services.id  as services_id,service_options.id as option_id, prices.id as price_id, prices.priceable_type from services, service_options, prices where services.id=" . $serviceData->service_id . " and services.id=service_options.service_id and service_options.id = prices.priceable_id and prices.priceable_type = 'App\\\\Models\\\\ServiceOption' ");
            if (!empty($apply_margin)) {
                $sellPrice = $this->getSellPriceForMargin($buyPrice, $apply_margin);
                foreach ($pricesOprionsData as $priceData) {
                    DB::table('prices')
                            ->where('id', $priceData->price_id)
                            ->update(array('sell_price' => $sellPrice));
                }
            }

            foreach ($pricesOprionsData as $priceData) {
                DB::table('service_options')
                        ->where('id', $priceData->option_id)
                        ->update(array('status' => $apply_status));
            }

            $pricesExtrasData = DB::select("select services.id as services_id,service_extras.id as extra_id, prices.id as price_id, prices.priceable_type from services, service_extras, prices where services.id=" . $serviceData->service_id . " and services.id=service_extras.service_id and service_extras.id = prices.priceable_id and prices.priceable_type = 'App\\\\Models\\\\ServiceExtra'");
            if (!empty($apply_margin)) {
                $sellPrice = $this->getSellPriceForMargin($buyPrice, $apply_margin);
                foreach ($pricesExtrasData as $priceData) {
                    DB::table('prices')
                            ->where('id', $priceData->price_id)
                            ->update(array('sell_price' => $sellPrice));
                }
            }
            foreach ($pricesExtrasData as $priceData) {
                DB::table('service_extras')
                        ->where('id', $priceData->extra_id)
                        ->update(array('status' => $apply_status));
            }
            DB::table('services')
                    ->where('id', $priceData->services_id)
                    ->update(array('status' => $apply_status));
        }
    }

    public function addContract() {
        $service_ts_id = '';
        $service_id = '';
        $dataToView = array(
            'service_ts_id' => $service_ts_id,
            'service_id' => $service_id,
            'suppliers' => $this->getAllUniqueSuppliersByName(),
            'regions' => $this->getAllRegions(),
            'currencies' => $this->getAllCurrencies(),
            'serviceTypes' => $this->getAllServiceTypes(),
            'occupancies' => $this->getAllOccupancies(),
            'chargingPolicies' => $this->getAllChargingPolicies(),
            'services' => array()
        );
        return View::make('pages.updateContracts', $dataToView);
    }

    public function updateContract() {
        if (isset($_GET['service_tsid'])) {
            $service_ts_id = $_GET['service_tsid'];
            $service_id = $this->serviceDataRepo->getServiceIdFromTSID($service_ts_id);
        } else if (isset($_POST['selected_service_tsid'])) {
            $service_ts_id = $_POST['selected_service_tsid'];
            $service_id = $_POST['selected_service_id'];
        } else {
            $service_ts_id = 0;
            $service_id = 0;
        }
        
        
        $dataToView = array(
            'service_ts_id' => $service_ts_id,
            'service_id' => $service_id,
            'suppliers' => $this->getAllUniqueSuppliersByName(),
            'regions' => $this->getAllRegions(),
            'currencies' => $this->getAllCurrencies(),
            'serviceTypes' => $this->getAllServiceTypes(),
            'occupancies' => $this->getAllOccupancies(),
            'chargingPolicies' => $this->getAllChargingPolicies(),
            'roomTypes' => $this->serviceDataRepo->getUniqueRoomTypes($service_id),
            'services' => ( ($service_ts_id > 0) ? $this->getServiceData($service_id) : '')
        );
        
        
        
        return View::make('pages.updateContracts', $dataToView);
    }

    public function saveContract() {
        
        $this->serviceDataRepo->collectServiceFormInput();
        $service_tsid = $this->serviceDataRepo->updateServiceData();

        if($service_tsid == 'use_delete_action') {
            $data = array('message' => "Error!!!!! Price Duplication !!!" );
        } else {
            $data = array('service_tsid' => $service_tsid, 'message' => "Data updated successfully for serice TS-ID : " . $service_tsid);
        }
        
        return json_encode($data);
    }
    
    public function deleteOptionsAndExtraPrices() {
        $this->serviceDataRepo->collectServiceFormInput();
        DB::beginTransaction(); //Start transaction!
        try {
            $this->serviceDataRepo->deleteOptions();
            $this->serviceDataRepo->deleteExtras();
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            //failed logic here
            DB::rollback();
            throw $exc;
        }
         DB::commit();

        
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllRegions() {
        $regions = DB::table('regions')->get();
        return $regions;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllParentRegions() {
        $regions = DB::table('regions')->where('parent_id', '=', '0')->get();
        return $regions;
    }

    /**
     * 
     * @param string $parentID
     * @return array of object
     */
    public static function getAllRegionsForParent($parentID) {
        $parentID_arr = explode(',', $parentID);
        $regions = DB::table('regions')->whereIn('parent_id', $parentID_arr)->get();
        return $regions;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllServiceTypes() {
        $service_types = DB::table('service_types')->get();
        return $service_types;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllOccupancies() {
        $ajax_call = Input::get('ajax_call');

        $occupancies = DB::table('occupancies')->get();
        if (!empty($ajax_call) && $ajax_call == 1) {
            return json_encode($occupancies);
        }
        return $occupancies;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllChargingPolicies() {
        $ajax_call = Input::get('ajax_call');

        $charging_policies = DB::table('charging_policies')->get();
        if (!empty($ajax_call) && $ajax_call == 1) {
            return json_encode($charging_policies);
        }
        return $charging_policies;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllMealPlans() {
        $ajax_call = Input::get('ajax_call');

        $meal_plans = DB::table('meals')->get();
        if (!empty($ajax_call) && $ajax_call == 1) {
            return json_encode($meal_plans);
        }
        return $meal_plans;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllCurrencies() {
        $ajax_call = Input::get('ajax_call');
        $currencies = DB::table('currencies')->get();
        if (!empty($ajax_call) && $ajax_call == 1) {
            return json_encode($currencies);
        }
        return $currencies;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllSuppliers() {
        $suppliers = DB::table('suppliers')->get();
        return $suppliers;
    }

    /**
     * 
     * @param NULL
     * @return array of object
     */
    public static function getAllUniqueSuppliersByName() {
        $suppliers = DB::table('suppliers')->select('id', 'name')->groupBy('name')->get();
        return $suppliers;
    }

    /**
     * 
     * @param int $regionId
     * @return array of object
     */
    public function getAllSuppliersForRegion() {
        $regionId = Input::get('regionId');
        $suppliers = DB::table('suppliers')->where('region_id', '=', $regionId)->get();
        return json_encode($suppliers);
    }

    /**
     * 
     * @param string $supplierName
     * @return array of object
     */
    public function getAllRegionsForSupplier() {

        $supplierId = Input::get('supplierId');
        $regions = DB::table('regions')
                ->join('suppliers', 'regions.id', '=', 'suppliers.region_id')
                ->select('regions.id', 'regions.ts_id', 'regions.name', 'regions.parent_id')
                ->where('suppliers.id', '=', $supplierId)
                ->get();

        return json_encode($regions);
    }

    public function getServiceList() {

        if (!empty($_POST)) {
            $service = !empty($_POST['service_name']) ? trim($_POST['service_name']) : NULL;
            $region = !empty($_POST['regions']) ? $_POST['regions'] : array();
            $service_type = !empty($_POST['service_type']) ? $_POST['service_type'] : array();
            if (!empty($_POST['status'])) {
                $serviceStatus = implode(',', $_POST['status']);
            } else {
                $serviceStatus = '0,1';
            }
            $services = $this->getServiceListBySearchCriteria($service, $region, $service_type, $serviceStatus);
        } else {
            $services = $this->getServiceListBySearchCriteria('', '', '', '0,1');
        }

        return $services;
    }

    /**
     * 
     * @param string $service
     * @param string $region
     * @param string $service_type
     * @return array of object
     */
    public function getServiceListBySearchCriteria($service = NULL, $region = array(), $service_type = array(), $serviceStatus = '0,1', $serviceIds = NULL) {
        if (Input::get('current_page') == 1) {
            $limit_start = 0;
        } else {
            $limit_start = Input::get('current_page') * self::NO_OF_RECORDS_PER_PAGE;
        }
        if ($limit_start > 0) {
            $limit_end = self::NO_OF_RECORDS_PER_PAGE;
        } else {
            $limit_end = self::NO_OF_RECORDS_PER_PAGE;
        }

        if (!empty($serviceIds)) {
            $services = DB::select("select services.ts_id as ts_id, services.id as service_id, services.name as service_name, services.service_type_id, service_types.name as service_types, services.region_id, regions.name as region_name, services.status as service_status, prices.id as price_id, prices.buy_price, prices.sell_price from services join service_types on (service_types.id = services.service_type_id) join regions on (services.region_id =regions.id ) join service_options on (services.id = service_options.service_id) join prices on (prices.priceable_id = service_options.id) where services.status IN ($serviceStatus) AND services.id IN($serviceIds) group by services.id ");
        } else if (!empty($service) || !empty($region) || !empty($service_type)) {
            $region_str = implode(",", $region);
            $service_type_str = implode(",", $service_type);
            $service_condition = !empty($service) ? " AND services.name like '%$service%' " : '';
            $region_condition = !empty($region) ? " AND regions.id IN ($region_str) " : '';
            $service_type_condition = !empty($service_type) ? " AND services.service_type_id IN ($service_type_str) " : '';

            $services = DB::select("select services.ts_id as ts_id, services.id as service_id, services.name as service_name, services.service_type_id, service_types.name as service_types, services.region_id, regions.name as region_name, services.status as service_status, prices.buy_price, prices.sell_price,ROUND(((prices.sell_price-prices.buy_price)/prices.buy_price)*100) as margin  from services join service_types on (service_types.id = services.service_type_id) join regions on (services.region_id =regions.id ) join service_options on (services.id = service_options.service_id) join prices on (prices.priceable_id = service_options.id) where 1 $service_condition $region_condition $service_type_condition AND services.status IN ($serviceStatus) group by services.id limit $limit_start , $limit_end");

            $total_services = DB::select("select count(*) as total_services from services join service_types on (service_types.id = services.service_type_id) join regions on (services.region_id =regions.id ) join service_options on (services.id = service_options.service_id) join prices on (prices.priceable_id = service_options.id) where 1 $service_condition $region_condition $service_type_condition AND services.status IN ($serviceStatus) group by services.id ");
            if (!empty($total_services)) {
                $services = array_merge($services, array('total_services' => count($total_services)));
            } else {
                $services = array_merge($services, array('total_services' => 0));
            }
        } else {

            $services = DB::select("select services.ts_id as ts_id, services.id as service_id, services.name as service_name, services.service_type_id, service_types.name as service_types, services.region_id, regions.name as region_name, services.status as service_status, prices.buy_price, prices.sell_price, ROUND(((prices.sell_price-prices.buy_price)/prices.buy_price)*100) as margin  from services join service_types on (service_types.id = services.service_type_id) join regions on (services.region_id =regions.id ) join service_options on (services.id = service_options.service_id) join prices on (prices.priceable_id = service_options.id) where services.status IN ($serviceStatus) group by services.id limit $limit_start , $limit_end");
            $total_services = DB::select("select count(*) as total_services from services join service_types on (service_types.id = services.service_type_id) join regions on (services.region_id =regions.id ) join service_options on (services.id = service_options.service_id) join prices on (prices.priceable_id = service_options.id) where services.status IN ($serviceStatus) group by services.id ");
            if (!empty($total_services)) {
                $services = array_merge($services, array('total_services' => count($total_services)));
            } else {
                $services = array_merge($services, array('total_services' => 0));
            }
        }
        return $services;
    }

    /**
     * 
     * @param int $serviceId
     * @param int $serviceStatus
     * @return array of object
     */
    public function getServiceData($serviceId, $serviceStatus = '0,1', $rawData = false, $whereCreiteria = array()) {
        if (empty($serviceStatus)) {
            $serviceStatus = '0,1';
        }
        $str_where_serviceId_is = " where 1 ";
        $str_where_condition = '';
        if (!empty($serviceId)) {
            $str_where_serviceId_is .= " AND services.id='$serviceId' ";
        }
        if (!empty($whereCreiteria)) {
            foreach ($whereCreiteria as $k => $v) {
                switch ($k) {
                    case 'season_name':
                        $str_where_condition .= " AND seasons.name = '" . $v . "' ";
                        break;
                    case 'contract_id':
                        $str_where_condition .= " AND contracts.id = '" . $v . "' ";
                        break;
                }
            }
        }
        //$serviceData = DB::select("select services.ts_id as ts_id, services.id as service_id, services.name as service_name, services.service_type_id, service_types.name as service_type, services.region_id, regions.name as region_name, services.supplier_id, suppliers.name as supplier_name,suppliers.ts_id  as supplier_tsid, services.currency_id, currencies.code as currency_code, services.status as service_status  from services, service_types, currencies, regions, suppliers $str_where_serviceId_is AND services.service_type_id = service_types.id AND services.region_id = regions.id AND services.supplier_id = suppliers.id AND services.currency_id = currencies.id AND services.status IN ($serviceStatus)");
        $serviceData = DB::select("select services.ts_id as ts_id, services.id as service_id, services.name as service_name, services.service_type_id, service_types.name as service_type, services.region_id, regions.name as region_name, services.supplier_id, suppliers.name as supplier_name,suppliers.ts_id  as supplier_tsid, services.status as service_status  from services, service_types, regions, suppliers $str_where_serviceId_is AND services.service_type_id = service_types.id AND services.region_id = regions.id AND services.supplier_id = suppliers.id AND services.status IN ($serviceStatus)");
          
        foreach ($serviceData as $service) {
            $service_tsid = trim($service->ts_id);
            $service_id = trim($service->service_id);
            $_serviceDataArr[$service_tsid]['ts_id'] = $service_tsid;
            $_serviceDataArr[$service_tsid]['service_id'] = $service_id;
            $_serviceDataArr[$service_tsid]['service_name'] = trim($service->service_name);
            $_serviceDataArr[$service_tsid]['service_type_id'] = trim($service->service_type_id);
            $_serviceDataArr[$service_tsid]['service_type'] = trim($service->service_type);
            $_serviceDataArr[$service_tsid]['region_id'] = trim($service->region_id);
            $_serviceDataArr[$service_tsid]['region_name'] = trim($service->region_name);
            $_serviceDataArr[$service_tsid]['supplier_id'] = trim($service->supplier_id);
            $_serviceDataArr[$service_tsid]['supplier_name'] = trim($service->supplier_name);
            //$_serviceDataArr[$service_tsid]['currency_id'] = trim($service->currency_id);
            $_serviceDataArr[$service_tsid]['currency_id'] = self::DEFAULT_CURRENCY_ID;
            //$_serviceDataArr[$service_tsid]['currency_code'] = trim($service->currency_code);
            $_serviceDataArr[$service_tsid]['currency_code'] = self::DEFAULT_CURRENCY_CODE;
            $_serviceDataArr[$service_tsid]['service_status'] = trim($service->service_status);

            //$margin = $this->getMarginForSellPrice(trim($service->buy_price),trim($service->sell_price));
            $margin = 0;
            $_serviceDataArr[$service_tsid]['margin'] = trim($margin);
        }

        $serviceOptionsData = $this->getAllOptionsForService($service_id);
        foreach ($serviceOptionsData as $optionData) {
            
            //$default_option_key = 'default_option_name';
            $default_option_value = '';
            $_serviceDataArr[$service_tsid]['default_option'] = '';
            if($optionData->is_default == 'YES') {
                $option_name = trim($optionData->name);
                $index = strpos($option_name,'(');
                $option_name_str = substr($option_name, 0, $index); 
                $default_option_value = trim($option_name_str);
                $_serviceDataArr[$service_tsid]['default_option'] = trim($default_option_value);
            }            
            
            $_serviceDataArr[$service_tsid]['option'][trim($optionData->id)] = array(
                'ts_option_id' => trim($optionData->ts_id),
                'option_id' => trim($optionData->id),
                'option_name' => trim($optionData->name),
                'occupancy_id' => trim($optionData->occupancy_id),
                'mandatory_extra' => trim($optionData->service_extra_id),
                'multiple_mandatory_extra' => trim($optionData->multiple_service_extra_id),
                'is_default' => trim($optionData->is_default),
                'status' => trim($optionData->status)
            );
        }

        $serviceExtraData = $this->getAllExtrasForService($service_id);
        foreach ($serviceExtraData as $extraData) {
            $_serviceDataArr[$service_tsid]['extras'][trim($extraData->id)] = array(
                'ts_extra_id' => trim($extraData->ts_id),
                'extra_id' => trim($extraData->id),
                'extra_name' => trim($extraData->name),
                'mandatory' => trim($extraData->mandatory),
                //'is_default'        => trim($extraData->is_default),
                'status' => trim($extraData->status)
            );
        }
//print('<xmp>');
//print_r($_serviceDataArr);
//print('</xmp>');
//die('554');
        return $_serviceDataArr;
    }

    public static function getAllOptionsForService($serviceId, $serviceStatus = '0,1') {
        $status_arr = explode(',', $serviceStatus);
        $serviceOptionData = DB::table('service_options')->where('service_id', '=', $serviceId)->whereIn('status', $status_arr)->get();
        return $serviceOptionData;
    }

    public static function getAllExtrasForService($serviceId, $serviceStatus = '0,1') {
        $status_arr = explode(',', $serviceStatus);
        $serviceExtraData = DB::table('service_extras')->where('service_id', '=', $serviceId)->whereIn('status', $status_arr)->get();
        return $serviceExtraData;
    }

    public function getServiceExtrasData($serviceId, $serviceStatus = '0,1') {

        $serviceExtraData = DB::select("select contracts.id as contract_id, contracts.name as contract_name, contract_periods.id as contract_period_id, contract_periods.name as contract_period_name, contract_periods.start as contract_period_start, contract_periods.end as contract_period_end, services.ts_id as ts_id, services.id as service_id, services.name as service_name, services.service_type_id, service_types.name as service_type, services.region_id, regions.name as region_name, services.supplier_id, suppliers.name as supplier_name, services.currency_id, currencies.code as currency_code, services.status as service_status, buy_price, sell_price, service_extras.name as extra_name, seasons.id as season_id, seasons.name as season_name, prices.season_period_id, season_periods.start as season_period_start, season_periods.end as season_period_end, charging_policies.id as policy_id, charging_policies.ts_id as policy_tsid, charging_policies.name as policy_name, charging_policies.room_based as room_based, charging_policies.day_duration as day_duration, priceable_id as extra_id, prices.id as price_id, service_extras.ts_id as extra_tsid, meals.id as meal_id, meals.name as meal_name,monday, tuesday, wednesday, thursday, friday, saturday, sunday from prices join service_extras on (prices.priceable_id = service_extras.id AND priceable_type LIKE '%ServiceExtra') join season_periods on (prices.season_period_id=season_periods.id) join seasons on (season_periods.season_id = seasons.id) join service_policies on (service_policies.price_id = prices.id) join charging_policies on (service_policies.charging_policy_id = charging_policies.id) left join ( meal_options join meals on (meal_options.meal_id = meals.id) ) on (meal_options.service_option_id = service_extras.id) left join week_prices on (prices.id = week_prices.price_id) join services on (services.id = service_extras.service_id) join service_types on (service_types.id = services.service_type_id) join regions on (services.region_id =regions.id ) join suppliers on (services.supplier_id =suppliers.id ) join currencies on (services.currency_id =currencies.id ) join contracts on(services.id = contracts.service_id) join contract_periods on (contract_periods.contract_id = contracts.id) WHERE prices.service_id=? AND service_extras.status IN ($serviceStatus) ", [ $serviceId]);

        $_serviceDataArr = array();
        $contractor_data = array();
        foreach ($serviceExtraData as $service) {
            $service_tsid = trim($service->ts_id);
            $service_id = trim($service->service_id);
            $_serviceDataArr[$service_tsid]['ts_id'] = $service_tsid;
            $_serviceDataArr[$service_tsid]['service_id'] = $service_id;
            $_serviceDataArr[$service_tsid]['service_name'] = trim($service->service_name);
            $_serviceDataArr[$service_tsid]['service_type_id'] = trim($service->service_type_id);
            $_serviceDataArr[$service_tsid]['service_type'] = trim($service->service_type);
            $_serviceDataArr[$service_tsid]['region_id'] = trim($service->region_id);
            $_serviceDataArr[$service_tsid]['region_name'] = trim($service->region_name);
            $_serviceDataArr[$service_tsid]['supplier_id'] = trim($service->supplier_id);
            $_serviceDataArr[$service_tsid]['supplier_name'] = trim($service->supplier_name);
            $_serviceDataArr[$service_tsid]['currency_id'] = trim($service->currency_id);
            $_serviceDataArr[$service_tsid]['currency_code'] = trim($service->currency_code);
            $_serviceDataArr[$service_tsid]['service_status'] = trim($service->service_status);
            $margin = $this->getMarginForSellPrice(trim($service->buy_price), trim($service->sell_price));
            $_serviceDataArr[$service_tsid]['margin'] = trim($margin);
            $_serviceDataArr[$service_tsid]['extras'][trim($service->extra_id)] = array(
                'ts_extra_id' => trim($service->extra_tsid),
                'extra_id' => trim($service->extra_id),
                'extra_name' => trim($service->extra_name),
                'season_period_id' => trim($service->season_period_id),
                'prices_id' => trim($service->price_id),
                'buy_price' => trim($service->buy_price),
                'sell_price' => trim($service->sell_price),
                'margin' => trim($margin),
                'monday' => trim($service->monday),
                'tuesday' => trim($service->tuesday),
                'wednesday' => trim($service->wednesday),
                'thursday' => trim($service->thursday),
                'friday' => trim($service->friday),
                'saturday' => trim($service->saturday),
                'sunday' => trim($service->sunday),
                'policy_id' => trim($service->policy_id),
                'policy_name' => trim($service->policy_name),
                'room_based' => trim($service->room_based),
                'day_duration' => trim($service->day_duration),
                'meal_id' => trim($service->meal_id),
                'meal_name' => trim($service->meal_name)
            );

            $_serviceDataArr[$service_tsid]['extra_prices'][trim($service->extra_id)][trim($service->season_period_id)] = array(
                'ts_extra_id' => trim($service->extra_tsid),
                'extra_id' => trim($service->extra_id),
                'extra_name' => trim($service->extra_name),
                'price_id' => trim($service->price_id),
                'season_id' => trim($service->season_id),
                'season_name' => trim($service->season_name),
                'season_period_id' => trim($service->season_period_id),
                'buy_price' => trim($service->buy_price),
                'sell_price' => trim($service->sell_price),
                'margin' => trim($margin),
                'policy_id' => trim($service->policy_id),
                'policy_name' => trim($service->policy_name)
            );

            $_serviceDataArr[$service_tsid]['seasons_period_extras'][trim($service->season_period_id)] = array(
                'season_for' => 'extra',
                'season_id' => trim($service->season_id),
                'season_name' => trim($service->season_name),
                'season_period_id' => trim($service->season_period_id),
                'season_start' => trim($service->season_period_start),
                'season_end' => trim($service->season_period_end)
            );

            if (!isset($_serviceDataArr[$service_tsid]['all_season_period_ids'][trim($service->season_name)])) {
                $_serviceDataArr[$service_tsid]['all_season_period_ids'][trim($service->season_name)] = array();
            }

            if (!in_array(trim($service->season_period_id), $_serviceDataArr[$service_tsid]['all_season_period_ids'][trim($service->season_name)])) {
                $_serviceDataArr[$service_tsid]['all_season_period_ids'][trim($service->season_name)][] = trim($service->season_period_id);
            }

            $_SESSION['seasons_period_extras'] = $_serviceDataArr[$service_tsid]['seasons_period_extras'];

            if (!array_key_exists(trim($service->season_period_id), $contractor_data)) {
                $contractor_data[trim($service->season_period_id)] = $this->getContractorDataForSeasonPeriod(trim($service->season_period_id));
            }
            $_serviceDataArr[$service_tsid]['seasons'][trim($service->season_name)]['season_id'] = trim($service->season_id);
            $_serviceDataArr[$service_tsid]['seasons'][trim($service->season_name)]['season_name'] = trim($service->season_name);

            $_serviceDataArr[$service_tsid]['seasons'][trim($service->season_name)]['seasons_period'][trim($service->season_period_id)] = array(
                'season_for' => 'Extra',
                'season_period_id' => trim($service->season_period_id),
                'season_start' => trim($service->season_period_start),
                'season_end' => trim($service->season_period_end),
                'contractor_data' => $contractor_data[$service->season_period_id]
            );

            $_serviceDataArr[$service_tsid]['contracts'][trim($service->contract_id)] = array(
                'contract_id' => trim($service->contract_id),
                'contract_name' => trim($service->contract_name),
                'contract_period_id' => trim($service->contract_period_id),
                'contract_period_name' => trim($service->contract_period_name),
                'contract_period_start' => trim($service->contract_period_start),
                'contract_period_end' => trim($service->contract_period_end)
            );
        }

        return $_serviceDataArr;
    }

    /**
     * 
     * @param array( of objects) $serviceObj
     * @param string $serviceIds
     * @param int $status
     * @param float $margin
     * @return NULL
     */
    public function UpdateServicesFromList($serviceObj, $serviceIds, $status = NULL, $margin = NULL) {
        $selected_serviceIds_arr = explode(',', $serviceIds);
        foreach ($serviceObj as $serviceData) {
            if (in_array($serviceData->service_id, $selected_serviceIds_arr)) {
                if (!empty($margin)) {
                    $sellPrice = $this->getSellPriceForMargin($serviceData->buy_price, $margin);
                    $this->updateServiceOptionPrice($serviceData->service_id);
                }
                if (!empty($status)) {
                    $this->updateServiceStatus($serviceData->service_id);
                }
            }
        }
    }

    /**
     * 
     * @param float $buyPrice
     * @param float $margin
     * @return float $sellPrice
     */
    public static function getSellPriceForMargin($buyPrice, $margin) {
        // //►Margin Calculation should be based on revenue system, I will speak to you on this Eg: $ 100/(1-29%) = $133 and not $100+29% =$129
        
        $sellPrice = $buyPrice / (1- ($margin/ 100));
        
        
        //$sellPrice = $buyPrice + ($buyPrice * ($margin / 100));
        return number_format($sellPrice, 2);
    }

    /**
     * 
     * @param float $buyPrice
     * @param float $sellPrice
     * @return float $margin
     */
    public static function getMarginForSellPrice($buyPrice, $sellPrice) {
//Gross Margin Percentage = (Gross Profit/Sales Price) X 100 = ($25/$125) X 100 = 20%.
        if ($buyPrice == 0) {
            return 0;
        }
        $margin = (($sellPrice - $buyPrice) / $buyPrice) * 100;
        return round($margin);        
    }

    /**
     * 
     * @param int $serviceId
     * @param int $status
     * @return NULL
     */
    public function updateServiceStatus($serviceId, $status) {
        $str = "update services set status = " . $status . ", updated_at = NOW() where service_id = $serviceId ";
        $str .= $str_optionId;
        $str .= $str_priceId;

        //DB::statement($str); 
    }

    /**
     * 
     * @param int $serviceId
     * @param float $sellPrice
     * @param string $optionId
     * @param string $priceId
     * @return NULL
     */
    public function updateServiceOptionPrice($serviceId, $sellPrice, $optionId = NULL, $priceId = NULL) {
        $str_optionId = '';
        $str_priceId = '';
        if (!empty($optionId)) {
            $str_optionId = " AND priceable_id IN ($optionId) ";
        }
        if (!empty($priceId)) {
            $str_priceId = " AND id IN ($priceId) ";
        }

        $str = "update prices set sell_price = " . $sellPrice . " , updated_at = NOW() where service_id = $serviceId ";
        $str .= $str_optionId;
        $str .= $str_priceId;

        // DB::statement($str);        
    }

    public function getServiceSeasonPeriodsData($getMandatoryExtra=false) {


//print('<xmp>');
//print_r($getMandatoryExtra);
//print('</xmp>');

        $seasons_raw = array();
        $seasonPeriods_raw = array();
        $options_raw = array();
        $extras_raw = array();
        $options_raw_all = array();
        $extras_raw_all = array();
        $options_raw_all_1 = array();
        $extras_raw_all_1 = array();
        $output_options_raw_all = array();
        $output_extras_raw_all = array();

        $serviceId = Input::get('service_id');
        $optionId = Input::get('option_id');
        $option_page_no = Input::get('option_page_no');
        $extra_page_no = Input::get('extra_page_no');
        
        
        $options_date_range_from = Input::get('options_date_range_from');
        $options_date_range_to = Input::get('options_date_range_to');
        $prices_options_table_status = Input::get('prices_options_table_status');
        $whereParamsOptions=array('from' => $options_date_range_from, 'to' => $options_date_range_to, 'status' => $prices_options_table_status);
        
        $extras_date_range_from = Input::get('extras_date_range_from');
        $extras_date_range_to = Input::get('extras_date_range_to');
        $prices_extras_table_status = Input::get('prices_extras_table_status');
        $whereParamsExtras=array('from' => $extras_date_range_from, 'to' => $extras_date_range_to, 'status' => $prices_extras_table_status);
        
        
        $rawData = false;
        $serviceStatus = '0,1';
        $whereCreiteria = array();
        $seasonPeriodArr = $this->serviceDataRepo->getAllSeasonPeriodsForPerticularService($serviceId);
        $servicesCurrencyObj = '';
        
        
//        $servicesCurrencyObj = DB::table('services')
//                ->join('currencies', 'currencies.id', '=', 'services.currency_id')
//                ->select('currencies.id as service_currency_id', 'currencies.code as service_currency_code')
//                ->where('services.id', '=', $serviceId)
//                ->get();
    
        $servicesCurrencyObj = DB::table('currencies')                
                ->select('currencies.id as service_currency_id', 'currencies.code as service_currency_code')
                ->where('currencies.id', '=',  self::DEFAULT_CURRENCY_ID)
                ->get();

  
        if (!empty($seasonPeriodArr['contractPeriodId'])) {
            foreach ($seasonPeriodArr['contractPeriodId'] as $k => $contractPeriodId) {

                $contractId = $seasonPeriodArr['contractId'][$k];
                $seasonsObj = $this->serviceDataRepo->getSeasonsForContractPeriods($contractPeriodId, $whereCreiteria);
                $seasons['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId] = $seasonsObj;
                $seasons_raw[] = $seasonsObj;
                if (count($seasonsObj) > 0) {
                    foreach ($seasonsObj as $season) {
                        $seasonPeriodsObj = $this->serviceDataRepo->getSeasonPeriodsForSeason($serviceId, $season->id);
                        $seasonPeriods['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $season->id] = $seasonPeriodsObj;
                        $seasonPeriods_raw[] = $seasonPeriodsObj;
                        /*                         * **************** */

                        foreach ($seasonPeriodsObj as $seasonPeriodsArrObj) {



                            $seasonPeriodId = $seasonPeriodsArrObj->season_period_id;
                            $seasonPeriodArr['season_period_id'] = $seasonPeriodsArrObj->season_period_id;
                            $seasonPeriodArr['season_id'] = $seasonPeriodsArrObj->season_id;
                            $seasonPeriodArr['season_period_start'] = $seasonPeriodsArrObj->season_period_start_date;
                            $seasonPeriodArr['season_period_end'] = $seasonPeriodsArrObj->season_period_end_date;
                            $contractArr = array('contract_id' => $contractId, 'contract_period_id' => $contractPeriodId, 'season_id' => $season->id);
                            $seasonPeriodsArrObj = (object) array_merge((array) $seasonPeriodsArrObj, (array) $contractArr, (array)$servicesCurrencyObj[0]);

                            
//($serviceId = NULL, $seasonPeriodId = NULL, $seasonPeriodsArrObj = null, $whereParams = array())
                            
                            $optionObj = $this->serviceDataRepo->getOptionsWithPriceForSeasonPeriod($serviceId, $seasonPeriodId, $seasonPeriodsArrObj,$whereParamsOptions);
                            //$optionObj = array_merge();
                            $options_all['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $season->id]['SeasonPeriodID:' . $seasonPeriodId] = $optionObj;
                            $options_raw_all[] = $optionObj;

                            $extraObj = $this->serviceDataRepo->getExtrasWithPriceForSeasonPeriod($serviceId, $seasonPeriodId, $seasonPeriodsArrObj,$whereParamsExtras);
                            $extras_all['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $season->id]['SeasonPeriodID:' . $seasonPeriodId] = $extraObj;
                            $extras_raw_all[] = $extraObj;
                        }

                        /*                         * **************** */
                    }
                }
            }



            //////////// for one season periods - start /////////////////
            $seasonPeriodId = $seasonPeriods_raw[0][0]->season_period_id;
            $optionObj = $this->serviceDataRepo->getOptionsWithPriceForSeasonPeriod($serviceId, $seasonPeriodId);

            $options['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $season->id]['SeasonPeriodID:' . $seasonPeriodId] = $optionObj;
            $options_raw[] = $optionObj;

            
            $extraObj = $this->serviceDataRepo->getExtrasWithPriceForSeasonPeriod($serviceId, $seasonPeriodId);

            $extras['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $season->id]['SeasonPeriodID:' . $seasonPeriodId] = $extraObj;
            $extras_raw[] = $extraObj;
            //////////// for one season periods - end //////////////
            //////////// for all season periods -  Start //////////////
            /* foreach($seasonPeriods_raw as $seasonPeriodsObjArr) {
              if(is_array($seasonPeriodsObjArr)) {
              foreach($seasonPeriodsObjArr as $seasonPeriodsObj) {
              $seasonPeriodId = $seasonPeriodsObj->id;
              $optionObj = $this->serviceDataRepo->getOptionsWithPriceForSeasonPeriod($serviceId, $seasonPeriodId);
              $options_all['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $season->id]['SeasonPeriodID:' . $seasonPeriodId] = $optionObj;
              $options_raw_all[] = $optionObj;

              $extraObj = $this->serviceDataRepo->getExtrasWithPriceForSeasonPeriod($serviceId, $seasonPeriodId);
              $extras_all['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $season->id]['SeasonPeriodID:' . $seasonPeriodId] = $extraObj;
              $extras_raw_all[] = $extraObj;

              }
              }
              } */
            //////////// for all season periods -  End //////////////
        }
        $options_raw_all_1 = array();
        foreach ($options_raw_all as $k => $v) {
            //self::NO_OF_RECORDS_PER_PAGE)
            $options_raw_all_1 = array_merge($options_raw_all_1, $v);
        }

//        print('<xmp>');
//        print_r($extras_raw_all);
//        print('</xmp>');
        
        $extras_raw_all_1 = array();
        foreach ($extras_raw_all as $k => $v) {
            //echo 'price_id : '.$v['price_id'].'<br>';
            $extras_raw_all_1 = array_merge($extras_raw_all_1, $v);
        }
        
        $mandatoryExtra = array();
        $mandatoryExtraKey = '';

        
        if(!empty($getMandatoryExtra)) {
            
            $multipleMandatoryExtra_arr = explode(',',$getMandatoryExtra['extraId']);
            foreach($extras_raw_all_1 as $k => $v) {
    
                if(in_array($v->extra_id,$multipleMandatoryExtra_arr ) && $v->prices_season_period_start == $getMandatoryExtra['optStartDate'] && $v->prices_season_period_end == $getMandatoryExtra['optEndDate'] ) {
//                if($v->extra_id == $getMandatoryExtra['extraId'] && $v->prices_season_period_start == $getMandatoryExtra['optStartDate'] && $v->prices_season_period_end == $getMandatoryExtra['optEndDate'] ) {
//                    $mandatoryExtra = (array)$v;
//                    $mandatoryExtra['mandatory_for_option_id'] = $getMandatoryExtra['optionId'];
                    
                    $v->extra_is_mandatory = 1;
//                    print('2222222222222<xmp>');
//                    print_r($v);
//                    print('</xmp>44444444444444444444');
                    
                    
                    $mandatoryExtraKey[] = $k;
                    $mandatoryExtra[] = array_merge((array)$v,array('mandatory_for_option_id' => $getMandatoryExtra['optionId']));
                    
                    //break;
                }
                
            }
        }
        
//        print('$mandatoryExtraKey : '.$mandatoryExtraKey.'<br>');
//        print('<xmp>');
//        print_r($mandatoryExtra);
//        print('</xmp>');
        
        if(!empty($mandatoryExtraKey)) {
            foreach($mandatoryExtraKey as $kkk => $vvv) {
                unset($extras_raw_all_1[$mandatoryExtraKey[$kkk]]);
                array_unshift($extras_raw_all_1 , (object)$mandatoryExtra[$kkk]);
            }
        }
        
        
        //die('93666666666666');
//        foreach($extras_raw_all_1 as $k => $v) {
//            print('<xmp>');
//print_r($v->price_id);
//print('</xmp>');
//        }

//echo '$page_no : '.$page_no.'<br>';

        $option_page_start = (int) ($option_page_no-1) * self::NO_OF_RECORDS_PER_PAGE;
        if($option_page_start < 0) {
            $option_page_start = 0;
        }
        $option_page_end = self::NO_OF_RECORDS_PER_PAGE;
        
        $extra_page_start = (int) ($extra_page_no-1) * self::NO_OF_RECORDS_PER_PAGE;
        if($extra_page_start < 0) {
            $extra_page_start = 0;
        }
        $extra_page_end = self::NO_OF_RECORDS_PER_PAGE;
        
        
        if (!empty($options_raw_all_1)) {
            $output_options_raw_all = array_slice($options_raw_all_1, $option_page_start, $option_page_end);
        }
        if (!empty($extras_raw_all_1)) {        
            $output_extras_raw_all = array_slice($extras_raw_all_1, $extra_page_start, $extra_page_end);            
        }
        $total_pages_options = ceil(count($options_raw_all_1)/self::NO_OF_RECORDS_PER_PAGE);
        $total_pages_extras = ceil(count($extras_raw_all_1)/self::NO_OF_RECORDS_PER_PAGE);

//        print('<xmp>');
//        print_r($output_options_raw_all);
//        print('</xmp>');
//        
//        foreach($output_options_raw_all as $v) {
//            echo $v->option_id."<br>";
//        }
        
        $data = array(
            //'seasons' => $seasons_raw,
            'seasonPeriods' => $seasonPeriods_raw,
            'options' => $options_raw,
            'extras' => $extras_raw,
            'options_all' => $output_options_raw_all, //$options_raw_all_1,            
            'extras_all' => $output_extras_raw_all, //$extras_raw_all_1
            'total_pages_options' => $total_pages_options, 
            'total_pages_extras' => $total_pages_extras,
            'mandatoryExtra' => $mandatoryExtra
            
        );

        
        
       if(!empty($getMandatoryExtra)) {
           return $data;
       }      
       
        return json_encode($data);
        
    }

    public function getServiceDataForSeasonPeriod() {

        $serviceId = Input::get('service_id');
        $contractId = Input::get('contract_id');
        $contractPeriodId = Input::get('contract_period_id');
        $seasonId = Input::get('season_id');
        $seasonPeriodId = Input::get('season_period_id');
        $rawData = false;
        $serviceStatus = '0,1';

        $optionObj = $this->serviceDataRepo->getOptionsWithPriceForSeasonPeriod($serviceId, $seasonPeriodId);
        $options['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $seasonId]['SeasonPeriodID:' . $seasonPeriodId] = $optionObj;
        $options_raw[] = $optionObj;

        $extraObj = $this->serviceDataRepo->getExtrasWithPriceForSeasonPeriod($serviceId, $seasonPeriodId);
        $extras['contractID:' . $contractId]['contractPeriodID:' . $contractPeriodId]['SeasonID:' . $seasonId]['SeasonPeriodID:' . $seasonPeriodId] = $extraObj;
        $extras_raw[] = $extraObj;

        $data = array(
            'options' => $options_raw,
            'extras' => $extras_raw
        );
        return json_encode($data);
    }
    
    public function getPriceBandAndWeekPriceData() {
        $serviceId = Input::get('service_id');
        $optionId = Input::get('option_id');
        $seasonPeriodId = Input::get('seasonPeriodId');
        $isPriceBandOrWeekPrices = Input::get('isPriceBandOrWeekPrices');
        $dataFor = Input::get('dataFor');
        $data = false;
        
        $charging_policies = $this->getAllChargingPolicies();
        
        if($isPriceBandOrWeekPrices == 'pricebands') {
            $data = $this->serviceDataRepo->getPriceBandsData($serviceId,$optionId, $seasonPeriodId, $dataFor);
        } else if($isPriceBandOrWeekPrices == 'weekprices') {
            $data = $this->serviceDataRepo->getWeekpricesData($serviceId,$optionId, $seasonPeriodId, $dataFor);
        }     
        $data['charging_policies'] = $charging_policies;
                        
        return json_encode($data);
        
    }
    
    public function linkOptionsWithExtras() {
        $this->serviceDataRepo->linkOptionsWithExtras();
        $data = array(
            'message' => 'Mandatory Extra set successfully'
        );
        return json_encode($data);
    }
    
    public function getExtrasWithIsMandatoryForOption() {
        $serviceId = Input::get('service_id');
        $optionId = Input::get('option_id');
        $extraId = Input::get('extra_id');
        $optStartDate = Input::get('opt_start_date');
        $optEndDate = Input::get('opt_end_date');
        
        $getMandatoryExtraArr=array('serviceId' => $serviceId, 'optionId' => $optionId, 'extraId' => $extraId,'optStartDate' => $optStartDate, 'optEndDate' => $optEndDate );
        
        $d = $this->getServiceSeasonPeriodsData($getMandatoryExtraArr); 
        //$d1 = (array)json_decode($d);        
        $d1 = $d;        
        $output_extras_raw_all = $d1['extras_all']; 
        
//        print('=========== <br> $getMandatoryExtraArr<xmp>');
//        //print_r($d);
//        print_r($getMandatoryExtraArr);
//        print('<xmp>');
////        
//        print('123<xmp>');
//        print_r($output_extras_raw_all);
//        print('<xmp>');
//////        
//        die('1044');
//        
        $data = array('extras_all' => $output_extras_raw_all);
        return json_encode($data);
    }

    public function deleteWeekPrices() { 
        $weekPricesAvailable = $this->serviceDataRepo->deleteWeekPrices();
        $data = array(
            'status' => $weekPricesAvailable,
            'message' => 'Week Price record deleted (soft-delete) successfully'
        );
        return json_encode($data);
    }
    
    public function deletePriceBands() {
        
        $pricesBandsAvailable = $this->serviceDataRepo->deletePriceBands();
        $data = array(
            'status' => $pricesBandsAvailable,
            'message' => 'Price Band record deleted (soft-delete) successfully'
        );
        return json_encode($data);
    }
    
    public function deleteServicesPermanently() {        
        
        $this->serviceDataRepo->deleteServicesPermanently();
        $data = array(
            'message' => 'Success'
        );
        return json_encode($data);
    }
    
    public function updateExchangeRatesFromCSV() {
        
//        $this->serviceDataRepo->bulkUploadServiceDataWithCSV();
//        
//        die();
        
        $dataToView = array(
            'todo_action' => 'updateExchangeRatesFromCSV',
            'todo_submit_action' => 'updateExchangeRates',
        );
        
        return View::make('pages.upload_file', $dataToView);
        
    }
    public function deleteServicesPermanentlyFromCSV() {
        $dataToView = array(
            'todo_action' => 'deleteServicesPermanently',
            'todo_submit_action' => 'deleteServicesPermanently',
        );
        
        return View::make('pages.upload_file', $dataToView);
    }
    public function updateExchangeRates() {
        $this->serviceDataRepo->updateExchangeRatesFromCSV();
        $data = array(
            'message' => 'Success'
        );
        return json_encode($data);
    }
    
    public function optionsExtraMappingFromCSV() {
        
        $dataToView = array(
            'todo_action' => 'optionsExtraMappingFromCSV',
            'todo_submit_action' => 'optionsExtraMapping',
        );
        
        return View::make('pages.upload_file', $dataToView);
    }
    
    public function optionsExtraMapping() {
        $this->serviceDataRepo->optionsExtraMapping();
        $data = array(
            'message' => 'Success'
        );
        return json_encode($data);
    }

    public function updateCityFromCSV() {
        
        $dataToView = array(
            'todo_action' => 'updateCityFromCSV',
            'todo_submit_action' => 'updateCity',
        );
        
        return View::make('pages.upload_file', $dataToView);
    }
    
    public function updateCity() {
        $this->serviceDataRepo->updateCity();
        $data = array(
            'message' => 'Success'
        );
        return json_encode($data);
    }
    
    public function OptionsInactiveFromCSV() {
        
        $dataToView = array(
            'todo_action' => 'OptionsInactiveFromCSV',
            'todo_submit_action' => 'OptionsInactive',
        );
        
        return View::make('pages.upload_file', $dataToView);
    }
    
    public function OptionsInactive() {
        $this->serviceDataRepo->Options_iNactive();
        $data = array(
            'message' => 'Success'
        );
        return json_encode($data);
    }
    
    public function updateOptionsIsDefaultForAllOccupany() {
        $this->serviceDataRepo->updateOptionsIsDefaultForAllOccupany();
        $data = array(
            'message' => 'Success'
        );
        return json_encode($data);
    }

    public function updateServiceShortNameFromCSV() {

        $dataToView = array(
            'todo_action' => 'updateServiceShortNameFromCSV',
            'todo_submit_action' => 'updateServiceShortName',
        );

        return View::make('pages.upload_file', $dataToView);
    }
    public function updateServiceShortName() {
        $this->serviceDataRepo->updateServiceShortNameFromCSV();
        $data = array(
            'message' => 'Success'
        );
        return json_encode($data);
    }
}
