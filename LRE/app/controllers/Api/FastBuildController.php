<?php

namespace App\Controllers;

use BaseController;
use Input;
use Validator;
use Response;
use App\Repositories\FastBuildRepository;

class FastBuildController extends BaseController {
     public $fastBuildRules = [
            'service_tsid' => 'required',
            'region_tsid' => 'required'
        ];

    public function __construct(FastBuildRepository $fastBuildRepo) {
        $this->fastBuildRepo = $fastBuildRepo;
    }

//     public $requestData = array(
//     	"fast_build_type" => "service",
//         "service_tsid" => 500010,
//         "service_name" => "Fast Build Testing 2",
//         "supplier_name" => "Enchanting Travels",
//         "service_type" => 2,
//         "meals" => "Breakfast",
//         "currency" => "USD",
//         //"region_tsid" => 10000000,
//         "option" => array(
//         	array(
//	             "option_name" => "Service Option Fast Build Testing",
//	             "occupancy_id" => 2,
//	             "start_date" => "2015-10-10",
//	             "end_date" => "2015-10-20",
//	             "buy_price" => 1300,
//	             "sell_price" => 1500
//             )
//         ),
//         "region_tsid" => '100000',
//         "region_name" => "Murugeshpalay",
//         "parent_region_id" => 11016
//     );

    public function createServiceOrCity() {  
        
        $requestData = Input::all();
        $requestData = json_decode(Input::get('data'), true);
        $str_message = '';
        if(isset($requestData["service_tsid"]) && $requestData["service_tsid"] === '') {
            $str_message .= " Service-Tsid should not be empty. ";
        }
        if(isset($requestData["region_tsid"]) && $requestData["region_tsid"] === '') {
            $str_message .= " Region-Tsid should not be empty. ";
        }
        if(isset($requestData["service_name"]) && $requestData["service_name"] === '') {
            $str_message .= " Service Name should not be empty. ";
        }
        if(isset($requestData["supplier_name"]) && $requestData["supplier_name"] === '') {
            $str_message .= " Supplier Name should not be empty. ";
        }
        if(isset($requestData["service_type"]) && $requestData["service_type"] === '') {
            $str_message .= " service_type should not be empty. ";
        }
//        if(isset($requestData["currency"]) && $requestData["currency"] === '') {
//            $str_message .= " Currency should not be empty. ";
//        }
//        if(isset($requestData["region_name"]) && $requestData["region_name"] === '') {
//            $str_message .= " Region Name should not be empty. ";
//        }
        
        if ($requestData["fast_build_type"] == "service") {
            if(!isset($requestData["option"])) {
                $str_message .= " Service Should have atleast one option. ";
            } 
        }
        
        
        if($str_message !== '') {
             return Response::json(array('Error' => $str_message));
        }

        if ($requestData["fast_build_type"] == "service") {
            $response = $this->fastBuildRepo->createService($requestData);
        } else {
            $response = $this->fastBuildRepo->createCity($requestData);
        }

        if (isset($response)) {
            return Response::json($response, 200);
        }
    }

    public function callFunction($funcName) {
        if (method_exists($this, $funcName)) {
            return call_user_func([$this, $funcName]);
        } else {

            return Response::json(array('Error' => "Please check the API Url"));
        }
    }

}
