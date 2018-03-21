@extends('layouts.admin_services_master')
@section('title')
View Service
@stop

@section('styles')
{{ HTML::style('css/jquery-ui.css') }}
{{ HTML::style('css/daterangepicker.css') }}
{{ HTML::style('css/service_contract.css') }}
{{ HTML::style('css/service_style.css') }}

@stop


@section('body')


{{ Form::open(array('name'=>'updateContract', 'id'=> 'updateContract', 'method' => 'post')) }}

 <div class="page-loader">
    <div class="loader-box">        
        {{ HTML::image('img/loader.gif') }}
        Please be wait...
    </div>
</div>

<div id = 'model_id'></div>
<div class="rowdelpopup">
    <div class="delpoptext">Are you sure you want to delete this item?
        <div><span class="rowyesbut">YES</span><span class="rownobut">NO</span></div>
    </div>
</div>
<div class="delpopup">
	<div class="delpoptext">Are you sure you want to delete this item?
		<div><span class="yesbut">YES</span><span class="nobut">NO</span></div>
	</div>
</div>

<div class="flydiv" id="flydivsel">	
        <input type="submit" class="btn btn-primary  btn-submit" value="SAVE">
	<input type="button" class="btn btn-gold pagereset" value="RESET">
</div>
<div class="container">
    <header class="col-md-12">
      <div class="wrapper">
        <a href="" class="pull-left logo-container">
          {{ HTML::image('img/logo.png') }}
        </a>

        <nav class="pull-left">
          <ul class="nav nav-tabs">
            <li role="presentation" class="pull-left">
              <a href="" class="active">ADD CONTRACT</a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <div class="col-md-12 main-container">
      <div class="wrapper">
        <div class="to-top"> </div>
        <div class="panel-group col-md-12" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default col-md-12 noborder">
            <div class="panel-heading col-md-12" role="tab" id="heading_accordion_service">
              <h4 class="panel-title col-md-12" >
                <a class="col-md-12" role="button" data-toggle="collapse" href="#tripdetails" aria-expanded="true" aria-controls="collapseOne">
                  <div class="titletxt">SERVICE DETAILS</div>
                  <span class="plus">{{ HTML::image('img/plus.png') }}</span>
                  <span class="minus">{{ HTML::image('img/minus.png') }}</span>
                </a>
              </h4>
            </div>
            <div id="tripdetails" class="panel-collapse collapse in col-md-12" role="tabpanel" aria-labelledby="heading_accordion_service" >
                <div class="row">
                      <div class="form-group col-md-6">
                          <label for="first-name">Service Name</label>
                          <input type="text" class="form-control sinputval" placeholder="Name" value = "{{ !empty($services) ? $services[$service_ts_id]['service_name'] : '' }}" id="service_name" name="service_name">
                          <input type="hidden" class="form-control" id="service_id" name = "service_id" value = "{{ !empty($services) ? $services[$service_ts_id]['service_id'] : '' }}">
