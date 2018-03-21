<?php

Route::get(
    '/',
    ['as' => 'landing', 'uses' => 'HomeController@showLanding']
);

Route::get(
    '/rates',
    ['as' => 'rates', 'uses' => 'HomeController@showRates']
);

Route::get(
    '/services',
    ['as' => 'services', 'uses' => 'ServiceController@index']
);

Route::get(
    '/services/create',
    ['as' => 'services.create', 'uses' => 'ServiceController@create']
);

Route::get(
    '/services/{id}',
    ['as' => 'services.show', 'uses' => 'ServiceController@show']
);


Route::get(
    '/services/{id}/edit',
    ['as' => 'services.edit', 'uses' => 'ServiceController@edit']
);


Route::post(
    '/services', ['as' => 'services.store', 'uses' => 'ServiceController@store']
);


Route::post(
    '/service/options',
    ['uses' => 'RateController@getOptions']
);

Route::post(
    '/service/rates',
    ['uses' => 'RateController@getRates']
);

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'v1', 'before' => 'authv1'], function () {

        Route::post(
            '{uri}',
            ['uses' => 'App\Controllers\ApiController@callFunction']
        );

    });

    Route::group(['prefix' => 'fastbuild/v1', 'before' => 'authv1'], function () {

        Route::post(
            '{uri}',
            ['uses' => 'App\Controllers\FastBuildController@callFunction']
        );

    });
});

Route::get(
    '/csv2db',
    ['as' => 'csv2db', 'uses' => 'Csv2Db@UploadFromCsv']
);

Route::get(
    '/listContracts',
    ['as' => 'listContracts', 'uses' => 'adminController@listContracts']
);
Route::post(
    '/listSearchContracts',
    ['as' => 'listSearchContracts', 'uses' => 'adminController@listSearchContracts']
);
Route::get(
    '/addContract',
    ['as' => 'addContract', 'uses' => 'adminController@addContract']
);
Route::post(
    '/updateContract',
    ['as' => 'updateContract', 'uses' => 'adminController@updateContract']
);
Route::get(
    '/showContract',
    ['as' => 'showContract', 'uses' => 'adminController@updateContract']
);
Route::post(
    '/saveContract',
    ['as' => 'saveContract', 'uses' => 'adminController@saveContract']
);
Route::get(
    '/getResionsForSupplier',
    ['as' => 'getResionsForSupplier', 'uses' => 'adminController@getAllRegionsForSupplier']
);
Route::get(
    '/getSuppliersForResion',
    ['as' => 'getSuppliersForResion', 'uses' => 'adminController@getAllSuppliersForRegion']
);
Route::get(
    '/getServiceDataForContract',
    ['as' => 'getServiceDataForContract', 'uses' => 'adminController@getServiceDataForContract']
);
Route::get(
    '/getServiceDataForSeason',
    ['as' => 'getServiceDataForSeason', 'uses' => 'adminController@getServiceDataForSeason']
);
Route::get(
    '/getServiceDataForSeasonPeriod',
    ['as' => 'getServiceDataForSeasonPeriod', 'uses' => 'adminController@getServiceDataForSeasonPeriod']
);
Route::get(
    '/getAllChargingPolicies',
    ['as' => 'getAllChargingPolicies', 'uses' => 'adminController@getAllChargingPolicies']
);
Route::get(
    '/getAllMealPlans',
    ['as' => 'getAllMealPlans', 'uses' => 'adminController@getAllMealPlans']
);
Route::get(
    '/getServiceSeasonPeriodsData',
    ['as' => 'getServiceSeasonPeriodsData', 'uses' => 'adminController@getServiceSeasonPeriodsData']
);
Route::get(
    '/getAllCurrencies',
    ['as' => 'getAllCurrencies', 'uses' => 'adminController@getAllCurrencies']
);
Route::get(
    '/getAllOccupancies',
    ['as' => 'getAllOccupancies', 'uses' => 'adminController@getAllOccupancies']
);
///////////////////////////////////////////////
Route::get(
    '/viewService',
    ['as' => 'viewService', 'uses' => 'adminController@viewService']
);
Route::post(
    '/getPriceBandAndWeekPriceData',
    ['as' => 'getPriceBandAndWeekPriceData', 'uses' => 'adminController@getPriceBandAndWeekPriceData']
);
Route::post(
    '/linkOptionsWithExtras',
    ['as' => 'linkOptionsWithExtras', 'uses' => 'adminController@linkOptionsWithExtras']
);
Route::post(
    '/getExtrasWithIsMandatoryForOption',
    ['as' => 'getExtrasWithIsMandatoryForOption', 'uses' => 'adminController@getExtrasWithIsMandatoryForOption']
);

Route::post(
    '/deleteWeekPrices',
    ['as' => 'deleteWeekPrices', 'uses' => 'adminController@deleteWeekPrices']
);
Route::post(
    '/deletePriceBands',
    ['as' => 'deletePriceBands', 'uses' => 'adminController@deletePriceBands']
);


Route::post(
    '/deleteServicesPermanently',
    ['as' => 'deleteServicesPermanently', 'uses' => 'adminController@deleteServicesPermanently']
);
Route::get(
    '/updateExchangeRatesFromCSV',
    ['as' => 'updateExchangeRatesFromCSV', 'uses' => 'adminController@updateExchangeRatesFromCSV']
);
Route::get(
    '/deleteServicesPermanentlyFromCSV',
    ['as' => 'deleteServicesPermanentlyFromCSV', 'uses' => 'adminController@deleteServicesPermanentlyFromCSV']
);
Route::Post(
    '/updateExchangeRates',
    ['as' => 'updateExchangeRates', 'uses' => 'adminController@updateExchangeRates']
);

Route::get(
    '/optionsExtraMappingFromCSV',
    ['as' => 'optionsExtraMappingFromCSV', 'uses' => 'adminController@optionsExtraMappingFromCSV']
);

Route::post(
    '/optionsExtraMapping',
    ['as' => 'optionsExtraMapping', 'uses' => 'adminController@optionsExtraMapping']
);


Route::get(
    '/updateCityFromCSV',
    ['as' => 'updateCityFromCSV', 'uses' => 'adminController@updateCityFromCSV']
);
Route::post(
    '/updateCity',
    ['as' => 'updateCity', 'uses' => 'adminController@updateCity']
);


Route::get(
    '/OptionsInactiveFromCSV',
    ['as' => 'OptionsInactiveFromCSV', 'uses' => 'adminController@OptionsInactiveFromCSV']
);
Route::post(
    '/OptionsInactive',
    ['as' => 'OptionsInactive', 'uses' => 'adminController@OptionsInactive']
);
Route::get(
    '/updateOptionsIsDefaultForAllOccupany',
    ['as' => 'updateOptionsIsDefaultForAllOccupany', 'uses' => 'adminController@updateOptionsIsDefaultForAllOccupany']
);

Route::get(
    '/updateServiceShortNameFromCSV',
    ['as' => 'updateServiceShortNameFromCSV', 'uses' => 'adminController@updateServiceShortNameFromCSV']
);
Route::post(
    '/updateServiceShortName',
    ['as' => 'updateServiceShortName', 'uses' => 'adminController@updateServiceShortName']
);



