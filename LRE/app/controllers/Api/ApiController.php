<?php

namespace App\Controllers;

use BaseController;
use Input;
use Validator;
use Response;
use App\Repositories\RatesRepository;
use App\Services\TravelStudioService;
use App\Services\ApiService;

define('FAST_BUILD_SERVICE_ID_RANGE_STARTING_FROM', '500000');

class ApiController extends BaseController
{
    public $serviceRules = [
        'SERVICEIDs' => 'required',
        'SERVICETYPEID' => 'required|exists:service_types,id',
        'START_DATE' => 'required|date',
        'NUMBER_OF_NIGHTS' => 'required|numeric'
    ];
    public $serviceExtraRules = [
        "SERVICEID" => "required|numeric",
        "FROMDATE" => "required|date",
        "TODATE" => "required|date",
        'SERVICETYPEID' => 'required|exists:service_types,id' // added to send the request to TS for activity and guide /// so we need to validate SERVICETYPEID - else throw error
    ];
    public $serviceInfoRules  = [
        "ServiceID" => "required|numeric",
        "StartDate" => "required|date",
        "EndDate" => "required|date",
        'ServiceTypeID' => 'required|exists:service_types,id' // added to send the request to TS for activity and guide /// so we need to validate SERVICETYPEID - else throw error
    ];

    // public $requestData = array ( 'IncomingRequest' => array ( 'ROOMS_REQUIRED' => array ( 'ROOM' => array ( 0 => array ( 'OCCUPANCY' => '3', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 2, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '0', 'CHILD_AGE' => '5', ), ), ), 1 => array ( 'OCCUPANCY' => '7', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 1, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '1', 'CHILD_AGE' => '5', ), ), ), 2 => array ( 'OCCUPANCY' => '8', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 4, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '2', 'CHILD_AGE' => '5', ), ), ), 3 => array ( 'OCCUPANCY' => '6', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 15, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '10', 'CHILD_AGE' => '5', ), ), ), 4 => array ( 'OCCUPANCY' => '5', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 4, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '0', 'CHILD_AGE' => '5', ), ), ), 5 => array ( 'OCCUPANCY' => '1', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 2, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '1', 'CHILD_AGE' => '5', ), ), ), 6 => array ( 'OCCUPANCY' => '4', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 3, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '0', 'CHILD_AGE' => '5', ), ), ), 7 => array ( 'OCCUPANCY' => '2', 'QUANTITY' => 1, 'NO_OF_PASSENGERS' => 2, 'CHILDREN' => array ( 'CHILD_RATE' => array ( 'CHILD_QUANTITY' => '0', 'CHILD_AGE' => '5', ), ), ), ), ), 'VERSION_HISTORY' => array ( 'LANGUAGE' => 'en-GB', 'LICENCE_KEY' => 'A6C2FAAA-62D7-4A1B-9AB5-C6BF801E7803', ), 'ISMEALPLANSREQUIRED' => 0, 'IMAGENOTREQUIRED' => 1, 'ReturnMatchCode' => 'true', 'SEARCHWITHFACILITIES_OPTIONS' => 'ALL', 'NotesRequired' => false, 'SERVICEIDs' => '1210', 'START_DATE' => '10/11/2015', 'NUMBER_OF_NIGHTS' => 1, 'AVAILABLE_ONLY' => false, 'GET_START_PRICE' => true, 'CURRENCY' => 'USD', 'SERVICETYPEID' => 2, 'RETURN_ONLY_NON_ACCOM_SERVICES' => false, 'ROOM_REPLY' => array ( 'ANY_ROOM' => 'true', ), 'DoNotReturnNonRefundable' => false, 'DoNotReturnWithCancellationPenalty' => false, 'BESTSELLER' => false, 'CLIENT_ID' => 0, 'BOOKING_TYPE_ID' => 0, 'BOOKINGTYPE' => 0, 'PRICETYPE' => 0, 'SERVICETYPERATINGTYPEID' => 0, 'SERVICETYPERATINGID' => 0, 'IsServiceOptionDescriptionRequired' => 'true', 'IsServiceInfoRequired' => 'true', 'ReturnMandatoryExtraPrices' => false, 'NATIONALITYID' => 0, 'ReturnAttachedOptionExtra' => false, 'SERVICESEARCHTYPE' => 'ENHANCED', 'ReturnAppliedOptionChargingPolicyDetails' => false, ), );

