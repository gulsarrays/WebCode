jQuery(document).ready(function ($) {
    var recordsPerPage = 20000;
    var deleteConfirmMsg = "Are you sure you want to delete this item?";
    var statusInActiveConfirmMsg = "Are you sure you want to In-Active this item?";
    
    func_onload_with_allseason_periods();
    
    $('.select-supplier').change(function() {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},            
            url: Router.route('getResionsForSupplier'),
            dataType: 'json',
            type: 'GET',            
            data: {supplierId : $('.select-supplier').val()},
            success: function(data) {                
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
    $('.select-region').change(function() {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},            
            url: Router.route('getSuppliersForResion'),
            dataType: 'json',
            type: 'GET',            
            data: {regionId : $('.select-region').val()},
            success: function(data) {                
                $('.select-supplier').empty(); // clear the current elements in select box
                for (row in data) {
                    $('.select-supplier').append($('<option></option>').attr('value', data[row].id).text(data[row].name));
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });  
    });
    
    /////////////////////////       Click Add Button - Start ////////////////////////
 
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
    
    $('.prices-option-table').on('click','.prices-options-row-charging-policy-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllChargingPolicies'),
                dataType: 'json',
                type: 'GET',                
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
                url: Router.route('getAllMealPlans'),
                dataType: 'json',
                type: 'GET',                
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
        var margin = $this.closest('tr').find('input.prices-options-row-price-margin').val();

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
                 //applyMarginPrice(calculateMargin);
                 $this.closest('tr').find('input.prices-options-row-price-margin').val(calculateMargin);                 
            } else {
                //applyMarginPrice(margin);
            }               
        }

     });     
    $('#prices_option_table').on("focusout",'input.prices-options-row-price-margin',function()  {
        $this = $(this);
        if($this.val() == '' || $this.val() == 0) {
            alert('Margin could not be empty or zero' );
            $this.focus();
            return false;
        }  
        var margin = $this.closest('tr').find('input.prices-options-row-price-margin').val();
        
        var buy_price = $this.closest('tr').find('input.prices-options-row-buy-price').val();
        var sell_price;        
                
        sell_price = parseFloat(buy_price) / parseFloat( 1 - (margin / 100)); 
        sell_price = parseFloatPrice(sell_price);        
        $this.closest('tr').find('input.prices-options-row-sell-price').val(sell_price);

    });    
    $('#prices_option_table').on('change','input.prices-options-row-start-date, input.prices-options-row-end-date',function() {
        elementObj = $(this);
        var num = parseInt( elementObj.prop("id").match(/\d+/g) );
        start_date = $(this).closest('tr').find('input.prices-options-row-start-date').val();
        end_date = $(this).closest('tr').find('input.prices-options-row-end-date').val();

        if(start_date != '' && end_date != '' && start_date > end_date ){
            alert('Season End date could not be earlier than  season start date');
            return false;
        }

        $('#prices_option_table').find('input.prices-options-row-start-date').each( function(index, data) {                
            if(index != num) {                
                row_start_date = $(this).closest('tr').find('input.prices-options-row-start-date').val();
                row_end_date = $(this).closest('tr').find('input.prices-options-row-end-date').val();
                if( IsBetween(start_date, row_start_date, row_end_date, elementObj) || IsBetween(end_date, row_start_date, row_end_date, elementObj) ) {
                  alert('Date falls between the date range of row '+(index+1));
                  return false;
               } 
            }               
        });
    });        
    $('.prices-option-table').on('click','.prices-options-row-currency-id', function() {        
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllCurrencies'),
                dataType: 'json',
                type: 'GET',
                data: {ajax_call:1},
                success: function(data) {                     
                    populate_for='prices-options-row';
                    element_name='currency_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
        }
    });     
    $('.prices-option-table').on('click','.prices-options-row-occupancy-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: Router.route('getAllOccupancies'),
                dataType: 'json',
                type: 'GET',                
                data: {ajax_call:1},
                success: function(data) {                     
                    populate_for='prices-options-row';
                    element_name='occupancy_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
        }
    })
     
    /////////////////////////       Click Prices Extra Table Row Operation - Start //////////////////////////

    $('.prices-extra-table').on('click','.prices-extras-row-charging-policy-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllChargingPolicies'),
                dataType: 'json',
                type: 'GET',                
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
                url: Router.route('getAllMealPlans'),
                dataType: 'json',
                type: 'GET',
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
            return false;
        }         

        var margin = $this.closest('tr').find('input.prices-extras-row-price-margin').val();
        margin = parseFloatPrice(margin);

        var buy_price = $this.closest('tr').find('input.prices-extras-row-buy-price').val();
        var sell_price = $this.closest('tr').find('input.prices-extras-row-sell-price').val();
        
        if(sell_price == 0) {
            sell_price = 1;
        }

        var calculateMargin = ((sell_price - buy_price)/sell_price) * 100;
        calculateMargin = parseFloatPrice(calculateMargin);

        if(margin != calculateMargin) {
            if(margin  < calculateMargin) {
                var msg = 'The new increased margin is '+calculateMargin+'%. '                   
            } else if(margin  > calculateMargin) {                   
                var msg = 'The new decreased margin is '+calculateMargin+'%. ';
            }

            if(confirm( msg + 'Do you want to apply this margin everywhere ??? ')) {
                 //applyMarginPrice(calculateMargin);                 
                 $this.closest('tr').find('input.prices-extras-row-price-margin').val(calculateMargin);
            } else {
                //applyMarginPrice(margin);
            }               
        }

     });     
    $('#prices_extra_table').on("focusout",'input.prices-extras-row-price-margin',function()  {
        $this = $(this);
        if($this.val() == '' || $this.val() == 0) {
            alert('Margin could not be empty or zero' );
            $this.focus();
            return false;
        }  
        var margin = $this.closest('tr').find('input.prices-extras-row-price-margin').val();
        
        var buy_price = $this.closest('tr').find('input.prices-extras-row-buy-price').val();
        var sell_price;
                        
        sell_price = parseFloat(buy_price) / parseFloat( 1 - (margin / 100)); 
        sell_price = parseFloatPrice(sell_price);        
        $this.closest('tr').find('input.prices-extras-row-sell-price').val(sell_price);

    });     
    $('#prices_extra_table').on('change','input.prices-extras-row-start-date, input.prices-extras-row-end-date',function() {
        elementObj = $(this);
        var num = parseInt( elementObj.prop("id").match(/\d+/g) );
        start_date = $(this).closest('tr').find('input.prices-extras-row-start-date').val();
        end_date = $(this).closest('tr').find('input.prices-extras-row-end-date').val();

        if(start_date != '' && end_date != '' && start_date > end_date ){
            alert('Season End date could not be earlier than  season start date');
            return false;
        }

        $('#prices_extra_table').find('input.prices-extras-row-start-date').each( function(index, data) {                
            if(index != num) {                
                row_start_date = $(this).closest('tr').find('input.prices-extras-row-start-date').val();
                row_end_date = $(this).closest('tr').find('input.prices-extras-row-end-date').val();
                if( IsBetween(start_date, row_start_date, row_end_date, elementObj) || IsBetween(end_date, row_start_date, row_end_date, elementObj) ) {
                  alert('Date falls between the date range of row '+(index+1));
                  return false;
               } 
            }               
        });
    });        
    $('.prices-extra-table').on('click','.prices-extras-row-currency-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllCurrencies'),
                dataType: 'json',
                type: 'GET',                
                data: {ajax_call:1},
                success: function(data) { 
                    populate_for='prices-extras-row';
                    element_name='currency_id';
                    populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for);           
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });        
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

        if(validationCheck == true) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('saveContract'),
                dataType: 'json',
                type: 'POST',                
                data: $( this ).serialize()+'&contract_id='+contract_id+'&contract_period_id='+contract_period_id+'&season_id='+season_id+'&season_period_id='+season_period_id+'&service_id='+service_id,
                success: function(data) {
                    alert(data.message);                      
                    var url = Router.route('showContract') + '?service_tsid='+data.service_tsid;

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
        var page_no = $('#page_no').val();  
        var contract_id = $( ".contractlist .contract-row:first-child" ).find('input.contract-row-contract-id').val();
        var contract_period_id = $( ".contractlist .contract-row:nth-child(1)" ).find('input.contract-row-contract-period-id').val();
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
             url: Router.route('getServiceSeasonPeriodsData'),
             dataType: 'json',
             type: 'GET',
             data: {contract_id : contract_id, contract_period_id : contract_period_id, service_id : service_id},
             success: function(data) {                 
                 populate_dynamic_data('contracts',data, contract_id, contract_period_id); 
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });            
    }
    function populate_dynamic_data(arg, data, contract_id, contract_period_id, season_id, season_period_id) {
        for (row in data) { 
            // Populate Option Price Data           
            if(row == 'options_all') {
               $('#prices_option_table tbody').empty();
               var counter = 0;
               for (row1 in data[row]) {
                    var options = data[row][row1];  
                    option_price_row_template(counter, options, contract_id, contract_period_id, season_id, season_period_id); 
                    counter++;
                    if(counter >= recordsPerPage) {
                        break;
                    }                   
                }
            }
            // Populate Extra price Data            
            if(row == 'extras_all') {
                $('#prices_extra_table tbody').empty();
                var counter = 0;
                for (row1 in data[row]) {  
                    var extras = data[row][row1];
                    extra_price_row_template(counter, extras, contract_id, contract_period_id, season_id, season_period_id);
                    counter++;
                    if(counter >= recordsPerPage) {
                        break;
                    }
                }
            }
        }
    }
    function option_price_row_template(counter, options, contract_id, contract_period_id, season_id, season_period_id) {
                
        if(options.contract_id != null && contract_id == null) {
            contract_id = options.contract_id;
        }
        if(options.contract_period_id != null && contract_period_id == null) {
            contract_period_id = options.contract_period_id;
        }
        if(options.season_id != null && season_id == null ) {
            season_id = options.season_id;
        }
        if(options.season_period_id != null  && season_period_id == null ) {
            season_period_id = options.season_period_id;
        }
        
        var str_chked = '';
        var is_delete_col = '';
        var str_readonly = '';
        if(options.price_status == 1) {            
            str_chked = ' checked ';
            str_readonly = ' readonly ';
            is_delete_col = '<td class="closeicon remove-options-price-row" id = "remove_options_price_row_'+counter+'"></td>';
        } else {
            is_delete_col = '';
        }

        var weekdays = '';
        if(options.monday == 1) { weekdays += 'monday||'; }
        if(options.tuesday == 1) { weekdays += 'tuesday||'; }
        if(options.wednesday == 1){ weekdays += 'wednesday||'; }
        if(options.thursday == 1){ weekdays += 'thursday||'; }
        if(options.friday == 1){ weekdays += 'friday||'; }
        if(options.saturday == 1){ weekdays += 'saturday||'; }
        if(options.sunday == 1){ weekdays += 'sunday||'; } 
        
        var priceband = '';
        if(options.min > 0) {
            priceband += options.min+'-';
        }
        if(options.max > 0) {
            priceband += options.max;
        }
        
        var weekday_col = '';
        var priceband_col = '';
        var hidden_elements = '';
        var status_active = '';
        var status_inactive = '';
        var buy_price = options.buy_price;       
        buy_price = parseFloatPrice(buy_price);
        var sell_price = options.sell_price;        
        sell_price = parseFloatPrice(sell_price);
        
        if(options.price_currency_id == 0) {
            var service_currency_id = $('#service_currency_id').val();  
            var service_currency_code = $('#service_currency_code').val(); 
            if(service_currency_id == '') {
                service_currency_id = '40';
                service_currency_code = 'INR';
            }
            options.price_currency_id = service_currency_id;
            options.currency_code = service_currency_code;
        }
        //if(options.option_status == 1) {
        if(options.price_status == 1) { // because we options status not working as it gets in duplicate record 
            status_active = 'selected';
        } else  if(options.price_status == 0) {
            status_inactive = 'selected';
        }
        
        if(options.policy_price_bands_id != 'null' && options.policy_price_bands_id != null) {
            
            options.policy_id = "price_bands";
            options.policy_name = "Price Bands";
            
            var policy_price_bands_id = '<input type="hidden" class="form-control prices-options-row-policy-price-band-id" id = "prices_options_row_policy_price_bands_id_'+counter+'" name = "prices_options_row['+counter+'][policy_price_bands_id]" placeholder="policy_price_bands_id" value = "'+options.policy_price_bands_id+'" >' ;
            var service_policy_id_price_band = '<input type="hidden" class="form-control prices-options-row-service-policy-id-price-band" id = "prices_options_row_service_policy_id_price_band_'+counter+'" name = "prices_options_row['+counter+'][service_policy_id_price_band]" placeholder="service_policy_id_price_band" value = "'+options.service_policy_id_price_band+'" >' ;        
            var price_band_id = '<input type="hidden" class="form-control prices-options-row-price-band-id" id = "prices_options_row_price_band_id_'+counter+'" name = "prices_options_row['+counter+'][price_band_id]" placeholder="price_band_id" value = "'+options.price_band_id+'" >' ;
            var price_band_min = '<input type="hidden" class="form-control prices-options-row-price-band-min" id = "prices_options_row_price_band_min_'+counter+'" name = "prices_options_row['+counter+'][price_band_min]" placeholder="price_band_min" value = "'+options.price_band_min+'" >' ;
            var price_band_max = '<input type="hidden" class="form-control prices-options-row-price-band-max" id = "prices_options_row_price_band_max_'+counter+'" name = "prices_options_row['+counter+'][price_band_max]" placeholder="price_band_max" value = "'+options.price_band_max+'" >' ;

            var priceband_col = '<input type="hidden" class="form-control prices-options-row-price-band" id = "prices_options_row_price_band_'+counter+'" name = "prices_options_row['+counter+'][price_band]" placeholder="Price Bands" value = "'+priceband+'" >'+policy_price_bands_id+service_policy_id_price_band+price_band_id+price_band_min+price_band_max;
        }        
        if(options.week_prices_id != 'null' && options.week_prices_id != null) {
            
            options.policy_id = "week_prices";
            options.policy_name = "Week Prices"; 
            
                    
            var week_prices_id = '<input type="hidden" class="form-control prices-options-row-week-prices-id" id = "prices_options_row_week_prices_id_'+counter+'" name = "prices_options_row['+counter+'][week_prices_id]" placeholder="week_prices_id" value = "'+options.week_prices_id+'" >';        
            var week_prices_monday = '<input type="hidden" class="form-control prices-options-row-week-prices-monday" id = "prices_options_row_week_prices_monday_'+counter+'" name = "prices_options_row['+counter+'][week_prices_monday]" placeholder="week_prices_monday" value = "'+options.week_prices_monday+'" >';
            var week_prices_tuesday = '<input type="hidden" class="form-control prices-options-row-week-prices-tuesday" id = "prices_options_row_week_prices_tuesday_'+counter+'" name = "prices_options_row['+counter+'][week_prices_tuesday]" placeholder="week_prices_tuesday" value = "'+options.week_prices_tuesday+'" >';
            var week_prices_wednesday = '<input type="hidden" class="form-control prices-options-row-week-prices-wednesday" id = "prices_options_row_week_prices_wednesday_'+counter+'" name = "prices_options_row['+counter+'][week_prices_wednesday]" placeholder="week_prices_wednesday" value = "'+options.week_prices_wednesday+'" >';
            var week_prices_thursday = '<input type="hidden" class="form-control prices-options-row-week-prices-thursday" id = "prices_options_row_week_prices_thursday_'+counter+'" name = "prices_options_row['+counter+'][week_prices_thursday]" placeholder="week_prices_thursday" value = "'+options.week_prices_thursday+'" >';        
            var week_prices_friday = '<input type="hidden" class="form-control prices-options-row-week-prices-friday" id = "prices_options_row_week_prices_friday_'+counter+'" name = "prices_options_row['+counter+'][week_prices_friday]" placeholder="week_prices_friday" value = "'+options.week_prices_friday+'" >';
            var week_prices_saturday = '<input type="hidden" class="form-control prices-options-row-week-prices-saturday" id = "prices_options_row_week_prices_saturday_'+counter+'" name = "prices_options_row['+counter+'][week_prices_saturday]" placeholder="week_prices_saturday" value = "'+options.week_prices_saturday+'" >';
            var week_prices_sunday = '<input type="hidden" class="form-control prices-options-row-week-prices-sunday" id = "prices_options_row_week_prices_sunday_'+counter+'" name = "prices_options_row['+counter+'][week_prices_sunday]" placeholder="week_prices_sunday" value = "'+options.week_prices_sunday+'" >';

            var weekday_col = '<input type="hidden" class="form-control prices-options-row-week-days" id = "prices_options_row_week_days_'+counter+'" name = "prices_options_row['+counter+'][week_days]" placeholder="week Days" value = "'+weekdays+'" >'+week_prices_id+week_prices_monday+week_prices_tuesday+week_prices_wednesday+week_prices_thursday+week_prices_friday+week_prices_saturday+week_prices_sunday; 
        }    
        
        var is_active_col = '<td ><div class="form-group"><input type="checkbox" class="form-control prices-options-row-is-active" id = "prices_options_row_is_active_'+counter+'" name = "prices_options_row['+counter+'][is_active]" placeholder="Is Active" value = "'+options.price_id+'" '+ str_chked +' ></div></td>';
        var meal_plan_col = '<td ><div class="form-group"><select class="form-control topalignlast prices-options-row-meal-plan-id" id="prices_options_row_meal_plan_id_'+counter+'" name ="prices_options_row['+counter+'][meal_plan_id]"><option value = "'+options.meal_plan_id+'" >'+options.meal_plan_name+'</option></select></div></td>';
        var occupancy_col = '<td ><div class="form-group"><select class="form-control topalignlast prices-options-row-occupancy-id" id="prices_options_row_occupancy_id_'+counter+'" name ="prices_options_row['+counter+'][occupancy_id]"><option value = "'+options.occupancy_id+'" >'+options.occupancy_name+'</option></select></div></td>';
        var from_col = '<td class="wdt11per"><div class="form-group"><input type="text" class="form-control start-date pointerclass prices-options-row-start-date" id = "prices_options_row_start_date_'+counter+'" name = "prices_options_row['+counter+'][start_date]" placeholder="start_date" value = "'+options.season_period_start_date+'" ><input type="hidden" class="form-control prices-options-row-season-period-id" id = "prices_options_row_season_period_id_'+counter+'" name = "prices_options_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+options.season_period_id+'" ></div></td>';
        var to_col = '<td class="wdt11per"><div class="form-group"><input type="text" class="form-control start-date  pointerclass prices-options-row-end-date" id = "prices_options_row_end_date_'+counter+'" name = "prices_options_row['+counter+'][end_date]" placeholder="end_date" value = "'+options.season_period_end_date+'" ></div></td>';
        var currency_col = '<td ><div class="form-group"><select class="form-control topalignlast prices-options-row-currency-id" id="prices_options_row_currency_id_'+counter+'" name ="prices_options_row['+counter+'][currency_id]"><option value = "'+options.price_currency_id+'" >'+options.currency_code+'</option></select></div></td>';
        var margin_col = '<td ><div class="form-group"><input type="text" class="form-control prices-options-row-price-margin" id = "prices_options_row_price_margin_'+counter+'" name = "prices_options_row['+counter+'][price_margin]" placeholder="price_margin" value = "'+options.price_margin+'" ></div></td>';
        var status_col = '<td ><div class="form-group"><select class="form-control topalignlast prices-options-row-status" id="prices_options_row_status_'+counter+'" name ="prices_options_row['+counter+'][status]"><option value = "1" '+status_active+'>Active</option><option value = "0" '+status_inactive+'>In-Active</option></select></div></td>';
        
        $prices_options_row_start_date_counter = '#prices_options_row_start_date_'+counter;
        $prices_options_row_end_date_counter = '#prices_options_row_end_date_'+counter;
        $($prices_options_row_start_date_counter).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose:true,
            showOtherMonths: true,
            selectOtherMonths: true
            });//.attr('readonly', 'readonly');
        $($prices_options_row_end_date_counter).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose:true,
            showOtherMonths: true,
            selectOtherMonths: true
            });//.attr('readonly', 'readonly');
        
        is_delete_col = '';
                
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-price-id" id = "prices_options_row_price_id" name = "prices_options_row['+counter+'][price_id]" placeholder="Option ID" value = "'+options.price_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-option-id" id = "prices_options_row_option_id" name = "prices_options_row['+counter+'][option_id]" placeholder="Option ID" value = "'+options.option_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-contract-id" id = "prices_options_row_contract_id" name = "prices_options_row['+counter+'][contract_id]" placeholder="Contract ID" value = "'+contract_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-contract-period-id" id = "prices_options_row_contract_period_id" name = "prices_options_row['+counter+'][contract_period_id]" placeholder="Contract Period ID" value = "'+contract_period_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-season-id" id = "prices_options_row_season_id" name = "prices_options_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'">';        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-season-period-id" id = "prices_options_row_season_period_id" name = "prices_options_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'">';
        
        $('#prices_option_table').find('tbody').append('<tr class = "prices-options-row" id ="prices_options_row_'+counter+'">'+is_active_col+'<td >'+hidden_elements+'<div class="form-group">'+priceband_col+weekday_col+'<input id ="prices_options_row_option_name_'+counter+'" type="text" class="form-control prices-options-row-option-name" name = "prices_options_row['+counter+'][option_name]" placeholder="Option Name" value = "'+options.option_name+'" ></div></td>'+occupancy_col+from_col+to_col+'<td ><div class="form-group"><select class="form-control topalignlast prices-options-row-charging-policy-id" id="prices_options_row_charging_policy_id_'+counter+'" name ="prices_options_row['+counter+'][charging_policy_id]"><option value = "'+options.policy_id+'" >'+options.policy_name+'</option></select></div></td>'+meal_plan_col+currency_col+'<td ><div class="form-group"><input type="text" class="form-control prices-options-row-buy-price" name ="prices_options_row['+counter+'][buy_price]" id = "prices_options_row_buy_price_'+counter+'" placeholder="Buy Price" value = "'+buy_price+'"></div</td><td ><div class="form-group"><input type="text" class="form-control prices-options-row-sell-price" name ="prices_options_row['+counter+'][sell_price]" id = "prices_options_row_sell_price_'+counter+'" placeholder=" Sell Price" value = "'+sell_price+'"></div></td>'+margin_col+status_col+is_delete_col+'</tr>');
    }
    function extra_price_row_template(counter, extras, contract_id, contract_period_id, season_id, season_period_id) {

        if(extras.contract_id != null && contract_id == null) {
            contract_id = extras.contract_id;
        }
        if(extras.contract_period_id != null && contract_period_id == null) {
            contract_period_id = extras.contract_period_id;
        }
        if(extras.season_id != null && season_id == null ) {
            season_id = extras.season_id;
        }
        if(extras.season_period_id != null  && season_period_id == null ) {
            season_period_id = extras.season_period_id;
        }
        
        var str_chked = '';
        var is_delete_col = '';
        var str_readonly = '';
        var weekdays = '';
        var weekday_col = '';
        var priceband_col = '';
        var priceband = '';
        var hidden_elements = '';
        var mandatory_yes = '';
        var mandatory_no = '';
        var status_active = '';
        var status_inactive = '';

        if(extras.price_status == 1) {            
            str_chked = ' checked ';
            str_readonly = ' readonly ';
            is_delete_col = '<td class="closeicon remove-extras-price-row" id = "remove_extras_price_row'+counter+'"></td>';
        } else {
            is_delete_col = '';
        }
        
        if(extras.monday == 1) { weekdays += 'monday||'; }
        if(extras.tuesday == 1) { weekdays += 'tuesday||'; }
        if(extras.wednesday == 1){ weekdays += 'wednesday||'; }
        if(extras.thursday == 1){ weekdays += 'thursday||'; }
        if(extras.friday == 1){ weekdays += 'friday||'; }
        if(extras.saturday == 1){ weekdays += 'saturday||'; }
        if(extras.sunday == 1){ weekdays += 'sunday||'; } 
                
        if(extras.min > 0) {
            priceband += options.min+'-';
        }
        if(extras.max > 0) {
            priceband += options.max;
        }
                
        if(extras.policy_price_bands_id != 'null' && extras.policy_price_bands_id != null) {
            
            extras.policy_id = "price_bands";
            extras.policy_name = "Price Bands";
            
            var policy_price_bands_id = '<input type="hidden" class="form-control prices-extras-row-policy-price-band-id" id = "prices_extras_row_policy_price_bands_id_'+counter+'" name = "prices_extras_row['+counter+'][policy_price_bands_id]" placeholder="policy_price_bands_id" value = "'+extras.policy_price_bands_id+'" >' ;
            var service_policy_id_price_band = '<input type="hidden" class="form-control prices-extras-row-service-policy-id-price-band" id = "prices_extras_row_service_policy_id_price_band_'+counter+'" name = "prices_extras_row['+counter+'][service_policy_id_price_band]" placeholder="service_policy_id_price_band" value = "'+extras.service_policy_id_price_band+'" >' ;        
            var price_band_id = '<input type="hidden" class="form-control prices-extras-row-price-band-id" id = "prices_extras_row_price_band_id_'+counter+'" name = "prices_extras_row['+counter+'][price_band_id]" placeholder="price_band_id" value = "'+extras.price_band_id+'" >' ;
            var price_band_min = '<input type="hidden" class="form-control prices-extras-row-price-band-min" id = "prices_extras_row_price_band_min_'+counter+'" name = "prices_extras_row['+counter+'][price_band_min]" placeholder="price_band_min" value = "'+extras.price_band_min+'" >' ;
            var price_band_max = '<input type="hidden" class="form-control prices-extras-row-price-band-max" id = "prices_extras_row_price_band_max_'+counter+'" name = "prices_extras_row['+counter+'][price_band_max]" placeholder="price_band_max" value = "'+extras.price_band_max+'" >' ;

            var priceband_col = '<input type="hidden" class="form-control prices-extras-row-price-band" id = "prices_extras_row_price_band_'+counter+'" name = "prices_extras_row['+counter+'][price_band]" placeholder="Price Bands" value = "'+priceband+'" >'+policy_price_bands_id+service_policy_id_price_band+price_band_id+price_band_min+price_band_max;
        }                
        if(extras.week_prices_id != 'null' && extras.week_prices_id != null) {
            
            extras.policy_id = "week_prices";
            extras.policy_name = "Week Prices";
            
            var week_prices_id = '<input type="hidden" class="form-control prices-extras-row-week-prices-id" id = "prices_extras_row_week_prices_id_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_id]" placeholder="week_prices_id" value = "'+extras.week_prices_id+'" >';        
            var week_prices_monday = '<input type="hidden" class="form-control prices-extras-row-week-prices-monday" id = "prices_extras_row_week_prices_monday_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_monday]" placeholder="week_prices_monday" value = "'+extras.week_prices_monday+'" >';
            var week_prices_tuesday = '<input type="hidden" class="form-control prices-extras-row-week-prices-tuesday" id = "prices_extras_row_week_prices_tuesday_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_tuesday]" placeholder="week_prices_tuesday" value = "'+extras.week_prices_tuesday+'" >';
            var week_prices_wednesday = '<input type="hidden" class="form-control prices-extras-row-week-prices-wednesday" id = "prices_extras_row_week_prices_wednesday_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_wednesday]" placeholder="week_prices_wednesday" value = "'+extras.week_prices_wednesday+'" >';
            var week_prices_thursday = '<input type="hidden" class="form-control prices-extras-row-week-prices-thursday" id = "prices_extras_row_week_prices_thursday_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_thursday]" placeholder="week_prices_thursday" value = "'+extras.week_prices_thursday+'" >';        
            var week_prices_friday = '<input type="hidden" class="form-control prices-extras-row-week-prices-friday" id = "prices_extras_row_week_prices_friday_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_friday]" placeholder="week_prices_friday" value = "'+extras.week_prices_friday+'" >';
            var week_prices_saturday = '<input type="hidden" class="form-control prices-extras-row-week-prices-saturday" id = "prices_extras_row_week_prices_saturday_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_saturday]" placeholder="week_prices_saturday" value = "'+extras.week_prices_saturday+'" >';
            var week_prices_sunday = '<input type="hidden" class="form-control prices-extras-row-week-prices-sunday" id = "prices_extras_row_week_prices_sunday_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_sunday]" placeholder="week_prices_sunday" value = "'+extras.week_prices_sunday+'" >';

            var weekday_col = '<input type="hidden" class="form-control prices-extras-row-week-days" id = "prices_extras_row_week_days_'+counter+'" name = "prices_extras_row['+counter+'][week_days]" placeholder="week Days" value = "'+weekdays+'" >'+week_prices_id+week_prices_monday+week_prices_tuesday+week_prices_wednesday+week_prices_thursday+week_prices_friday+week_prices_saturday+week_prices_sunday;
        }        
        if(extras.mandatory == 1) {
            mandatory_yes = 'selected';
        } else if(extras.mandatory == 0) {
            mandatory_no = 'selected';
        }
        if(extras.price_currency_id == 0) {
            var service_currency_id = $('#service_currency_id').val();  
            var service_currency_code = $('#service_currency_code').val(); 
            if(service_currency_id == '') {
                service_currency_id = '40';
                service_currency_code = 'INR';
            }
            extras.price_currency_id = service_currency_id;
            extras.currency_code = service_currency_code;
        }
        if(extras.extra_status == 1) {
            status_active = 'selected';
        } else  if(extras.extra_status == 0) {
            status_inactive = 'selected';
        }
                
        var is_active_col = '<td ><div class="form-group"><input type="checkbox" class="form-control prices-extras-row-is-active" id = "prices_extras_row_is_active_'+counter+'" name = "prices_extras_row['+counter+'][is_active]" placeholder="Is Active" value = "'+extras.price_id+'" '+ str_chked +' ></div></td>';
        var meal_plan_col = '<td ><div class="form-group"><i class="dropdown-icon2"></i><select class="form-control topalignlast prices-extras-row-meal-plan-id" id="prices_extras_row_meal_plan_id_'+counter+'" name ="prices_extras_row['+counter+'][meal_plan_id]"><option value = "'+extras.meal_plan_id+'" >'+extras.meal_plan_name+'</option></select></div></td>';
        meal_plan_col = '';
        
        var buy_price = extras.buy_price;
        buy_price = parseFloatPrice(buy_price);

        var sell_price = extras.sell_price;
        sell_price = parseFloatPrice(sell_price);        

        var from_col = '<td class="wdt11per"><div class="form-group"><input type="text" class="form-control start-date pointerclass prices-extras-row-start-date" id = "prices_extras_row_start_date_'+counter+'" name = "prices_extras_row['+counter+'][start_date]" placeholder="From" value = "'+extras.season_period_start_date+'" ><input type="hidden" class="form-control prices-extras-row-season-period-id" id = "prices_extras_row_season_period_id_'+counter+'" name = "prices_extras_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+extras.season_period_id+'" ></div></td>';
        var to_col = '<td class="wdt11per"><div class="form-group"><input type="text" class="form-control start-date  pointerclass prices-extras-row-end-date" id = "prices_extras_row_end_date_'+counter+'" name = "prices_extras_row['+counter+'][end_date]" placeholder="end_date" value = "'+extras.season_period_end_date+'" ></div></td>';
        var mandatory_col = '<td ><div class="form-group"><select class="form-control topalignlast prices-extras-row-mandatory" id="prices_extras_row_mandatory_'+counter+'" name ="prices_extras_row['+counter+'][mandatory]"><option value = "1" '+mandatory_yes+'>Yes</option><option value = "0" '+mandatory_no+'>No</option></select></div></td>';
        var currency_col = '<td ><div class="form-group"><select class="form-control topalignlast prices-extras-row-currency-id" id="prices_extras_row_currency_id_'+counter+'" name ="prices_extras_row['+counter+'][currency_id]"><option value = "'+extras.price_currency_id+'" >'+extras.currency_code+'</option></select></div></td>';
        var margin_col = '<td ><div class="form-group"><input type="text" class="form-control prices-extras-row-price-margin" id = "prices_extras_row_price_margin_'+counter+'" name = "prices_extras_row['+counter+'][price_margin]" placeholder="price_margin" value = "'+extras.price_margin+'" ></div></td>';
        var status_col = '<td ><div class="form-group"><select class="form-control topalignlast prices-extras-row-status" id="prices_extras_row_status_'+counter+'" name ="prices_extras_row['+counter+'][status]"><option value = "1" '+status_active+'>Active</option><option value = "0" '+status_inactive+'>In-Active</option></select></div></td>';
        
        $prices_extras_row_start_date_counter = '#prices_extras_row_start_date_'+counter;
        $prices_extras_row_end_date_counter = '#prices_extras_row_end_date_'+counter;
        $($prices_extras_row_start_date_counter).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose:true,
            showOtherMonths: true,
            selectOtherMonths: true
            });//.attr('readonly', 'readonly');
        $($prices_extras_row_end_date_counter).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose:true,
            showOtherMonths: true,
            selectOtherMonths: true
            });//.attr('readonly', 'readonly');

