@extends('layouts.admin_interface_master')
@section('title')
Update Contracts
@stop

@section('styles')
{{ HTML::style('css/jquery-ui.css') }}
{{ HTML::style('css/contract.css') }}
@stop


@section('body')

{{ Form::open(array('name'=>'updateContract', 'id'=> 'updateContract', 'method' => 'post')) }}

<input type="hidden" class="form-control" id="service_id" name = "service_id" value = "{{ !empty($services) ? $services[$service_ts_id]['service_id'] : '' }}">
<input type="hidden" class="form-control" id="service_tsid" name = "service_tsid" value = "{{ !empty($services) ? $services[$service_ts_id]['ts_id'] : '' }}">
    
  <div class="container">
    <header class="col-md-12">
      <div class="wrapper">
        <a href="" class="pull-left logo-container">
          {{ HTML::image('img/logo.png') }}
        </a>

        <nav class="pull-left">
          <ul class="nav nav-tabs">
            <li role="presentation" class="pull-left">
              <a href="" class="active"> UPDATE CONTRACT</a>
            </li>
          </ul>
        </nav>
      </div>
    </header>
      
<?php if(!empty($_GET['selected_service_tsid'])): ?>
<?php echo 'Data updated successfully'; ?>
<?php endif; ?>
      
      
    <div class="col-md-12 main-container">
      <div class="wrapper">
        <div class="to-top"> </div>
        <div class="panel-group col-md-12" id="accordion" role="tablist" aria-multiselectable="true">

          <div class="panel panel-default col-md-12">
            <div class="panel-heading col-md-12" role="tab" id="headingaccord1">
              <h4 class="panel-title col-md-12" >
                <a class="col-md-12" role="button" data-toggle="collapse" href="#tripdetails" aria-expanded="true" aria-controls="collapseOne">
                  <div class="titletxt">SERVICE DETAILS</div>
                  <span class="plus">+</span>
                  <span class="minus">-</span>
                </a>
              </h4>
            </div>
            <div id="tripdetails" class="panel-collapse collapse in col-md-12" role="tabpanel" aria-labelledby="headingaccord1" >
              <div class="panel-body col-md-12">
                <div class="col-md-12 sscont">
                  <div class="sscontlines">
                    <div class="form-group mgn-rgt30 col-md-2 wdt2744per">
                      <label for="service_name">Name</label>
                      <input type="text" class="form-control" id="service_name" name = "service_name" value = "{{ !empty($services) ? $services[$service_ts_id]['service_name'] : '' }}">
                      <input type="hidden" class="form-control" id="service_currency_id" name = "service_currency_id" value = "{{ !empty($services) ? $services[$service_ts_id]['currency_id'] : '' }}">
                      <input type="hidden" class="form-control" id="service_currency_code" name = "service_currency_code" value = "{{ !empty($services) ? $services[$service_ts_id]['currency_code'] : '' }}">
                      <input type="hidden" class="form-control" id="service_page_no" name = "service_page_no" value = "0">
                    </div>
                    <div class="form-group mgn-rgt30 col-md-3">
                      <label for="supplier_id">Supplier</label>
                      <i class="dropdown-icon2"></i>
                      <select class="form-control select-supplier" name = "supplier_id" id = "supplier_id">
                          @foreach($suppliers as $key => $supplier)
                            @if($supplier->name !== '')                                
                                <option value = "{{ $supplier->id }}" @if(!empty($services[$service_ts_id]['supplier_id']) && $supplier->id === $services[$service_ts_id]['supplier_id']) 
                                        {{ ' selected' }} @endif>{{ $supplier->name }}</option>
                          @endif                          
                        @endforeach                        
                      </select>
                    
                    </div>
                      
                      <div class="form-group mgn-rgt30 col-md-3">
                      <label for="supplier_id">Room Type </label>
                      <i class="dropdown-icon2"></i>
                      <select class="form-control select-room-type" name = "default_room_type" id = "default_room_type">
                          @foreach($roomTypes as $key => $room_type)
                            @if($room_type !== '')                                
                                <option value = "{{ $room_type }}" @if($services[$service_ts_id]['default_option'] == $room_type) 
                                        {{ ' selected' }} @endif> {{ $room_type }}</option>
                          @endif                          
                        @endforeach                        
                      </select>
                    
                    </div>
<!--                    <div class="form-group col-md-1">
                      <label for="premium">Premium</label>
                      <input type="text" class="form-control" id="premium" name = "premium">
                    </div>-->
                  </div>

                  <div class="sscontlines">
                    <div class="form-group mgn-rgt30 col-md-2">
                      <label for="region_id">Region</label>
                      <i class="dropdown-icon2" ></i>
                      <select class="form-control select-region" name = "region_id" id = "region_id">
                          @foreach($regions as $key => $region)
                            @if($region->name !== '')
                                <option value = "{{$region->id}}" @if(!empty($services[$service_ts_id]['region_id']) && $region->id === $services[$service_ts_id]['region_id']) 
                                        {{ ' selected' }} @endif>{{$region->name}}</option>
                          @endif
                        @endforeach
                        
                      </select>
                    </div>
                    <div class="form-group mgn-rgt30 col-md-1">
                      <label for="curreny_code">Currency</label>
                      <i class="dropdown-icon2" ></i>
                      <select class="form-control" name = "currency_id" id = "currency_id">                         
                        @foreach($currencies as $key => $currency)
                            @if($currency->code !== '')
                                <option value = "{{$currency->id}}" @if(!empty($services[$service_ts_id]['currency_id']) && $currency->id === $services[$service_ts_id]['currency_id']) 
                                        {{ ' selected' }} @endif>{{$currency->code}}</option>
                          @endif
                        @endforeach                        
                      </select>
                    </div>
                    <div class="form-group mgn-rgt30 col-md-3">
                      <label for="service_type_id">Type</label>
                      <i class="dropdown-icon2" ></i>
                      <select class="form-control" name = "service_type_id" id ="service_type_id">
                        @foreach($serviceTypes as $key => $serviceType)
                            @if($serviceType->name !== '')
                                <option value = "{{$serviceType->id}}" @if(!empty($services[$service_ts_id]['service_type_id']) && $serviceType->id === $services[$service_ts_id]['service_type_id']) 
                                        {{ ' selected' }} @endif>{{$serviceType->name}}</option>
                          @endif
                        @endforeach  
                      </select>
                    </div>

<!--                    <div class="form-group mgn-rgt30 col-md-1">
                      <label for="margin">Margin</label>s                      
                      <input type="text" class="form-control" id="margin" name = "margin" value = "{{!empty($services[$service_ts_id]['margin']) ? $services[$service_ts_id]['margin'] ."%" :''}} ">
                    </div>-->
                  </div>

                </div>
              </div>
            </div>
          </div>

         


          <div class="panel panel-default col-md-12 bdgbtm0">
            <div class="panel-heading col-md-12" role="tab" id="headingaccord15">
              <h4 class="panel-title col-md-12" >
                <a class="col-md-12" role="button" data-toggle="collapse" href="#contracts" aria-expanded="true" aria-controls="collapseOne">
                  <div class="titletxt">CONTRACTS</div>
                  <span class="plus">+</span>
                  <span class="minus">-</span>
                </a>
              </h4>
            </div>
            <div id="contracts" class="panel-collapse collapse in col-md-12" role="tabpanel" aria-labelledby="headingaccord15" >
              <div class="panel-body col-md-12">
                <div class="col-md-12 sscont">
                  <div class="contrctscont">

                    <!-- Option And Extra prices -->
                    <div class="contrctsinnercont">
                      <h3>Options & Extras</h3>
                      <div class="seasoncontainer2">
                      <!--<div class="seasoncontainer">-->
                        <div class="commoncontainer">

                         <table class="commontable prices-option-table" id = 'prices_option_table'>
                          <thead>
                            <tr>
                              <th></th>
                              <th>Name</th>
                              <th>Occ</th>
                              <th>From</th>
                              <th>To</th>
                              <th>Policy</th>
                              <th>Meal</th>
                              <th>Currency</th>                              
                              <th> Buy </th>
                              <th> Sell </th>
                              <th>Margin</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                        <div class="adbtn add-options-price-row">
                            <a class = "" onclick="" >{{ HTML::image('img/add-row.png') }}<span>Add Option</span></a>
                        </div>

                      </div>
                    </div>

                  </div>