    public function __construct(RatesRepository $ratesRepo,
                                TravelStudioService $tsService,
                                ApiService $apiService)
    {
        $this->ratesRepo  = $ratesRepo;
        $this->tsService  = $tsService;
        $this->apiService = $apiService;
    }

    public function GetServicesPricesAndAvailability()
    {
        // $requestData = json_decode(json_encode($this->requestData), true);
        $requestData = json_decode(Input::get('data'), true);
        $validator   = Validator::make($requestData['IncomingRequest'],$this->serviceRules);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $key => $message) {
                $message = str_replace('s ta rt  da te','start date', $message);
                $message = str_replace('s er vi ce ty pe id','service type id', $message);
                $response["GetServicesPricesAndAvailabilityResult"]["Errors"]["Error"][]["Description"] = $message;
            }
        } else {
            if (isset($requestData['IncomingRequest']["ROOMS_REQUIRED"]["ROOM"]["QUANTITY"])) {
                $rooms = [$requestData['IncomingRequest']["ROOMS_REQUIRED"]["ROOM"]];
                $quantity_g       = $requestData['IncomingRequest']["ROOMS_REQUIRED"]["ROOM"]['QUANTITY'];
                $noOfPassengers_g = $requestData['IncomingRequest']["ROOMS_REQUIRED"]["ROOM"]['NO_OF_PASSENGERS'];
            } else {
                $rooms = $requestData['IncomingRequest']["ROOMS_REQUIRED"]["ROOM"];
                $quantity_g       = $requestData['IncomingRequest']["ROOMS_REQUIRED"]["ROOM"][0]['QUANTITY'];
                $noOfPassengers_g = $requestData['IncomingRequest']["ROOMS_REQUIRED"]["ROOM"][0]['NO_OF_PASSENGERS'];
            }

            if (array_key_exists('STATUS_CHECK_FLAG', $requestData['IncomingRequest'])) {  // TMR Request
                $requestData['IncomingRequest']["REQUEST_FROM_TMR"] = true;
            } else {
                $requestData['IncomingRequest']["REQUEST_FROM_TMR"]  = false;
                $requestData['IncomingRequest']["STATUS_CHECK_FLAG"] = true;
            }

            if($requestData['IncomingRequest']['SERVICEIDs'] > FAST_BUILD_SERVICE_ID_RANGE_STARTING_FROM) {
                unset($this->apiService->ratesRepository);
                $this->apiService->ratesRepository = $this->apiService->fastbuildRatesRepository;
            }
            
            $response = $this->apiService->collectServicePrices($requestData['IncomingRequest']['SERVICEIDs'],
                $requestData['IncomingRequest']['START_DATE'],
                $requestData['IncomingRequest']['NUMBER_OF_NIGHTS'],
                $requestData['IncomingRequest']["CURRENCY"], $rooms,
                $quantity_g, $noOfPassengers_g,
                $requestData['IncomingRequest']["STATUS_CHECK_FLAG"]);


            if (!$this->apiService->isRatesAvailableLocally && $requestData['IncomingRequest']['SERVICEIDs'] < FAST_BUILD_SERVICE_ID_RANGE_STARTING_FROM) {
                $funcName = __FUNCTION__;
                if ($requestData['IncomingRequest']["REQUEST_FROM_TMR"] === false) {
                    $response = $this->apiService->pullRatesFromTravelStudio($funcName,$requestData);
                }
            }


            if (is_object($response) && empty($response->GetServicesPricesAndAvailabilityResult->Services->PriceAndAvailabilityService->ServiceOptions)) {
                $checkforError = array('contractPeriod');
                $response      = $this->apiService->collectServicePrices($requestData['IncomingRequest']['SERVICEIDs'],
                    $requestData['IncomingRequest']['START_DATE'],
                    $requestData['IncomingRequest']['NUMBER_OF_NIGHTS'],
                    $requestData['IncomingRequest']["CURRENCY"], $rooms,
                    $quantity_g, $noOfPassengers_g,
                    $requestData['IncomingRequest']["STATUS_CHECK_FLAG"],
                    $checkforError);
            } else if (is_array($response) && empty($response['GetServicesPricesAndAvailabilityResult']['Services']['PriceAndAvailabilityService']['ServiceOptions'])) {
                $checkforError = array('contractPeriod');
                $response      = $this->apiService->collectServicePrices($requestData['IncomingRequest']['SERVICEIDs'],
                    $requestData['IncomingRequest']['START_DATE'],
                    $requestData['IncomingRequest']['NUMBER_OF_NIGHTS'],
                    $requestData['IncomingRequest']["CURRENCY"], $rooms,
                    $quantity_g, $noOfPassengers_g,
                    $requestData['IncomingRequest']["STATUS_CHECK_FLAG"],
                    $checkforError);
            }

            if (empty($response)) {

                $response                                                     = array(
                    'GetServicesPricesAndAvailabilityResult' => array(
                        'Services' => array(
                            'PriceAndAvailabilityService' => array(
                                'ServiceID' => $requestData['IncomingRequest']['SERVICEIDs'],
                                'ServiceCode' => $requestData['IncomingRequest']['SERVICEIDs'],
                            )
                        ),
                        'Warnings' => (object) array()
                    )
                );
                $response["GetServicesPricesAndAvailabilityResult"]["Errors"] = json_decode(json_encode(['Error' => [ 'Description' => 'Service not found']]));
            }
        }
        if (isset($response)) {
            return Response::json($response, 200);
        }
    }