<input type="hidden" class="form-control" id="service_tsid" name = "service_tsid" value = "{{ !empty($services) ? $services[$service_ts_id]['ts_id'] : '' }}">
                          <input type="hidden" class="form-control" id="service_currency_id" name = "service_currency_id" value = "{{ !empty($services) ? $services[$service_ts_id]['currency_id'] : '' }}">
                          <input type="hidden" class="form-control" id="currency_id" name = "currency_id" value = "{{ !empty($services) ? $services[$service_ts_id]['currency_id'] : '' }}">
                      <input type="hidden" class="form-control" id="service_currency_code" name = "service_currency_code" value = "{{ !empty($services) ? $services[$service_ts_id]['currency_code'] : '' }}">
                      <input type="hidden" class="form-control" id="service_page_no" name = "service_page_no" value = "0">
                      </div>
                      <div class="form-group padleft30 col-md-3">
                          <label for="first-name">Region</label>
                          <i class="dropdown-icon2" ></i>                          
                          <select class="form-control sinputval select-region" id="region_id" name="region_id">
                            @foreach($regions as $key => $region)
                              @if($region->name !== '')
                                  <option value = "{{$region->id}}" @if(!empty($services[$service_ts_id]['region_id']) && $region->id === $services[$service_ts_id]['region_id']) 
                                          {{ ' selected' }} @endif>{{$region->name}}</option>
                            @endif
                          @endforeach

                        </select>
                          
                      </div>
                      <div class="form-group padleft30 col-md-3">
                          <label for="first-name">Supplier</label>
                          <i class="dropdown-icon2"></i>
                           <select class="form-control sinputval select-supplier" id="supplier_id" name="supplier_id">
                          @foreach($suppliers as $key => $supplier)
                            @if($supplier->name !== '')                                
                                <option value = "{{ $supplier->id }}" @if(!empty($services[$service_ts_id]['supplier_id']) && $supplier->id === $services[$service_ts_id]['supplier_id']) 
                                        {{ ' selected' }} @endif>{{ $supplier->name }}</option>
                          @endif                          
                        @endforeach                        
                      </select>
                      </div>
                  </div>
                <div class="row"><div class="col-md-12 hidden-sm emt-height"></div></div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="first-name">Service Type</label>
                        <i class="dropdown-icon2" ></i>
                        
                        <select class="form-control sinputval" id="service_type_id" name="service_type_id">
                            @foreach($serviceTypes as $key => $serviceType)
                                @if($serviceType->name !== '')
                                    <option value = "{{$serviceType->id}}" @if(!empty($services[$service_ts_id]['service_type_id']) && $serviceType->id === $services[$service_ts_id]['service_type_id']) 
                                            {{ ' selected' }} @endif>{{$serviceType->name}}</option>
                              @endif
                            @endforeach  
                        </select>
                        
                    </div>
                    <div class="form-group padleft30 col-md-2">
                        <label for="first-name">Margin</label>
                        <input type="text" class="form-control sinputval" placeholder="Margin" value="20%" id="service_margin" name="service_margin">
                    </div>
                    <div class="form-group padleft30 col-md-3">
                        <label for="first-name">Status</label>
                        <i class="dropdown-icon2" ></i>
                        <select class="form-control sinputval" id="service_status" name="service_status">
                            <option value="">Select</option>
                            <option value="1" selected>Active</option>
                            <option value="0" selected>Active</option>
                        </select>
                    </div>
                    <div class="form-group padleft30 col-md-3">
                        <label for="first-name">Default Category</label>
                        <div class="greyborder">
                            <i class="dropdown-icon2 right75"></i>
                            <select class="form-control applycss select-room-type" id="default_room_type" name="default_room_type">
                                @foreach($roomTypes as $key => $room_type)
                                  @if($room_type !== '')                                
                                      <option value = "{{ $room_type }}" @if($services[$service_ts_id]['default_option'] == $room_type) 
                                              {{ ' selected' }} @endif> {{ $room_type }}</option>
                                @endif                          
                              @endforeach                        
                            </select>
                            
                            
                            <input type="submit" value="APPLY" class="greybut greybutpos btn-submit">
                        </div>
                    </div>

                </div>
            </div>
          </div>
            <div class="row"><div class="col-md-12">&nbsp;</div></div>
            <div class="panel panel-default col-md-12 noborder oflowhide">
                <div class="panel-heading col-md-12" role="tab" id="heading_accordion_options">
                    <h4 class="panel-title col-md-12" >
                        <a class="col-md-12" role="button" data-toggle="collapse" href="#optionsblock" aria-expanded="true" aria-controls="collapseOne">
                            <div class="titletxt">OPTIONS</div>
                            <span class="plus">{{ HTML::image('img/plus.png') }}</span>
                            <span class="minus">{{ HTML::image('img/minus.png') }}</span>
                        </a>
                    </h4>
                </div>
                <div id="optionsblock" class="panel-collapse collapse in col-md-12" role="tabpanel" aria-labelledby="heading_accordion_options">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="prices-option-table" id="prices_option_table">
                                <thead>
                                    <tr class="trbgcolor">
                                        <th><input type="checkbox" class="optcheckall" value=""></th>
                                        <th>Room Name</th>
                                        <th>Occupancy</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Charging Policy</th>
                                        <th>Meal Plan</th>
                                        <th>Currency</th>
                                        <th>Buy</th>
                                        <th>Sell</th>
                                        <th>Margin</th>
                                        <th>Status</th>
                                        <input type ="hidden" name="option_page_no" id='option_page_no' value='1'>
                                        <input type ="hidden" name="delete_option_prices" id='delete_option_prices' value=''>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="butsarea" id="option_page_nevigation" >
                        <div class="pull-left">
                            <div class="options-page-navigation-left">{{ HTML::image('img/left-arrow.png') }}</div>
                            <div class="dropdown page-navigation" >

                            </div>
                            <div class="options-page-navigation-right">{{ HTML::image('img/right-arrow.png') }}</div>
                        </div>
                        <div class="eventbut add-options-price-row" id="add_options_price_row"><i class="icon-clone"></i>&nbsp; CLONE</div>
                        <div class="delbut remove-options-price-row" id="remove_options_price_row"><i class="icon-delete"></i>&nbsp; DELETE</div>
                        <div class="eventbut edit-options-price-row" id="edit_options_price_row"><i class="icon-edit"></i>&nbsp; Edit</div>
                    </div>
                </div>
                <div class="datepickblock">
                    <div class="row">
                        <div class="col-md-2 datepicklbl">Date Range &nbsp;</div>
                        <div class="col-md-3">
                            <input type="hidden" id="options_date_range_from" class="options-date-range-from" value="">
                            <input type="hidden" id="options_date_range_to" class="options-date-range-to" value="">
                            <input type="text" name="optdate" id="optdate" class="form-control datetxtbox" placeholder="Select Date">
                            <label for="optdate">
                                <i class="datecalicon"></i>
                            </label>
                        </div>
                        <div class="col-md-2 datepicklbl">Status &nbsp;</div>
                        <div class="col-md-4">
                            <i class="dropdown-icon2 dateselicon"></i>
                            <select class="form-control datestatussel prices-options-table-status" id="prices_options_table_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-1">&nbsp;</div>
                    </div>
                    <div id="optDateText">&nbsp;</div>
                </div>
            </div>
            <div class="panel panel-default col-md-12 noborder oflowhide">
                <div class="panel-heading col-md-12" role="tab" id="heading_accordion_extras">
                    <h4 class="panel-title col-md-12" >
                        <a class="col-md-12" role="button" data-toggle="collapse" href="#extrasblock" aria-expanded="true" aria-controls="collapseOne">
                            <div class="titletxt">EXTRAS</div>
                            <span class="plus">{{ HTML::image('img/plus.png') }}</span>
                            <span class="minus">{{ HTML::image('img/minus.png') }}</span>
                        </a>
                    </h4>
                </div>
                <div id="extrasblock" class="panel-collapse collapse in col-md-12" role="tabpanel" aria-labelledby="heading_accordion_extras">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="prices-extra-table" id="prices_extra_table">
                                <thead>
                                <tr class="trbgcolor">
                                    <th><input type="checkbox" class="extcheckall" value=""></th>
                                    <th>Extra Name</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Charging Policy</th>
                                    <th>Mandatory</th>
                                    <th>Currency</th>
                                    <th>Buy</th>
                                    <th>Sell</th>
                                    <th>Margin</th>
                                    <th>Status</th>
                                <input type ="hidden" name="extra_page_no" id='extra_page_no' value='1'>
                                <input type ="hidden" name="delete_extra_prices" id='delete_extra_prices' value=''>
                                
                                </tr>
                                 </thead>
                                 <tbody>
                                     
                                 </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="butsarea" id="extra_page_nevigation" >
                        <div class="pull-left">
                            <div class="extras-page-navigation-left">{{ HTML::image('img/left-arrow.png') }}</div>
                            <div class="dropdown page-navigation" id="extra_page_nevigation">

                            </div>
                            <div class="extras-page-navigation-right">{{ HTML::image('img/right-arrow.png') }}</div>
                        </div>
                        <div class="eventbut link-extras-price-row" id="link_extras_price_row"><i class="icon-link"></i>&nbsp; LINK</div>

                        <div class="eventbut" id="add_extras_price_row"><i class="icon-clone"></i>&nbsp; CLONE</div>
                        <div class="delbut" id="remove_extras_price_row"><i class="icon-delete"></i>&nbsp; DELETE</div>
                        <div class="eventbut" id="edit_extras_price_row"><i class="icon-edit"></i>&nbsp; Edit</div>
                    </div>
                </div>
                <div class="datepickblock">
                    <div class="row">
                        <div class="col-md-2 datepicklbl">Date Range &nbsp;</div>
                        <div class="col-md-3">
                            <input type="hidden" id="extras_date_range_from" class="extras-date-range-from" value="">
                            <input type="hidden" id="extras_date_range_to" class="extras-date-range-to" value="">
                            <input type="text" name="optdate" id="extdate" class="form-control datetxtbox" placeholder="Select Date">
                            <label for="extdate">
                                <i class="datecalicon"></i>
                            </label>
                        </div>
                        <div class="col-md-2 datepicklbl">Status &nbsp;</div>
                        <div class="col-md-4">
                            <i class="dropdown-icon2 dateselicon"></i>
                            <select class="form-control datestatussel prices-extras-table-status" id="prices_extras_table_status"">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-1">&nbsp;</div>
                    </div>
                    <div id="extDateText">&nbsp;</div>
                </div>
            </div>
            <div>
                <input type="submit" class="savebut  btn-submit" value="SAVE">
                <div class="resetbut pagereset">RESET</div>
            </div>
        </div>
      </div>
    </div>
</div>

{{ Form::close() }}



@section('scripts')


{{ HTML::script('js/routes.js') }}
{{ HTML::script('js/daterangepicker.js') }}
{{ HTML::script('js/service_events.js') }}
{{ HTML::script('js/service_script.js') }}
{{ HTML::script('js/jquery.duplicate.js') }}
{{ HTML::script('js/ie10-viewport-bug-workaround.js') }}

{{ HTML::script('js/viewService.js') }}

@stop
@stop