is_delete_col = '';

        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-price-id" id = "prices_extras_row_price_id" name = "prices_extras_row['+counter+'][price_id]" placeholder="Extra PRICE ID" value = "'+extras.price_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-extra-id" id = "prices_extras_row_extra_id" name = "prices_extras_row['+counter+'][extra_id]" placeholder="Extra ID" value = "'+extras.extra_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-contract-id" id = "prices_extras_row_contract_id" name = "prices_extras_row['+counter+'][contract_id]" placeholder="contract ID" value = "'+contract_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-contract-period-id" id = "prices_extras_row_contract_period_id" name = "prices_extras_row['+counter+'][contract_period_id]" placeholder="contract Period ID" value = "'+contract_period_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-season-id" id = "prices_extras_row_season_id" name = "prices_extras_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-season-period-id "id = "prices_extras_row_season_period_id" name = "prices_extras_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'">';

        $('#prices_extra_table').find('tbody').append('<tr class = "prices-extras-row" id = "prices_extras_row_'+counter+'">'+is_active_col+'<td >'+hidden_elements+'<div class="form-group">'+priceband_col+weekday_col+'<input id ="prices_extras_row_extra_name_'+counter+'" type="text" class="form-control prices-extras-row-extra-name" name = "prices_extras_row['+counter+'][extra_name]" placeholder="prices_extras_row_extras_name" value = "'+extras.extra_name+'" ></div></td>'+from_col+to_col+meal_plan_col+'<td ><div class="form-group"><select class="form-control topalignlast prices-extras-row-charging-policy-id" id="prices_extras_row_charging_policy_id_'+counter+'" name ="prices_extras_row['+counter+'][charging_policy_id]"><option value = "'+extras.policy_id+'">'+extras.policy_name+'</option></select></div></td>'+mandatory_col+currency_col+'<td ><div class="form-group"><input type="text" class="form-control prices-extras-row-buy-price" name="prices_extras_row['+counter+'][buy_price]" id= "prices_extras_row_buy_price_'+counter+'" placeholder="Buy Price"  value = "'+buy_price+'"></div></td><td ><div class="form-group"><input type="text" class="form-control prices-extras-row-sell-price" name ="prices_extras_row['+counter+'][sell_price]" id = "prices_extras_row_sell_price_'+counter+'" placeholder="Sell Price"  value = "'+sell_price+'"></div></td>'+margin_col+status_col+is_delete_col+'</tr>');

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
            
            /////////////////////////////////////
            $trNew.find( '.prices-extras-row-policy-price-band-id' ).prop('id', 'prices_extras_row_policy_price_bands_id_'+num ).prop('name', 'prices_extras_row['+num+'][policy_price_bands_id]').val('');
            $trNew.find( '.prices-extras-row-service-policy-id-price-band' ).prop('id', 'prices_extras_row_service_policy_id_price_band_'+num ).prop('name', 'prices_extras_row['+num+'][service_policy_id_price_band]').val('');
            $trNew.find( '.prices-extras-row-price-band-id' ).prop('id', 'prices_extras_row_price_band_id_'+num ).prop('name', 'prices_extras_row['+num+'][price_band_id]').val('');
            $trNew.find( '.prices-extras-row-price-band-min' ).prop('id', 'prices_extras_row_price_band_min_'+num ).prop('name', 'prices_extras_row['+num+'][price_band_min]').val('');
            $trNew.find( '.prices-extras-row-price-band-max' ).prop('id', 'prices_extras_row_price_band_max_'+num ).prop('name', 'prices_extras_row['+num+'][price_band_max]').val('');
            
            $trNew.find( '.prices-extras-row-week-prices-id' ).prop('id', 'prices_extras_row_week_prices_id_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_id]').val('');
            $trNew.find( '.prices-extras-row-week-prices-monday' ).prop('id', 'prices_extras_row_week_prices_monday_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_monday]').val('');
            $trNew.find( '.prices-extras-row-week-prices-tuesday' ).prop('id', 'prices_extras_row_week_prices_tuesday_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_tuesday]').val('');
            $trNew.find( '.prices-extras-row-week-prices-wednesday' ).prop('id', 'prices_extras_row_week_prices_wednesday_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_wednesday]').val('');
            $trNew.find( '.prices-extras-row-week-prices-thursday' ).prop('id', 'prices_extras_row_week_prices_thursday_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_thursday]').val('');
            $trNew.find( '.prices-extras-row-week-prices-friday' ).prop('id', 'prices_extras_row_week_prices_friday_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_friday]').val('');
            $trNew.find( '.prices-extras-row-week-prices-saturday' ).prop('id', 'prices_extras_row_week_prices_saturday_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_saturday]').val('');
            $trNew.find( '.prices-extras-row-week-prices-sunday' ).prop('id', 'prices_extras_row_week_prices_sunday_'+num ).prop('name', 'prices_extras_row['+num+'][week_prices_sunday]').val('');
            /////////////////////////////////////
            
            //##############################
            
            //from col
            $trNew.find( '.prices-extras-row-start-date' ).prop('id', 'prices_extras_row_start_date_'+num ).prop('name', 'prices_extras_row['+num+'][start_date]').val('');
            //to col
            $trNew.find( '.prices-extras-row-end-date' ).prop('id', 'prices_extras_row_end_date_'+num ).prop('name', 'prices_extras_row['+num+'][end_date]').val('');
            //currency col
            $trNew.find( '.prices-extras-row-currency-id' ).prop('id', 'prices_extras_row_currency_id_'+num ).prop('name', 'prices_extras_row['+num+'][currency_id]');
            //margin col
            $trNew.find( '.prices-extras-row-price-margin' ).prop('id', 'prices_extras_row_price_margin_'+num ).prop('name', 'prices_extras_row['+num+'][price_margin]').val('0.00');
            //status col
            $trNew.find( '.prices-extras-row-status' ).prop('id', 'prices_extras_row_status_'+num ).prop('name', 'prices_extras_row['+num+'][status]');
            
            //##############################

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

            $trNew.find( 'input.prices-options-row-contract-id' ).prop('id', 'prices_options_row_contract_id_'+num ).prop('name', 'prices_options_row['+num+'][contract_id]').val('');
            $trNew.find( 'input.prices-options-row-contract-period-id' ).prop('id', 'prices_options_row_contract_period_id_'+num ).prop('name', 'prices_options_row['+num+'][contract_period_id]').val('');
            $trNew.find( 'input.prices-options-row-season-id' ).prop('id', 'prices_options_row_season_id_'+num ).prop('name', 'prices_options_row['+num+'][season_id]').val('');
            $trNew.find( 'input.prices-options-row-season-period-id' ).prop('id', 'prices_options_row_season_period_id_'+num ).prop('name', 'prices_options_row['+num+'][season_period_id]').val('');
            $trNew.find( '.prices-options-row-charging-policy-id' ).prop('id', 'prices_options_row_charging_policy_id_'+num ).prop('name', 'prices_options_row['+num+'][charging_policy_id]');
            $trNew.find( 'input.prices-options-row-buy-price' ).prop('id', 'prices_options_row_buy_price_'+num ).prop('name', 'prices_options_row['+num+'][buy_price]').val('');
            $trNew.find( 'input.prices-options-row-sell-price' ).prop('id', 'prices_options_row_sell_price_'+num ).prop('name', 'prices_options_row['+num+'][sell_price]').val('');
            $trNew.find( '.remove-options-price-row' ).prop('id', 'remove_options_price_row_'+num );

            $trNew.find( '.prices-options-row-meal-plan-id' ).prop('id', 'prices_options_row_meal_plan_id_'+num ).prop('name', 'prices_options_row['+num+'][meal_plan_id]');

            $trNew.find( '.prices-options-row-is-active' ).prop('id', 'prices_options_row_is_active_'+num ).prop('name', 'prices_options_row['+num+'][is_active]');
           
           /////////////////////////////////////            
            $trNew.find( '.prices-options-row-policy-price-band-id' ).prop('id', 'prices_options_row_policy_price_bands_id_'+num ).prop('name', 'prices_options_row['+num+'][policy_price_bands_id]').val('');
            $trNew.find( '.prices-options-row-service-policy-id-price-band' ).prop('id', 'prices_options_row_service_policy_id_price_band_'+num ).prop('name', 'prices_options_row['+num+'][service_policy_id_price_band]').val('');
            $trNew.find( '.prices-options-row-price-band-id' ).prop('id', 'prices_options_row_price_band_id_'+num ).prop('name', 'prices_options_row['+num+'][price_band_id]').val('');
            $trNew.find( '.prices-options-row-price-band-min' ).prop('id', 'prices_options_row_price_band_min_'+num ).prop('name', 'prices_options_row['+num+'][price_band_min]').val('');
            $trNew.find( '.prices-options-row-price-band-max' ).prop('id', 'prices_options_row_price_band_max_'+num ).prop('name', 'prices_options_row['+num+'][price_band_max]').val(''); 
            
            $trNew.find( '.prices-options-row-week-prices-id' ).prop('id', 'prices_options_row_week_prices_id_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_id]').val('');
            $trNew.find( '.prices-options-row-week-prices-monday' ).prop('id', 'prices_options_row_week_prices_monday_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_monday]').val('');
            $trNew.find( '.prices-options-row-week-prices-tuesday' ).prop('id', 'prices_options_row_week_prices_tuesday_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_tuesday]').val('');
            $trNew.find( '.prices-options-row-week-prices-wednesday' ).prop('id', 'prices_options_row_week_prices_wednesday_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_wednesday]').val('');
            $trNew.find( '.prices-options-row-week-prices-thursday' ).prop('id', 'prices_options_row_week_prices_thursday_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_thursday]').val('');
            $trNew.find( '.prices-options-row-week-prices-friday' ).prop('id', 'prices_options_row_week_prices_friday_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_friday]').val('');
            $trNew.find( '.prices-options-row-week-prices-saturday' ).prop('id', 'prices_options_row_week_prices_saturday_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_saturday]').val('');
            $trNew.find( '.prices-options-row-week-prices-sunday' ).prop('id', 'prices_options_row_week_prices_sunday_'+num ).prop('name', 'prices_options_row['+num+'][week_prices_sunday]').val('');
            /////////////////////////////////////
            
            //##############################
            
            
            //occ col
            $trNew.find( '.prices-options-row-occupancy-id' ).prop('id', 'prices_options_row_occupancy_id_'+num ).prop('name', 'prices_options_row['+num+'][occupancy_id]');
            //from col
            $trNew.find( '.prices-options-row-start-date' ).prop('id', 'prices_options_row_start_date_'+num ).prop('name', 'prices_options_row['+num+'][start_date]').val('');
            //to col
            $trNew.find( '.prices-options-row-end-date' ).prop('id', 'prices_options_row_end_date_'+num ).prop('name', 'prices_options_row['+num+'][end_date]').val('');
            //currency col
            $trNew.find( '.prices-options-row-currency-id' ).prop('id', 'prices_options_row_currency_id_'+num ).prop('name', 'prices_options_row['+num+'][currency_id]');
            //margin col
            $trNew.find( '.prices-options-row-price-margin' ).prop('id', 'prices_options_row_price_margin_'+num ).prop('name', 'prices_options_row['+num+'][price_margin]').val('0.00');
            //status col
            $trNew.find( '.prices-options-row-status' ).prop('id', 'prices_options_row_status_'+num ).prop('name', 'prices_options_row['+num+'][status]');
            
            //##############################

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
        
        var element_class_name = element_name.replace(/\_/g,'-');

        if(populate_for=='prices-extras-row') {
            $str_select = '<select class ="prices-extras-row-'+element_class_name+'" name ="prices_extras_row['+num+']['+element_name+']" id="prices_extras_row_'+element_name+'_'+counter+'" >';
        } else if(populate_for=='prices-options-row') {
            $str_select = '<select class ="prices-options-row-'+element_class_name+'" name ="prices_options_row['+num+']['+element_name+']" id="prices_options_row_'+element_name+'_'+counter+'" >';
        } else if(populate_for=='season-period-row') {
            $str_select = '<select class ="season-period-row-'+element_class_name+'" name ="season_period_row['+num+']['+element_name+']" id="season_period_row_'+element_name+'_'+counter+'" >';
        } 

        var $str_option = '';         

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

        if(element_name=='charging_policy_id') {
                
            if( select_val.trim() == 'Price Bands' && $this.val() == 'price_bands') {
                $str_option = $str_option + '<option value="price_bands" selected> Price Bands </option>';
            } else {
                $str_option = $str_option + '<option value="price_bands"> Price Bands </option>';
            }

            if( select_val.trim() == 'Week Prices' && $this.val() == 'week_prices') {
                $str_option = $str_option + '<option value="week_prices" selected> Week Prices </option>';
            } else {
                $str_option = $str_option + '<option value="week_prices"> Week Prices </option>';
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


        contract_id = '';
        contract_period_id = '';
        season_id = '';
        season_period_id = '';
        service_option_name = '';
        
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
            
            options.occupancy_id = '';
            options.occupancy_name = '[select one]';
            options.season_period_start_date = '';
            options.season_period_end_date = '';
            options.price_currency_id = '0';
            options.price_margin = '0.00';
            options.status = '[select one]';
            options.currency_code = '';

        option_price_row_template(counter, options, contract_id, contract_period_id, season_id, season_period_id);
    }
    function add_new_extra_price_row(service_extras_name) {

        var counter = 0;
        var $seasonPeriod = $('#season_period_table .row-highlighted');                
        var contract_id = $seasonPeriod.find('input.season-period-row-contract-id').val();
        var contract_period_id = $seasonPeriod.find('input.season-period-row-contract-period-id').val();
        var season_id = $seasonPeriod.find('input.season-period-row-season-id').val();
        var season_period_id = $seasonPeriod.find('input.season-period-row-season-period-id').val();

        contract_id = '';
        contract_period_id = '';
        season_id = '';
        season_period_id = '';
        service_extras_name = '';
        
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
            
            
            extras.season_period_start_date = '';
            extras.season_period_end_date = '';
            extras.price_currency_id = '0';
            extras.price_margin = '0.00';
            extras.status = '[select one]';
            extras.currency_code = '';
            extras.mandatory = '0';


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
        //alert('validationCheck : '+isValidSeasonPeriods());
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
        //applyMarginPrice(margin);                
        return true;
    }
    function isValidExtraPrices() {
//        var margin = $(".season-period-table .row-highlighted").find('input.season-period-row-margin').val();
//        margin = parseFloatPrice(margin);
//        applyMarginPrice(margin);                
        return true;
    }
  
});