//      public $extraRequest = array("IncomingRequest" => 
//          array( "Authenticate" => 
//             array("LICENSEKEY" => "A6C2FAAA-62D7-4A1B-9AB5-C6BF801E7803", "PASSENGERID" => "0", "Connector" => "enmTS"),
//             "BOOKING_TYPE_ID" => 0 ,
//             "PRICE_TYPE_ID" => 0,
//             "PriceCode" => 0,
//             "SERVICEID" => 1210,
//             "FROMDATE" => "2018-04-01",
//             "TODATE" => "2018-04-02",
//             "ReturnLinkedServiceOptions" => false,
//             "IGNORECHILDAGE" => false,
//             "RETURNONLYNONACCOMODATIONSERVICES" => true,
//             "APPLYEXCHANGERATES" => true,
//             "CURRENCYISOCODE" => "EUR" ,
//             "ClientId" => 0,
//             "ReturnAppliedChargingPolicyDetails" => true,
//             "ExtrasRequired" => array("ExtraDetail" => array("OccupancyID" => 1, "Quantity" => 10, "Adults" => 2))
//          )
//      );

    public function GetServiceExtraPrices()
    {
        // $extraRequest = $this->extraRequest;         
        $extraRequest = json_decode(Input::get('data'), true);

        if (empty($extraRequest["IncomingRequest"]["CURRENCYISOCODE"])) {
            $extraRequest["IncomingRequest"]["CURRENCYISOCODE"] = NULL;
        }
        $extraRequest["IncomingRequest"]["SERVICETYPEID"] = $extraRequest['IncomingRequest']['VEHICLE']['ServiceTypeID']; // added to send the request to TS for activity and guide /// so we need to validate SERVICETYPEID - else throw error

        if (array_key_exists('STATUS_CHECK_FLAG',$extraRequest['IncomingRequest'])) {  // TMR Request
            $extraRequest['IncomingRequest']["REQUEST_FROM_TMR"] = true;
        } else {
            $extraRequest['IncomingRequest']["REQUEST_FROM_TMR"]  = false;
            $extraRequest['IncomingRequest']["STATUS_CHECK_FLAG"] = true;
        }

        $validator = Validator::make($extraRequest['IncomingRequest'],$this->serviceExtraRules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $key => $message) {
                $message = str_replace('s ta rt  da te','start date', $message);
                $message = str_replace('s er vi ce id','service id', $message);
                $message = str_replace('f ro md at e','from date', $message);
                $message = str_replace('t od at e','to date', $message);
                $message = str_replace('s er vi ce ty pe id','service type id', $message);
                $response["ServiceExtrasAndPricesResponse"]["Errors"]["Error"][]["Description"] = $message;
            }
        } else {
            $tsCallServiceTypeIDArr = array('3', '5'); // for activities(3) and guide(5)
            $tsCallServiceTypeIDArr = array(); // Don't go to TS for depending on serviec type -  follow regular logic

            $chkServiceTypeID = $extraRequest["IncomingRequest"]["SERVICETYPEID"];
           
            if (in_array($chkServiceTypeID, $tsCallServiceTypeIDArr)) { //from activities(3) and guide(5)
                $funcName = __FUNCTION__;

                if ($extraRequest['IncomingRequest']["REQUEST_FROM_TMR"] === false) {
                    $response = $this->tsService->pullRates($funcName,$extraRequest);
                    if(!empty($response->ServiceExtrasAndPricesResponse->ResponseList->ServiceExtras)) {
                        foreach($response->ServiceExtrasAndPricesResponse->ResponseList->ServiceExtras as $k => $v) {
                            $response->ServiceExtrasAndPricesResponse->ResponseList->ServiceExtras[$k]->TotalBuyPrice = '-NO-VALUE-FROM-TS-';
                        }
                    }
                }
            } else { // apart from activities(3) and guide(5)
                $response = $this->apiService->collectExtraPrices($extraRequest['IncomingRequest']['SERVICEID'],
                    $extraRequest['IncomingRequest']['FROMDATE'],
                    $extraRequest['IncomingRequest']['TODATE'],
                    $extraRequest["IncomingRequest"]["CURRENCYISOCODE"],
                    $extraRequest['IncomingRequest']["ExtrasRequired"]["ExtraDetail"]["Adults"],
                    $extraRequest['IncomingRequest']["STATUS_CHECK_FLAG"]);

                if (!$this->apiService->isRatesAvailableLocally) {
                   
                    $funcName = __FUNCTION__;
                    if ($extraRequest['IncomingRequest']["REQUEST_FROM_TMR"] === false) {
                        $response = $this->tsService->pullRates($funcName, $extraRequest);
                    }
                }
            }

            if (is_object($response) && empty($response->ServiceExtrasAndPricesResponse->ResponseList->ServiceExtras)) {
                $checkforError = array('contractPeriod');
                $response      = $this->apiService->collectExtraPrices($extraRequest['IncomingRequest']['SERVICEID'],
                    $extraRequest['IncomingRequest']['FROMDATE'],
                    $extraRequest['IncomingRequest']['TODATE'],
                    $extraRequest["IncomingRequest"]["CURRENCYISOCODE"],
                    $extraRequest['IncomingRequest']["ExtrasRequired"]["ExtraDetail"]["Adults"],
                    $extraRequest['IncomingRequest']["STATUS_CHECK_FLAG"],
                    $checkforError);
            } else if (is_array($response) && empty($response['ServiceExtrasAndPricesResponse']['ResponseList']['ServiceExtras'])) {
                $checkforError = array('contractPeriod');
                $response      = $this->apiService->collectExtraPrices($extraRequest['IncomingRequest']['SERVICEID'],
                    $extraRequest['IncomingRequest']['FROMDATE'],
                    $extraRequest['IncomingRequest']['TODATE'],
                    $extraRequest["IncomingRequest"]["CURRENCYISOCODE"],
                    $extraRequest['IncomingRequest']["ExtrasRequired"]["ExtraDetail"]["Adults"],
                    $extraRequest['IncomingRequest']["STATUS_CHECK_FLAG"],
                    $checkforError);
            }

            if (empty($response)) {

                $responseValue = array(
                    "Errors" => (object) array(),
                    "ServiceId" => $extraRequest['IncomingRequest']['SERVICEID'],
                    "ServiceCode" => $extraRequest['IncomingRequest']['SERVICEID'],
                    "ResponseList" => array()
                );
                $response["ServiceExtrasAndPricesResponse"]           = $responseValue;
                $response["ServiceExtrasAndPricesResponse"]["Errors"] = json_decode(json_encode(['Error' => [ 'Description' => 'Service not found']]));
            }
        }

        if (isset($response)) {
            return Response::json($response, 200);
        }
    }