<!--                     New postion -  Start-->
                    <div class="seasoncontainer2">
                      <div class="commoncontainer">

                        <table class="commontable prices-extra-table" id = 'prices_extra_table'>
                          <thead>
                            <tr>
                              <th></th>
                              <th>Name</th>
                              <th>From</th>
                              <th>To</th>                              
                              <th>Policy</th>
                              <th>Mandatory?</th>
                              <th>Currency</th>
                              <th>Buy</th>
                              <th>Sell</th>
                              <th>Margin</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                        <div class="adbtn add-extras-price-row">
                          <a class = "" onclick="" >{{ HTML::image('img/add-row.png') }}<span>Add Extra</span></a>
                        </div>

                      </div>
                    </div>
<!--                      New postion -  End-->
                      
                </div>

                <div class="mgntp35">
                  <input type="submit" name="next" class="btn btn-primary mgn-rgt30 btn-submit" value="SAVE">
                  <input type="button" name="next" class="btn btn-gold" value="RESET">

                </div>
              </div>
            </div>
          </div>
        </div>






      </div>

    </div>
  </div>
  <!-- main container -->


</div>
{{ Form::close() }}


@section('scripts')
{{ HTML::script('js/jquery-ui.js') }}
{{ HTML::script('js/script.js') }}
{{ HTML::script('js/jquery.duplicate.js') }}
{{ HTML::script('js/ie10-viewport-bug-workaround.js') }}
{{ HTML::script('js/routes.js') }}
{{ HTML::script('js/updateContractScript.js') }}
<!--<script>
jQuery(document).ready(function ($) {
    var deleteConfirmMsg = "Are you sure you want to delete this item?";
    var statusInActiveConfirmMsg = "Are you sure you want to In-Active this item?";
    
    func_onload_with_allseason_periods();
    
    $('.select-supplier').change(function() {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ URL::route('getResionsForSupplier') }}",
            dataType: 'json',
            type: 'GET',
            // This is query string i.e. country_id=123
            data: {supplierId : $('.select-supplier').val()},
            success: function(data) {
                //console.log(data);
                $('.select-region').empty(); // clear the current elements in select box
                for (row in data) {
                    $('.select-region').append($('<option></option>').attr('value', data[row].id).text(data[row].name));
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });  
    });
    
    /////////////////////////       Click Add Button - Start ////////////////////////
    
    $(".add-options").on('click', function () {               
        var $tableBody = $('#service_options_table').find("tbody");        
        $trLast = $tableBody.find("tr:last"); 

        var num = parseInt( $trLast.prop("id").match(/\d+/g) ) +1;          
        $trNew = $trLast.clone().prop('id', 'service_options_row_'+num );
        $trNew.find( 'input.service-option-row-option-name' ).prop('id', 'service_option_row_option-name_'+num ).prop('name','service_option_row['+num+'][option_name]').val('');
        $trNew.find( 'input.service-option-row-option-id' ).prop('id', 'service_option_row_option_id_'+num ).prop('name','service_option_row['+num+'][option_id]').val('');
        $trNew.find( '.service-option-row-occupancy-id' ).prop('id', 'service_option_row_occupancy_id_'+num ).prop('name','service_option_row['+num+'][occupancy_id]');           
        $trNew.find( '.service-option-row-mandatory-extra' ).prop('id', 'service_option_row_mandatory_extra_'+num ).prop('name','service_option_row['+num+'][mandatory_extra]');

        $trNew.find( 'input.service-option-row-is-delete' ).prop('id', 'service_option_row_is_delete_'+num ).prop('name','service_option_row['+num+'][is_delete]').val('');

        $trNew.find( 'input.service-option-row-option-is-active' ).prop('id', 'service_option_row_option_is_active_'+num ).prop('name','service_option_row['+num+'][option_is_active]').val('');

        $trNew.find( '.remove-service-option-row' ).prop('id', 'remove_service_option_row_'+num );
        $trLast.after($trNew);

    });
    $(".add-extras-options").on('click', function () {               
        var $tableBody = $('#service-extras-table').find("tbody");        
        $trLast = $tableBody.find("tr:last"); 
        //var num = parseInt( $trLast.find( 'input.service-extras' ).prop("id").match(/\d+/g) ) +1;
        var num = parseInt( $trLast.prop("id").match(/\d+/g) ) +1;
        var extras_element_name = parseInt( $trLast.find( 'input.service-extra-row-extra-name' ).prop("name").match(/\d+/g) ) +1;
        $trNew = $trLast.clone().prop('id', 'service_extra_row_'+num );
        $trNew.find( 'input.service-extra-row-extra-name' ).prop('id', 'service_extra_row_extra_name_'+num ).prop('name','service_extra_row['+num+'][extra_name]').val('')        
        $trNew.find( 'input.service-extra-row-extra-id' ).prop('id', 'service_extra_row_extra_id_'+num ).prop('name','service_extra_row['+num+'][extra_id]').val('');        
        $trNew.find( 'input.service-extra-row-is-delete' ).prop('id', 'service_extra_row_is_delete_'+num ).prop('name','service_extra_row['+num+'][is_delete]').val('0');  
        
        $trNew.find( 'input.service-extra-row-extra-is-active' ).prop('id', 'service_extra_row_extra_is_active_'+num ).prop('name','service_extra_row['+num+'][extra_is_active]').val('');
        
        $trNew.find( '.remove-service-extra-row' ).prop('id', 'remove_service_extra_row_'+num );
        
        
        $trLast.after($trNew);
    });
    $('.add-season-period').on("click",function() {
        if(clone_season_period_table_row() === false) {

            var counter = 0;
            var contract_id = null;
            var contract_period_id = null;
            var season_id = null;
            var season_period_id = null;

            var seasonPeriods = new Object();
                seasonPeriods.name = '';
                seasonPeriods.start = '';
                seasonPeriods.end = '';
                seasonPeriods.currency_id = '';
                seasonPeriods.currency_code = '[select one]';
                seasonPeriods.margin = '0.00';
                seasonPeriods.premium = '0.00';
                seasonPeriods.season_period_status = '1';

            season_period_row_template(counter, seasonPeriods , contract_id, contract_period_id, season_id, season_period_id);                
        }

    });
    $('.add-options-price-row').on("click",function() {        
        if(clone_prices_option_table_row() === false) {  
            add_new_option_price_row();
        }
    }); 
    $('.add-extras-price-row').on("click",function() { 
        if(clone_prices_extra_table_row() === false) {
            add_new_extra_price_row();
        }            
    });
    
    /////////////////////////       Click Remove/Delete Button - Start ////////////////////////
     
    $('.service-options-table').on("click",".remove-service-option-row",function() {         
        if(confirm(deleteConfirmMsg)) {
            var num = parseInt( $(this).prop("id").match(/\d+/g) );
            $(this).closest('tr').find('input.service-option-row-is-delete').val('1');
            $(this).closest('tr').hide();
            var option_id = $(this).closest('tr').find('input.service-option-row-option-id').val();

            $('.prices-option-table').find('.prices-options-row-option-id').each(function(key,data){                
                if(data.value == option_id) {
                    $(this).closest('tr').hide();
                }                
            });
        } 

    });
    $('.service-extras-table').on("click",".remove-extras-options",function() {
        if(confirm(deleteConfirmMsg)) {
            var num = parseInt( $(this).prop("id").match(/\d+/g) );
            $(this).closest('tr').find('input.service-extra-row-is-delete').val('1');
            $(this).closest('tr').hide();

            var extra_id = $(this).closest('tr').find('input.service-extra-row-extra-id').val();

            $('.prices-extra-table').find('.prices-extras-row-extra-id').each(function(key,data){                
                if(data.value == extra_id) {
                    $(this).closest('tr').hide();
                }                
            });
        }

    });  
    $(".season-period-table").on('click', ".remove-season-period-row",function () {
        if(confirm(deleteConfirmMsg)) {
            $(this).closest('tr').find('input.season-period-row-is-delete').val('1');
            $(this).parent().hide();
        }
    });
    $('#prices_option_table').on("click",".remove-options-price-row",function() { 
        if(confirm(deleteConfirmMsg)) {
            $(this).closest('tr').find('input.prices-options-row-is-delete').val('1');
            $(this).closest('tr').hide();
        }
    }); 
    $('#prices_extra_table').on("click",".remove-extras-price-row",function() { 
        if(confirm(deleteConfirmMsg)) {
            $(this).closest('tr').find('input.prices-extras-row-is-delete').val('1');
            $(this).closest('tr').hide();
        }
    });
    
    /////////////////////////       Click IsActive Checkbox - Start /////////////////////
    
    $('.service-options-table').on("click",".service-option-row-option-is-active",function() {
        //console.log($(this).);
        if($(this).prop('checked') == true){
           // nothing to do
        } else {                
            if(confirm(statusInActiveConfirmMsg)) {
                //$(this).closest('tr').find('input.prices-options-row-is-delete').val('1');
                //$(this).closest('tr').hide();
                // nothing to do
            } else {
                $(this).prop('checked', true);
            }
        }
    });
    $('.service-extras-table').on("click",".service-extra-row-extra-is-active",function() {
        //console.log($(this).);
        if($(this).prop('checked') == true){
           // nothing to do
        } else {                
            if(confirm(statusInActiveConfirmMsg)) {
                //$(this).closest('tr').find('input.prices-options-row-is-delete').val('1');
                //$(this).closest('tr').hide();
                // nothing to do
            } else {
                $(this).prop('checked', true);
            }
        }
    });
    $('.season-period-table').on("click",".season-period-row-is-active",function() {            
        if($(this).prop('checked') == true){
           // nothing to do               
        } else {                
            if(confirm(statusInActiveConfirmMsg)) {
                //$(this).closest('tr').find('input.prices-options-row-is-delete').val('1');
                //$(this).closest('tr').hide();
                // nothing to do
            } else {
                $(this).prop('checked', true);
            }
        }
    });
    $('#prices_option_table').on("click",".prices-options-row-is-active",function() {            
        if($(this).prop('checked') == true){
           // nothing to do               
        } else {                
            if(confirm(statusInActiveConfirmMsg)) {
                //$(this).closest('tr').find('input.prices-options-row-is-delete').val('1');
                //$(this).closest('tr').hide();
                // nothing to do
            } else {
                $(this).prop('checked', true);
            }
        }
    });
    $('#prices_extra_table').on("click",".prices-extras-row-is-active",function() {
        //console.log($(this).);
        if($(this).prop('checked') == true){
           // nothing to do
        } else {
            if(confirm(statusInActiveConfirmMsg)) {
                //$(this).closest('tr').find('input.prices-extras-row-is-delete').val('1');
                //$(this).closest('tr').hide();
                // nothing to do
            } else {
                $(this).prop('checked', true);
            }
        }
    });
    
    /////////////////////////       Click Prices Option Table Row Operation - Start //////////////////////////
    
    $('#prices_option_table').on("click",'input.prices-options-row-option-name',function() {
            
        $this = $(this);
        element_obj = $(this);
        var num = parseInt( $this.prop("name").match(/\d+/g) );
        var counter = parseInt( $this.prop("id").match(/\d+/g) );
        var input_val = $(this).closest('tr').find('.prices-options-row-option-id').val();           

        $str_select = '<select class ="prices-options-row-option-name" name ="prices_options_row['+num+'][option_name]" id="prices_options_row_option_name_'+counter+'" >';
        $str_option = '';
        $this.prop('id','prices_options_input_'+counter).prop('name', 'prices_options_row_input['+num+'][option_name]').removeClass('prices-options-row-option-name').hide();
        var firstLoopThrough = false;
        var optionId = '';
        $('#service_options_table input.service-option-row-option-name').each(function(key, data) {

            option_id = $(this).closest('tr').find('.service-option-row-option-id').val();
            is_visible = $(this).closest('tr').is(":visible");

            if(firstLoopThrough === false) {
               optionId = option_id;
               firstLoopThrough = true;
            }

            if(is_visible == true) {
                 if(option_id == input_val) {
                     $str_option = $str_option + '<option value="'+data.value+'" selected>'+data.value+'</option>';
                 } else {
                     $str_option = $str_option + '<option value="'+data.value+' ">'+data.value+'</option>';
                 }
            }

        })

        $str_select += $str_option + "</select>";
        $this.parent().append($str_select);  
        $this.closest('tr').find('input.prices-options-row-option-id').val(optionId);
     });
    $('#prices_option_table').on("change",'select.prices-options-row-option-name',function() {

        $this = $(this);
        input_val = $this.val();

        $('#service_options_table input.service-option-row-option-name').each(function(key, data) {               
           option_id = $(this).closest('tr').find('.service-option-row-option-id').val();
           option_name = data.value;
           is_visible = $(this).closest('tr').is(":visible");

           if(is_visible == true) {
                if(option_name.trim() == input_val.trim()) {
                   $this.closest('tr').find('input.prices-options-row-option-id').val(option_id);
                }
           }
       })           
    });
    $('.prices-option-table').on('click','.prices-options-row-charging-policy-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ URL::route('getAllChargingPolicies') }}",
                dataType: 'json',
                type: 'GET',
                // This is query string i.e. country_id=123
                data: {ajax_call:1},
                success: function(data) {   
                    populate_for='prices-options-row';
                    element_name='charging_policy_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj,element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
        }
    });
    $('.prices-option-table').on('click','.prices-options-row-meal-plan-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ URL::route('getAllMealPlans') }}",
                dataType: 'json',
                type: 'GET',
                // This is query string i.e. country_id=123
                data: {ajax_call:1},
                success: function(data) {   
                    populate_for='prices-options-row';
                    element_name='meal_plan_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj,element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
        }
    });
    $('#prices_option_table').on("focusout",'input.prices-options-row-sell-price',function() {
        $this = $(this);
        if($this.val() == '' || $this.val() == 0) {
            alert('Price could not be empty or zero' );
            $this.focus();
            return false;
        }  
        var margin = $(".season-period-table .row-highlighted").find('input.season-period-row-margin').val();

        margin = parseFloatPrice(margin);

        var buy_price = $this.closest('tr').find('input.prices-options-row-buy-price').val();
        var sell_price = $this.closest('tr').find('input.prices-options-row-sell-price').val();

        var calculateMargin = ((sell_price - buy_price)/sell_price) * 100;
        calculateMargin = parseFloatPrice(calculateMargin);

        if(margin != calculateMargin) {
            if(margin  < calculateMargin) {
                var msg = 'The new increased margin is '+calculateMargin+'%. '                   
            } else if(margin  > calculateMargin) {                   
                var msg = 'The new decreased margin is '+calculateMargin+'%. ';
            }

            if(confirm( msg + 'Do you want to apply this margin everywhere ??? ')) {
                 applyMarginPrice(calculateMargin);
            } else {
                applyMarginPrice(margin);
            }               
        }

     }); 
     
    /////////////////////////       Click Prices Extra Table Row Operation - Start //////////////////////////
    
    $('#prices_extra_table').on("click",'input.prices-extras-row-extra-name',function() {
                    
        $this = $(this);
        var counter = parseInt( $this.prop("id").match(/\d+/g) );
        var num = parseInt( $this.prop("name").match(/\d+/g) );
        var input_val = $(this).closest('tr').find('.prices-extras-row-extra-id').val();    

        $str_select = '<select class ="prices-extras-row-extra-name" name ="prices_extras_row['+num+'][extra_name]" id="prices_extras_row_extra_name_'+counter+'" >';
        $str_option = '';           
        $this.prop('id','prices_extras_row_extra_name_input_'+counter).prop('name', 'prices_extras_row_input['+num+'][extra_name]').removeClass('prices-extras-row-extra-name').hide();

        var firstLoopThrough = false;
        var extraId = '';
        $('#service-extras-table input.service-extra-row-extra-name').each(function(key, data) {
            extra_id = $(this).closest('tr').find('.service-extra-row-extra-id').val();
            is_visible = $(this).closest('tr').is(":visible");

            if(firstLoopThrough === false) {
               extraId = extra_id;
               firstLoopThrough = true;
            }

            if(is_visible == true) {
                 if(extra_id == input_val) {
                     $str_option = $str_option + '<option value="'+data.value+'" selected>'+data.value+'</option>';
                 } else {
                      $str_option = $str_option + '<option value="'+data.value+' ">'+data.value+'</option>';
                 }
             }
        })

        $str_select += $str_option + "</select>";
        $this.parent().append($str_select);
        $this.closest('tr').find('input.prices-extras-row-extra-id').val(extraId);
     });   
    $('#prices_extra_table').on("change",'select.prices-extras-row-extra-name',function() {

        $this = $(this);
        input_val = $this.val();

        $('#service-extras-table input.service-extra-row-extra-name').each(function(key, data) {
           extra_id = $(this).closest('tr').find('.service-extra-row-extra-id').val();
           option_name = data.value;
           is_visible = $(this).closest('tr').is(":visible");

           if(is_visible == true) {
                if(option_name.trim() == input_val.trim()) {
                   $this.closest('tr').find('input.prices-extras-row-extra-id').val(extra_id);
                }
           }
       })           
    });
    $('.prices-extra-table').on('click','.prices-extras-row-charging-policy-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ URL::route('getAllChargingPolicies') }}",
                dataType: 'json',
                type: 'GET',
                // This is query string i.e. country_id=123
                data: {ajax_call:1},
                success: function(data) { 
                    populate_for='prices-extras-row';
                    element_name='charging_policy_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
        }
    });        
    $('.prices-extra-table').on('click','.prices-extras-row-meal-plan-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ URL::route('getAllMealPlans') }}",
                dataType: 'json',
                type: 'GET',
                // This is query string i.e. country_id=123
                data: {ajax_call:1},
                success: function(data) { 
                    populate_for='prices-extras-row';
                    element_name='meal_plan_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
        }
    });
    $('#prices_extra_table').on("focusout",'input.prices-extras-row-sell-price',function() {
        $this = $(this);
        if($this.val() == '' || $this.val() == 0) {
            alert('Price could not be empty or zero' );
            $this.focus();
        }         

        var margin = $(".season-period-table .row-highlighted").find('input.season-period-row-margin').val();
        margin = parseFloatPrice(margin);

        var buy_price = $this.closest('tr').find('input.prices-extras-row-buy-price').val();
        var sell_price = $this.closest('tr').find('input.prices-extras-row-sell-price').val();
        
        if(sell_price == 0) {
            sell_price = 1;
        }

        var calculateMargin = ((sell_price - buy_price)/sell_price) * 100;
        calculateMargin = parseFloatPrice(calculateMargin);

        console.log(margin);
        console.log(calculateMargin);

        if(margin != calculateMargin) {
            if(margin  < calculateMargin) {
                var msg = 'The new increased margin is '+calculateMargin+'%. '                   
            } else if(margin  > calculateMargin) {                   
                var msg = 'The new decreased margin is '+calculateMargin+'%. ';
            }

            if(confirm( msg + 'Do you want to apply this margin everywhere ??? ')) {
                 applyMarginPrice(calculateMargin);
                 $(".season-period-table .row-highlighted").find('input.season-period-row-margin').val(calculateMargin);
            } else {
                applyMarginPrice(margin);
            }               
        }

     });
     
    /////////////////////////       Click Season period Table Row Operation - Start //////////////////////////
    
    $('.season-period-table').on('click','.show-season-periods-prices', function() {
        $this = $(this);
        var service_id = $('#service_id').val();  
        var contract_id = $(this).parent().find('.season-period-row-contract-id').val();
        var contract_period_id = $(this).parent().find('.season-period-row-contract-period-id').val();
        var season_id = $(this).parent().find('.season-period-row-season-id').val();
        var season_period_id = $(this).parent().find('.season-period-row-season-period-id').val();

        if(contract_id !='' && contract_period_id != '' &&  season_id != '' && season_period_id != '') {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ URL::route('getServiceDataForSeasonPeriod') }}",
                dataType: 'json',
                type: 'GET',
                // This is query string i.e. country_id=123
                data: {contract_id : contract_id, contract_period_id : contract_period_id, season_id : season_id, season_period_id : season_period_id, service_id : service_id},
                success: function(data) {
                    populate_dynamic_data('seasonPeriods',data, contract_id, contract_period_id, season_id, season_period_id);
                    //$this.parent().parent().addClass('row-highlighted');
                    $( ".season-period-table .season-period-row" ).removeClass('row-highlighted');
                    $this.parent().parent().addClass('row-highlighted');
//                     $this.addClass('li-highlighted');
//                     $( ".season-period-table .season-period-row:first-child" ).addClass('row-highlighted');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });  
        }
    }); 
    $('#season_period_table').on('change','input.season-period-row-start-date, input.season-period-row-end-date',function() {
        elementObj = $(this);
        var num = parseInt( elementObj.prop("id").match(/\d+/g) );
        start_date = $(this).closest('tr').find('input.season-period-row-start-date').val();
        end_date = $(this).closest('tr').find('input.season-period-row-end-date').val();

        if(start_date != '' && end_date != '' && start_date > end_date ){
            alert('Season End date could not be earlier than  season start date');
            return false;
        }

        $('#season_period_table').find('input.season-period-row-start-date').each( function(index, data) {                
            if(index != num) {                
                row_start_date = $(this).closest('tr').find('input.season-period-row-start-date').val();
                row_end_date = $(this).closest('tr').find('input.season-period-row-end-date').val();
                if( IsBetween(start_date, row_start_date, row_end_date, elementObj) || IsBetween(end_date, row_start_date, row_end_date, elementObj) ) {
                  alert('Date falls between the date range of row '+(index+1));
                  return false;
               } 
            }               
        });
    });        
    $('.season-period-table').on('click','.season-period-row-currency-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ URL::route('getAllCurrencies') }}",
                dataType: 'json',
                type: 'GET',
                // This is query string i.e. country_id=123
                data: {ajax_call:1},
                success: function(data) { 
                    populate_for='season-period-row';
                    element_name='currency_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
        }
    });    
     
    /////////////////////////       Click Service Option Table Row Operation - Start //////////////////////////
    $('.service-options-table').on("focusout","input.service-option-row-option-name",function() {   
        var service_option_name = $(this).val();
        var num = $(this).prop("id").match(/\d+/g);
        var idname = '#prices_options_row_option_name_'+num;

        if(service_option_name == '') {
            alert('Option Name could not be empty');
            $(this).focus();
            return false;
        }

        if($(idname).val() == undefined ) {     //undefined                
            if(clone_prices_option_table_row(service_option_name) === false) {                   
                add_new_option_price_row(service_option_name);            
            } 
        } else {
            if($(idname).prop('type') == 'text') {
                $(idname).val(service_option_name);
            } 
        }
    });
        
    /////////////////////////       Click Service Extra Table Row Operation - Start //////////////////////////
    $('.service-extras-table').on("focusout","input.service-extra-row-extra-name",function() { 
        var service_extras_name = $(this).val();        
        var service_extras_id = $(this).attr('name').match(/\d+/g); // for edit

        if(service_extras_name == '') {
            alert('Extra Name could not be empty');
            $(this).focus();
            return false;
        }
        var num = $(this).prop("id").match(/\d+/g);
        var idname = '#prices_extras_row_extra_name_'+num;

        //if(service_extras_name != '' ) {     //undefined
        if($(idname).val() == undefined ) {     //undefined
            $('.service-option-row-mandatory-extra').append($('<option></option>').text(service_extras_name));
            if(clone_prices_extra_table_row(service_extras_name) === false) {                   
                add_new_extra_price_row(service_extras_name);            
            }
        } else {
            $(idname).val(service_extras_name);
        }

    });
       
    /////////////////////////       Click SubmitButton - Start //////////////////////////
    $( '#updateContract' ).on( 'submit', function( event ) {
            
        $this = $(this);
        var service_id = $('#service_id').val();  
        
        var contract_id = $('#season_period_table .row-highlighted').find('.season-period-row-contract-id').val();        
        var contract_period_id = $('#season_period_table .row-highlighted').find('.season-period-row-contract-period-id').val();
        var season_id = $('#season_period_table .row-highlighted').find('.season-period-row-season-id').val();
        var season_period_id = $('#season_period_table .row-highlighted').find('.season-period-row-season-period-id').val();
        var validationCheck;
        
        validationCheck = checkForValidation();
        if(validationCheck === true) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ URL::route('saveContract') }}",
                dataType: 'json',
                type: 'POST',
                // This is query string i.e. country_id=123
                data: $( this ).serialize()+'&contract_id='+contract_id+'&contract_period_id='+contract_period_id+'&season_id='+season_id+'&season_period_id='+season_period_id+'&service_id='+service_id,
                success: function(data) {
                      alert(data.message);
                      var url = "{{ URL:: route('showContract') }}" + '?service_tsid='+data.service_tsid;
                      if(service_id == '') {
                            $(location).attr('href', url);
                        }    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

        return false;
    });    
    
    
    /////////////////////////  Function Definations - Start //////////////////////////
    
    function func_onload_with_allseason_periods() { 
        var service_id = $('#service_id').val();  
        var contract_id = $( ".contractlist .contract-row:first-child" ).find('input.contract-row-contract-id').val();
        var contract_period_id = $( ".contractlist .contract-row:nth-child(1)" ).find('input.contract-row-contract-period-id').val();
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             url: "{{ URL::route('getServiceSeasonPeriodsData') }}",
             dataType: 'json',
             type: 'GET',
             // This is query string i.e. country_id=123
             data: {contract_id : contract_id, contract_period_id : contract_period_id, service_id : service_id},
             success: function(data) {
                 $('.seasonlist ul li').remove(); // clear the current elements 
                 populate_dynamic_data('contracts',data, contract_id, contract_period_id); 

                 $( ".contractlist .contract-row:first-child" ).addClass('row-highlighted');
                 $('.seasonlist ul li').addClass('li-highlighted');
                 $( ".season-period-table .season-period-row:first-child" ).addClass('row-highlighted');

             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });            
    }
    function populate_dynamic_data(arg, data, contract_id, contract_period_id, season_id, season_period_id) {
        for (row in data) { 
            
            if(arg == 'contracts') {            
                // Populate Seasons for perticular Contracts
                if(row == 'seasons') {  
                    $('.seasonlist ul').empty();
                    var counter = 0;
                    for (row1 in data[row]) {
                        for (row2 in data[row][row1]) {
                            var season = data[row][row1][row2];
                            if(season_id==null) {
                                season_id=season.id;
                            }
                            season_li_template(counter, season, contract_id, contract_period_id, season_id, season_period_id);  
                            counter++;
                        }
                    }
                }
            }
            if(arg == 'contracts' || arg == 'seasons') {
                // Populate season Period Data
                if(row == 'seasonPeriods') { 
                   $('#season_period_table tbody').empty();
                   var counter = 0;
                   for (row1 in data[row]) {
                       for (row2 in data[row][row1]) {
                           var seasonPeriods = data[row][row1][row2];
                           if(season_period_id == null) {
                               season_period_id = seasonPeriods.id;
                           }
                           season_period_row_template(counter, seasonPeriods, contract_id, contract_period_id, season_id, season_period_id); 
                           counter++;
                       }
                   }
                } 
            }
            // Populate Option Price Data
            if(row == 'options') {
               $('#prices_option_table tbody').empty();

               for (row1 in data[row]) {
                   var counter = 0;
                   for (row2 in data[row][row1]) {
                       var options = data[row][row1][row2];  
                       option_price_row_template(counter, options, contract_id, contract_period_id, season_id, season_period_id); 
                       counter++;
                   }
               }
           }
            // Populate Extra price Data
            if(row == 'extras') {
                $('#prices_extra_table tbody').empty();

                for (row1 in data[row]) {
                    var counter = 0;
                    for (row2 in data[row][row1]) {
                        var extras = data[row][row1][row2];  

                        extra_price_row_template(counter, extras, contract_id, contract_period_id, season_id, season_period_id);
                        counter++;

                    }
                }

            }
        }
    }
    function season_li_template(counter, season, contract_id, contract_period_id, season_id, season_period_id) {
        $('.seasonlist ul').append('<li class = "season-name-li" id="season_name_li_'+counter+'"><input type="hidden" class="form-control season-name-li-contract-id" name = "season_name['+counter+'][contract_id]" id= "season_name_li_contract_id_'+counter+'" placeholder="season_name_li_contract_id" value = "'+contract_id+'"><input type="hidden" class="form-control season-name-li-contract-period-id" name = "season_name['+counter+'][contract_period_id]" id= "season_name_li_contract_period_id_'+counter+'" placeholder="season_name_li_contract_period_id" value = "'+contract_period_id+'"><input type="hidden" class="form-control season-name-li-season-id" name = "season_name['+counter+'][season_id]" id= "season_name_li_season_id_'+counter+'" placeholder="season_name_li_season_id" value = "'+season.id+'"><input type="hidden" class="form-control season-name-li-season-name" name = "season_name['+counter+'][season_name]" id= "season_name_li_season_name_'+counter+'" placeholder="season_name_li_season_name" value = "'+season.name+'"><input type="hidden" class="form-control season-name-li-is-delete" name = "season_name['+counter+'][is_delete]" id= "season_name_li_is_delete_'+counter+'" placeholder="season_name_li_is_delete" value = "0"><a class = "season-name" href="javascript:;">'+season.name+'</a><i class="closeicon remove-season-name-li" ></i></li>');
    }
    function season_period_row_template(counter, seasonPeriods , contract_id, contract_period_id, season_id, season_period_id) {

        if(seasonPeriods.contract_id != null && contract_id == null) {
            contract_id = seasonPeriods.contract_id;
        }
        if(seasonPeriods.contract_period_id != null && contract_period_id == null) {
            contract_period_id = seasonPeriods.contract_period_id;
        }

        if(seasonPeriods.season_id != null ) {
            season_id = seasonPeriods.season_id;
        }

        var margin = seasonPeriods.margin;
        margin = parseFloatPrice(margin);

        var premium = seasonPeriods.premium;
        premium = parseFloatPrice(premium);

        var currency_col = '<td class="wdt10per"><div class="form-group"><i class="dropdown-icon2"></i><select class="form-control topalignlast season-period-row-currency-id" id="season_period_row_currency_id_'+counter+'" name ="season_period_row['+counter+'][currency_id]"><option value = "'+seasonPeriods.currency_id+'" >'+seasonPeriods.currency_code+'</option></select></div></td>';
        var margin_col = '<td class="wdt10per"><div class="form-group"><input type="text" class="form-control season-period-row-margin" name = "season_period_row['+counter+'][margin]" id ="season_period_row_margin_'+counter+'" placeholder="Margin" value = "'+margin+'"></div></td>';
        var premium_col = '<td class="wdt10per"><div class="form-group"><input type="text" class="form-control season-period-row-premium" name = "season_period_row['+counter+'][premium]" id ="season_period_row_premium_'+counter+'" placeholder="premium" value = "'+premium+'"></div></td>';

        var str_chked = '';
        var str_readonly = '';
        var is_delete_col = '';

        if(seasonPeriods.season_period_status == 1) {            
            str_chked = ' checked ';
            str_readonly = ' readonly ';
            is_delete_col = '<td class="closeicon remove-season-period-row" id = "remove_season_period_row_'+counter+'"></td>';
        } else {
            is_delete_col = '';
        }

        var is_active_col = '<td class="wdt10per"><div class="form-group"><input type="checkbox" class="form-control season-period-row-is-active" id = "season_period_row_is_active_'+counter+'" name = "season_period_row['+counter+'][is_active]" placeholder="Is Active" value = "'+seasonPeriods.id+'" '+ str_chked +' ></div></td>';

//            currency_col = '';
//            margin_col = '';
//            premium_col = '';           

        $('#season_period_table').find('tbody').append('<tr class="addtoseason season-period-row" id = "season_period_row_'+counter+'">'+is_active_col+'<td class="wdt20per"><span class="glyphicon glyphicon-info-sign show-season-periods-prices"></span><div class="form-group"><input type="hidden" class="form-control season-period-row-contract-id" name = "season_period_row['+counter+'][contract_id]" id= "season_period_row_contract_id_'+counter+'" placeholder="season_period_row_contract_id" value = "'+contract_id+'"><input type="hidden" class="form-control season-period-row-contract-period-id" name = "season_period_row['+counter+'][contract_period_id]" id= "season_period_row_contract_period_id_'+counter+'" placeholder="season_period_row_contract_period_id" value = "'+contract_period_id+'"><input type="hidden" class="form-control season-period-row-season-id" name = "season_period_row['+counter+'][season_id]" id= "season_period_row_season_id_'+counter+'" placeholder="season_period_row_season_id" value = "'+seasonPeriods.season_id+'"><input type="hidden" class="form-control season-period-row-season-period-id" name = "season_period_row['+counter+'][season_period_id]" id= "season_period_row_season_period_id_'+counter+'" placeholder="season_period_row_season_period_id" value = "'+seasonPeriods.id+'"><input type="text" class="form-control season-period-row-season-period-name" name = "season_period_row['+counter+'][season_period_name]" id= "season_period_row_season_period_name_'+counter+'" placeholder="season_period_name" value = "'+seasonPeriods.name+'"><input type="hidden" class="form-control season-period-row-is-delete" name = "season_period_row['+counter+'][is_delete]" id= "season_period_row_is_delete_'+counter+'" placeholder="season_period_is_delete" value = "0"></div></td>'+currency_col+margin_col+premium_col+'<td class="wdt20per"><div class="form-group"><input type="text" class="form-control start-date date_icon pointerclass season-period-row-start-date" name ="season_period_row['+counter+'][start_date]" id ="season_period_row_start_date_'+counter+'" placeholder="Start Date" value = "'+seasonPeriods.start+'"></div></td><td class="wdt20per"><div class="form-group"><input type="text" class="form-control end-date date_icon pointerclass season-period-row-end-date" name = "season_period_row['+counter+'][end_date]" id ="season_period_row_end_date_'+counter+'" placeholder="End Date" value = "'+seasonPeriods.end+'"></div></td>'+is_delete_col+'</tr>'); 

        $season_start_date_counter = '#season_period_row_start_date_'+counter;
        $season_end_date_counter = '#season_period_row_end_date_'+counter;
        $($season_start_date_counter).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose:true,
            showOtherMonths: true,
            selectOtherMonths: true
            });//.attr('readonly', 'readonly');
        $($season_end_date_counter).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose:true,
            showOtherMonths: true,
            selectOtherMonths: true
            });//.attr('readonly', 'readonly');

    }
    function option_price_row_template(counter, options, contract_id, contract_period_id, season_id, season_period_id) {
        var str_chked = '';
        var is_delete_col = '';
        var str_readonly = '';
        //console.log(options);
        if(options.price_status == 1) {            
            str_chked = ' checked ';
            str_readonly = ' readonly ';
            is_delete_col = '<td class="closeicon remove-options-price-row" id = "remove_options_price_row_'+counter+'"></td>';
        } else {
            is_delete_col = '';
        }

        var is_active_col = '<td class="wdt10per"><input type="checkbox" class="form-control prices-options-row-is-active" id = "prices_options_row_is_active_'+counter+'" name = "prices_options_row['+counter+'][is_active]" placeholder="Is Active" value = "'+options.price_id+'" '+ str_chked +' ></td>';

        var meal_plan_col = '<td class="wdt20per"><div class="form-group"><i class="dropdown-icon2"></i><select class="form-control topalignlast prices-options-row-meal-plan-id" id="prices_options_row_meal_plan_id_'+counter+'" name ="prices_options_row['+counter+'][meal_plan_id]"><option value = "'+options.meal_plan_id+'" >'+options.meal_plan_name+'</option></select></div></td>';

        //check_box_col = '';        
        //meal_plan_col = '';
        //is_delete_col = '';

        var buy_price = options.buy_price;
        //buy_price = parseFloat(buy_price).toFixed(2);
        buy_price = parseFloatPrice(buy_price);

        var sell_price = options.sell_price;
        //sell_price = parseFloat(sell_price).toFixed(2);
        sell_price = parseFloatPrice(sell_price);

        $('#prices_option_table').find('tbody').append('<tr class = "prices-options-row" id ="prices_options_row_'+counter+'">'+is_active_col+'<td class="wdt20per"><div class="form-group"><input type="hidden" class="form-control prices-options-row-price-id" id = "prices_options_row_price_id" name = "prices_options_row['+counter+'][price_id]" placeholder="Option ID" value = "'+options.price_id+'"><input id ="prices_options_row_option_name_'+counter+'" type="text" class="form-control prices-options-row-option-name" name = "prices_options_row['+counter+'][option_name]" placeholder="Option Name" value = "'+options.option_name+'" readonly><input type="hidden" class="form-control prices-options-row-option-id" id = "prices_options_row_option_id" name = "prices_options_row['+counter+'][option_id]" placeholder="Option ID" value = "'+options.option_id+'"><input type="hidden" class="form-control prices-options-row-is-delete" id = "prices_options_row_is_delete" name = "prices_options_row['+counter+'][is_delete]" placeholder="Price ID for is delete" value = "0"><input type="hidden" class="form-control prices-options-row-contract-id" id = "prices_options_row_contract_id" name = "prices_options_row['+counter+'][contract_id]" placeholder="Contract ID" value = "'+contract_id+'"><input type="hidden" class="form-control prices-options-row-contract-period-id" id = "prices_options_row_contract_period_id" name = "prices_options_row['+counter+'][contract_period_id]" placeholder="Contract Period ID" value = "'+contract_period_id+'"><input type="hidden" class="form-control prices-options-row-season-id" id = "prices_options_row_season_id" name = "prices_options_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'"><input type="hidden" class="form-control prices-options-row-season-period-id" id = "prices_options_row_season_period_id" name = "prices_options_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'"></div></td>'+meal_plan_col+'<td class="wdt25per"><div class="form-group"><i class="dropdown-icon2"></i><select class="form-control topalignlast prices-options-row-charging-policy-id" id="prices_options_row_charging_policy_id_'+counter+'" name ="prices_options_row['+counter+'][charging_policy_id]"><option value = "'+options.policy_id+'" >'+options.policy_name+'</option></select></div></td><td class="wdt10per"><div class="form-group"><input type="text" class="form-control prices-options-row-buy-price" name ="prices_options_row['+counter+'][buy_price]" id = "prices_options_row_buy_price_'+counter+'" placeholder="Buy Price" value = "'+buy_price+'"></div</td><td class="wdt10per"><div class="form-group"><input type="text" class="form-control prices-options-row-sell-price" name ="prices_options_row['+counter+'][sell_price]" id = "prices_options_row_sell_price_'+counter+'" placeholder=" Sell Price" value = "'+sell_price+'"></div></td>'+is_delete_col+'</tr>');
    }
    function extra_price_row_template(counter, extras, contract_id, contract_period_id, season_id, season_period_id) {

        var str_chked = '';
        var is_delete_col = '';
        var str_readonly = '';

        if(extras.price_status == 1) {            
            str_chked = ' checked ';
            str_readonly = ' readonly ';
            is_delete_col = '<td class="closeicon remove-extras-price-row" id = "remove_extras_price_row'+counter+'"></td>';
        } else {
            is_delete_col = '';
        }

        var is_active_col = '<td class="wdt10per"><input type="checkbox" class="form-control prices-extras-row-is-active" id = "prices_extras_row_is_active_'+counter+'" name = "prices_extras_row['+counter+'][is_active]" placeholder="Is Active" value = "'+extras.price_id+'" '+ str_chked +' ></td>';

        var meal_plan_col = '<td class="wdt25per"><div class="form-group"><i class="dropdown-icon2"></i><select class="form-control topalignlast prices-extras-row-meal-plan-id" id="prices_extras_row_meal_plan_id_'+counter+'" name ="prices_extras_row['+counter+'][meal_plan_id]"><option value = "'+extras.meal_plan_id+'" >'+extras.meal_plan_name+'</option></select></div></td>';

        meal_plan_col = '';

        var buy_price = extras.buy_price;
        buy_price = parseFloatPrice(buy_price);

        var sell_price = extras.sell_price;
        sell_price = parseFloatPrice(sell_price);


        $('#prices_extra_table').find('tbody').append('<tr class = "prices-extras-row" id = "prices_extras_row_'+counter+'">'+is_active_col+'<td class="wdt25per"><div class="form-group"><input type="hidden" class="form-control prices-extras-row-price-id" id = "prices_extras_row_price_id" name = "prices_extras_row['+counter+'][price_id]" placeholder="Extra PRICE ID" value = "'+extras.price_id+'"><input  id ="prices_extras_row_extra_name_'+counter+'" type="text" class="form-control prices-extras-row-extra-name" name = "prices_extras_row['+counter+'][extra_name]" placeholder="prices_extras_row_extras_name" value = "'+extras.extra_name+'" readonly><input type="hidden" class="form-control prices-extras-row-is-delete" id = "prices_extras_row_is_delete_'+counter+'" name = "prices_extras_row['+counter+'][is_delete]" placeholder="Extra  price ID for Soft Delete " value = "0"><input type="hidden" class="form-control prices-extras-row-extra-id" id = "prices_extras_row_extra_id" name = "prices_extras_row['+counter+'][extra_id]" placeholder="Extra ID" value = "'+extras.extra_id+'"><input type="hidden" class="form-control prices-extras-row-contract-id" id = "prices_extras_row_contract_id" name = "prices_extras_row['+counter+'][contract_id]" placeholder="contract ID" value = "'+contract_id+'"><input type="hidden" class="form-control prices-extras-row-contract-period-id" id = "prices_extras_row_contract_period_id" name = "prices_extras_row['+counter+'][contract_period_id]" placeholder="contract Period ID" value = "'+contract_period_id+'"><input type="hidden" class="form-control prices-extras-row-season-id" id = "prices_extras_row_season_id" name = "prices_extras_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'"><input type="hidden" class="form-control prices-extras-row-season-period-id "id = "prices_extras_row_season_period_id" name = "prices_extras_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'"></div></td>'+meal_plan_col+'<td class="wdt25per"><div class="form-group"><i class="dropdown-icon2"></i><select class="form-control topalignlast prices-extras-row-charging-policy-id" id="prices_extras_row_charging_policy_id_'+counter+'" name ="prices_extras_row['+counter+'][charging_policy_id]"><option value = "'+extras.policy_id+'">'+extras.policy_name+'</option></select></div></td><td class="wdt20per"><div class="form-group"><input type="text" class="form-control prices-extras-row-buy-price" name="prices_extras_row['+counter+'][buy_price]" id= "prices_extras_row_buy_price_'+counter+'" placeholder="Buy Price"  value = "'+buy_price+'"></div></td><td class="wdt20per"><div class="form-group"><input type="text" class="form-control prices-extras-row-sell-price" name ="prices_extras_row['+counter+'][sell_price]" id = "prices_extras_row_sell_price_'+counter+'" placeholder="Sell Price"  value = "'+sell_price+'"></div></td>'+is_delete_col+'</tr>');

    }    
    function clone_prices_extra_table_row (extra_name) {
        var $tableBody = $('#prices_extra_table').find("tbody");

        if($tableBody.find("tr").length > 0) {
            var $trLast = $tableBody.find("tr:last");
            var num = parseInt( $trLast.find( 'input.prices-extras-row-extra-name' ).prop("id").match(/\d+/g) ) +1;
            $trNew = $trLast.clone().prop('id', 'prices_extras_row_'+num );;
            $trNew.find( 'input.prices-extras-row-price-id' ).prop('id', 'prices_extras_row_price_id_'+num ).prop('name', 'prices_extras_row['+num+'][price_id]').val('');
            $trNew.find( 'input.prices-extras-row-extra-name' ).prop('id', 'prices_extras_row_extra_name_'+num ).prop('name', 'prices_extras_row['+num+'][extra_name]').val(extra_name);
            $trNew.find( 'input.prices-extras-row-is-delete' ).prop('id', 'prices_extras_row_is_delete_'+num ).prop('name', 'prices_extras_row['+num+'][is_delete]').val('0');

            $trNew.find( 'input.prices-extras-row-extra-id' ).prop('id', 'prices_extras_row_extra_id_'+num ).prop('name', 'prices_extras_row['+num+'][extra_id]').val('');

            $trNew.find( 'input.prices-extras-row-contract-id' ).prop('id', 'prices_extras_row_contract_id_'+num ).prop('name', 'prices_extras_row['+num+'][contract_id]');
            $trNew.find( 'input.prices-extras-row-contract-period-id' ).prop('id', 'prices_extras_row_contract_period_id_'+num ).prop('name', 'prices_extras_row['+num+'][contract_period_id]');
            $trNew.find( 'input.prices-extras-row-season-id' ).prop('id', 'prices_extras_row_season_id_'+num ).prop('name', 'prices_extras_row['+num+'][season_id]');
            $trNew.find( 'input.prices-extras-row-season-period-id' ).prop('id', 'prices_extras_row_season_period_id_'+num ).prop('name', 'prices_extras_row['+num+'][season_period_id]');
            $trNew.find( '.prices-extras-row-charging-policy-id' ).prop('id', 'prices_extras_row_charging_policy_id_'+num ).prop('name', 'prices_extras_row['+num+'][charging_policy_id]');
            $trNew.find( 'input.prices-extras-row-buy-price' ).prop('id', 'prices_extras_row_buy_price_'+num ).prop('name', 'prices_extras_row['+num+'][buy_price]').val('');
            $trNew.find( 'input.prices-extras-row-sell-price' ).prop('id', 'prices_extras_row_sell_price_'+num ).prop('name', 'prices_extras_row['+num+'][sell_price]').val('');

            $trNew.find( '.prices-extras-row-meal-plan-id' ).prop('id', 'prices_extras_row_meal_plan_id_'+num ).prop('name', 'prices_extras_row['+num+'][meal_plan_id]');
            $trNew.find( '.prices-extras-row-is-active' ).prop('id', 'prices_extras_row_is_active_'+num ).prop('name', 'prices_extras_row['+num+'][is_active]');


            $trNew.find( '.remove-extras-price-row' ).prop('id', 'remove_extras_price_row_'+num );

            $trLast.after($trNew);
            return true;
        } 
        return false;
    }        
    function clone_prices_option_table_row(option_name) {
        var $tableBody = $('#prices_option_table').find("tbody");

        if($tableBody.find("tr").length > 0) {

            var $trLast = $tableBody.find("tr:last");
            var num = parseInt( $trLast.find( 'input.prices-options-row-option-name' ).prop("id").match(/\d+/g) ) +1;
            $trNew = $trLast.clone().prop('id', 'prices_options_row_'+num );
            $trNew.find( 'input.prices-options-row-price-id' ).prop('id', 'prices_options_row_price_id_'+num ).prop('name', 'prices_options_row['+num+'][price_id]').val('');
            $trNew.find( 'input.prices-options-row-option-name' ).prop('id', 'prices_options_row_option_name_'+num ).prop('name', 'prices_options_row['+num+'][option_name]').val( option_name );

            $trNew.find( 'input.prices-options-row-option-id' ).prop('id', 'prices_options_row_option_id_'+num ).prop('name', 'prices_options_row['+num+'][option_id]').val('');
            $trNew.find( 'input.prices-options-row-is-delete' ).prop('id', 'prices_options_row_is_delete_'+num ).prop('name', 'prices_options_row['+num+'][is_delete]');

            $trNew.find( 'input.prices-options-row-contract-id' ).prop('id', 'prices_options_row_contract_id_'+num ).prop('name', 'prices_options_row['+num+'][contract_id]');
            $trNew.find( 'input.prices-options-row-contract-period-id' ).prop('id', 'prices_options_row_contract_period_id_'+num ).prop('name', 'prices_options_row['+num+'][contract_period_id]');
            $trNew.find( 'input.prices-options-row-season-id' ).prop('id', 'prices_options_row_season_id_'+num ).prop('name', 'prices_options_row['+num+'][season_id]');
            $trNew.find( 'input.prices-options-row-season-period-id' ).prop('id', 'prices_options_row_season_period_id_'+num ).prop('name', 'prices_options_row['+num+'][season_period_id]');
            $trNew.find( '.prices-options-row-charging-policy-id' ).prop('id', 'prices_options_row_charging_policy_id_'+num ).prop('name', 'prices_options_row['+num+'][charging_policy_id]');
            $trNew.find( 'input.prices-options-row-buy-price' ).prop('id', 'prices_options_row_buy_price_'+num ).prop('name', 'prices_options_row['+num+'][buy_price]').val('');
            $trNew.find( 'input.prices-options-row-sell-price' ).prop('id', 'prices_options_row_sell_price_'+num ).prop('name', 'prices_options_row['+num+'][sell_price]').val('');
            $trNew.find( '.remove-options-price-row' ).prop('id', 'remove_options_price_row_'+num );

            $trNew.find( '.prices-options-row-meal-plan-id' ).prop('id', 'prices_options_row_meal_plan_id_'+num ).prop('name', 'prices_options_row['+num+'][meal_plan_id]');

            $trNew.find( '.prices-options-row-is-active' ).prop('id', 'prices_options_row_is_active_'+num ).prop('name', 'prices_options_row['+num+'][is_active]');


            $trLast.after($trNew);
            return true;
        } 
        return false;
    }
    function populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for) {
        $this = element_obj;
        var counter = parseInt( $this.prop("id").match(/\d+/g) );
        var num = parseInt( $this.prop("name").match(/\d+/g) );
        var select_val = $this.text();

        if(element_name=='charging_policy_id') {
            var element_class_name = 'charging-policy-id';
        } else if(element_name=='meal_plan_id') {
            var element_class_name = 'meal-plan-id';
        } else if(element_name=='currency_id') {
            var element_class_name = 'currency-id';
        }


        if(populate_for=='prices-extras-row') {
            $str_select = '<select class ="prices-extras-row-'+element_class_name+'" name ="prices_extras_row['+num+']['+element_name+']" id="prices_extras_row_'+element_name+'_'+counter+'" >';
        } else if(populate_for=='prices-options-row') {
            $str_select = '<select class ="prices-options-row-'+element_class_name+'" name ="prices_options_row['+num+']['+element_name+']" id="prices_options_row_'+element_name+'_'+counter+'" >';
        } else if(populate_for=='season-period-row') {
            $str_select = '<select class ="season-period-row-'+element_class_name+'" name ="season_period_row['+num+']['+element_name+']" id="season_period_row_'+element_name+'_'+counter+'" >';
        } 

        $str_option = '';           

        for (row in data) {
            var optionValue = data[row].id;
            var optionText = data[row].name;

            if(element_name=='currency_id') {
                optionText = data[row].code;
            }

            if(optionText.trim() != '' && select_val.trim() == optionText.trim()) {
                $str_option = $str_option + '<option value="'+optionValue+'" selected>'+optionText+'</option>';
            } else {
                $str_option = $str_option + '<option value="'+optionValue+' ">'+optionText+'</option>';
            }
        }

        $str_select += $str_option + "</select>";
        $this.parent().append($str_select);
        $this.remove();
    }
    function IsBetween(value, left, right, elementObj) {
        var isBetween = false;
        if(value != null && left != null && right != null && elementObj != null ) {
            if((left < value && value < right) || (right < value && value < left)) {
                elementObj.closest('tr').find('input.season-period-row-start-date').val('');
                elementObj.closest('tr').find('input.season-period-row-end-date').val('');
                isBetween = true;
            } else if (value == left) {
                elementObj.closest('tr').find('input.season-period-row-start-date').val(''); 
                isBetween = true;
            } else if(value == right) {
                elementObj.closest('tr').find('input.season-period-row-end-date').val('');
                isBetween = true;
            } else {
                isBetween = false;
            }
        }

        return isBetween;
    }
    function applyMarginPrice(margin) {
        $(".season-period-table .row-highlighted").find('input.season-period-row-margin').val(margin);            
        $('#prices_option_table .prices-options-row').each(function(index, data) {                              
            buy_price = $(this).find('.prices-options-row-buy-price').val();                 
            sell_price = parseFloat(buy_price) / parseFloat( 1 - (margin / 100));
            sell_price = parseFloatPrice(sell_price);                
            $(this).find('.prices-options-row-sell-price').val(sell_price);                
        }); 

        $('#prices_extra_table .prices-extras-row').each(function(index, data) {                              
            buy_price = $(this).find('.prices-extras-row-buy-price').val();                 
            sell_price = parseFloat(buy_price) / parseFloat( 1 - (margin / 100)); 
            sell_price = parseFloatPrice(sell_price);
            $(this).find('.prices-extras-row-sell-price').val(sell_price);
        }); 
        //$(".season-period-table .row-highlighted").find('input.season-period-row-margin').val(margin);
    }
    function clone_season_period_table_row (season_period_name) {
        var $tableBody = $('#season_period_table').find("tbody");
        if($tableBody.find("tr").length > 0) {
            var $trLast = $tableBody.find("tr:last");
            var num = parseInt( $trLast.prop("id").match(/\d+/g) ) +1;
            $trNew = $trLast.clone().prop('id', 'season_period_row_'+num );
            $trNew.find('input.season-period-row-contract-id').prop('id', 'season_period_row_contract_id_'+num).prop('name', 'season_period_row['+num+'][contract_id]').val('');
            $trNew.find('input.season-period-row-contract-period-id').prop('id', 'season_period_row_contract_period_id_'+num).prop('name', 'season_period_row['+num+'][contract_period_id]').val('');
            $trNew.find('input.season-period-row-season-id').prop('id', 'season_period_row_season_id_'+num).prop('name', 'season_period_row['+num+'][season_id]').val('');
            $trNew.find('input.season-period-row-season-period-id').prop('id', 'season_period_row_season_period_id_'+num).prop('name', 'season_period_row['+num+'][season_period_id]').val('');
            $trNew.find('input.season-period-row-season-period-name').prop('id', 'season_period_row_season_period_name_'+num).prop('name', 'season_period_row['+num+'][season_period_name]').val('');
            $trNew.find('input.season-period-row-start-date').prop('id', 'season_period_row_start_date_'+num).prop('name', 'season_period_row['+num+'][start_date]').val('');
            $trNew.find('input.season-period-row-end-date').prop('id', 'season_period_row_end_date_'+num).prop('name', 'season_period_row['+num+'][end_date]').val('');

            $trNew.find('input.season-period-row-is-delete').prop('id', 'season_period_row_is_delete_'+num).prop('name', 'season_period_row['+num+'][is_delete]').val('0');

            $trNew.find( '.season-period-row-currency-id' ).prop('id', 'season_period_row_currency_id_'+num ).prop('name', 'season_period_row['+num+'][currency_id]');
            $trNew.find('input.season-period-row-margin').prop('id', 'season_period_row_margin_'+num).prop('name', 'season_period_row['+num+'][margin]').val('0.00');
            $trNew.find('input.season-period-row-premium').prop('id', 'season_period_row_premium_'+num).prop('name', 'season_period_row['+num+'][premium]').val('');

            $trNew.find('input.season-period-row-is-active').prop('id', 'season_period_row_is_active_'+num).prop('name', 'season_period_row['+num+'][is_active]').val('');


            $trNew.find('.remove-season-period-row').prop('id', 'remove_season_period_row_'+num).val('');


            $trNew.find("input.season-period-row-start-date").removeClass('hasDatepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                autoclose:true,
                showOtherMonths: true,
                selectOtherMonths: true
            });//.attr('readonly', 'readonly');
            $trNew.find("input.season-period-row-end-date").removeClass('hasDatepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                autoclose:true,
                showOtherMonths: true,
                selectOtherMonths: true
            });//.attr('readonly', 'readonly');
            $trNew.removeClass('row-highlighted');

            $trLast.after($trNew);
            return true;
        } 
        return false;
    }
    function add_new_option_price_row(service_option_name) {
        var counter = 0;
        var $seasonPeriod = $('#season_period_table .row-highlighted');                
        var contract_id = $seasonPeriod.find('input.season-period-row-contract-id').val();
        var contract_period_id = $seasonPeriod.find('input.season-period-row-contract-period-id').val();
        var season_id = $seasonPeriod.find('input.season-period-row-season-id').val();
        var season_period_id = $seasonPeriod.find('input.season-period-row-season-period-id').val();

        var options = new Object();
            options.price_id = '';
            options.option_id = '';
            options.option_name = service_option_name;
            options.policy_id = '';
            options.policy_name = '[select one]';
            options.meal_plan_id = '';
            options.meal_plan_name = '[select one]';
            options.buy_price = '';
            options.sell_price = '';
            options.price_status = '1';


        option_price_row_template(counter, options, contract_id, contract_period_id, season_id, season_period_id);
    }
    function add_new_extra_price_row(service_extras_name) {

        var counter = 0;
        var $seasonPeriod = $('#season_period_table .row-highlighted');                
        var contract_id = $seasonPeriod.find('input.season-period-row-contract-id').val();
        var contract_period_id = $seasonPeriod.find('input.season-period-row-contract-period-id').val();
        var season_id = $seasonPeriod.find('input.season-period-row-season-id').val();
        var season_period_id = $seasonPeriod.find('input.season-period-row-season-period-id').val();

        var extras = new Object();
            extras.price_id = '';
            extras.extra_id = '';
            extras.extra_name = service_extras_name;
            extras.policy_id = '';
            extras.policy_name = '[select one]';
            extras.meal_plan_id = '';
            extras.meal_plan_name = '[select one]';
            extras.buy_price = '';
            extras.sell_price = '';
            extras.price_status = '1';

        extra_price_row_template(counter, extras, contract_id, contract_period_id, season_id, season_period_id);
    }
    function parseFloatPrice(price) {            
            price = parseFloat(price).toFixed(2);
            if(price == 'NaN') {
                return '';
            }
            return price;
        } 
        
    function checkForValidation() {
        
        var validationCheck = true;
        
        if(isEmptyOptionName() === true ) { validationCheck = false; }
        if(isEmptyExtraName() === true ) { validationCheck = false; }
        if(isValidSeasonPeriods() === false ) { validationCheck = false; }
        if(isValidOptionPrices() === false ) { validationCheck = false; }
        if(isValidExtraPrices() === false ) { validationCheck = false; }
        
        return validationCheck;
    }
       
    function isEmptyOptionName() {        
        $('#service_options_table input.service-option-row-option-name').each(function(key, data) {
            is_visible = $(this).closest('tr').is(":visible");
            if(is_visible == true) {
                if(data.value == '') {
                    alert('Option name could not be empty');
                    return true;
                }
            }
        });
        return false;
    }
    function isEmptyExtraName() {
        $('#service-extras-table input.service-extra-row-extra-name').each(function(key, data) {
            is_visible = $(this).closest('tr').is(":visible");
            if(is_visible == true) {
                if(data.value == '') {
                    alert('Extra name could not be empty');
                    return true;
                }
            }
        });
        return false;
    }
    function isValidSeasonPeriods() {
        $('#season_period_table').find('input.season-period-row-start-date').each( function(index, data) {
            season_period_name = $(this).closest('tr').find('input.season-period-row-season-period-name').val();
            row_start_date = $(this).closest('tr').find('input.season-period-row-start-date').val();
            row_end_date = $(this).closest('tr').find('input.season-period-row-end-date').val();
            if( season_period_name == '' || row_start_date == '' || row_end_date == '' ) {
              alert('season period name OR date could not be empty');
              return false;
            }                          
        });
        return true;
    }
    function isValidOptionPrices() {
        
        var margin = $(".season-period-table .row-highlighted").find('input.season-period-row-margin').val();
        margin = parseFloatPrice(margin);
        applyMarginPrice(margin);                
        return true;
    }
    function isValidExtraPrices() {
//        var margin = $(".season-period-table .row-highlighted").find('input.season-period-row-margin').val();
//        margin = parseFloatPrice(margin);
//        applyMarginPrice(margin);                
        return true;
    }
  
});
</script>-->
@stop
@stop