//public $requestData = array (
//    'RequestObject' => array(
//        "Authenticate" =>
//            array("LICENSEKEY" => "A6C2FAAA-62D7-4A1B-9AB5-C6BF801E7803",
//                  "PASSENGERID" => "0",
//                  "Connector" => "enmTSHotelAPI"
//                ),
//        'ServiceID' => 422,
//        'ServiceTypeID' => 3, // activity
//        'StartDate' => '2017-01-01',
//        'EndDate' => '2017-01-01',
//        'ReturnPrice' => 0
//    )
//);
    // data = {"RequestObject":{"Authenticate":{"LICENSEKEY":"A6C2FAAA-62D7-4A1B-9AB5-C6BF801E7803","PASSENGERID":"0","Connector":"enmTSHotelAPI"},"ServiceID":422,"ServiceTypeID":3,"StartDate":"2017-01-01","EndDate":"2017-01-01","ReturnPrice":0}}
    // for activity code
    public function GetServiceInfo()
    {
//        $requestData = json_decode(json_encode($this->requestData), true);
        $requestData = json_decode(Input::get('data'), true);
        $response    = array();

        $validator = Validator::make($requestData['RequestObject'],
                $this->serviceInfoRules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $key => $message) {
                $message = str_replace('s ta rt  da te','start date', $message);
                $message = str_replace('s er vi ce id','service id', $message);
                $message = str_replace('service i d','service id', $message);
                $message = str_replace('f ro md at e','from date', $message);
                $message = str_replace('t od at e','to date', $message);
                $message = str_replace('s e r v i c e t y p e i d','service type id', $message);
                $message = str_replace('service type i d','service type id', $message);
                $response["ServiceInfoResponses"]["ErrorList"]["anyType"]["enc_value"]['ErrorDescription'][] = $message;
            }
        } else {
            $funcName = __FUNCTION__;
            $response = $this->apiService->collectServiceInfo($funcName,
                $requestData);
        }

        if (isset($response)) {
            return Response::json($response, 200);
        }
        return '';
    }

    public function callFunction($funcName)
    {
        if (method_exists($this, $funcName)) {
            return call_user_func([$this, $funcName]);
        } else {

            $params     = json_decode(Input::get('data'), true);

            // Totally Kill this call from Rates
            if ($funcName === 'GetServiceInformation1' || array_key_exists('STATUS_CHECK_FLAG',
                    $params['IncomingRequest'])) { // TMr Request
                $response["ServiceInformationResponse"]["Errors"] = json_decode(json_encode(['Error' => [ 'Description' => 'Service not found']]));
                return Response::json($response, 200);
            } else {
                $params     = json_decode(Input::get('data'), true);
                $dataFromTs = $this->tsService->pullRates($funcName, $params);

                if (isset($dataFromTs)) {
                    return Response::json($dataFromTs, 200);
                }
            }
        }
    }
}