jQuery(document).ready(function ($) {
    $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
        options.async = false;
    });
    
    var recordsPerPage = 10;
    var deleteConfirmMsg = "Are you sure you want to delete this item?";
    var statusInActiveConfirmMsg = "Are you sure you want to In-Active this item?";
    
    func_onload_with_allseason_periods();
    
    $('.select-supplier').change(function() {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},            
            url: Router.route('getResionsForSupplier'),
            dataType: 'json',
            type: 'GET',  
            async: false,
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
            async: false,
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
    
    $('.prices-option-table').on('click','.prices-options-row-occupancy-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: Router.route('getAllOccupancies'),
                dataType: 'json',
                type: 'GET',
                async: false,
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
    }); 
    $('.prices-option-table').on('click','.prices-options-row-charging-policy-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllChargingPolicies'),
                dataType: 'json',
                type: 'GET', 
                async: false,
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
                async: false,
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
    $('.prices-option-table').on('click','.prices-options-row-currency-id', function() {        
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllCurrencies'),
                dataType: 'json',
                type: 'GET',
                async: false,
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
    
    
    $('.prices-extra-table').on('click','.prices-extras-row-charging-policy-id', function() {        
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllChargingPolicies'),
                dataType: 'json',
                type: 'GET', 
                async: false,
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
    $('.prices-extra-table').on('click','.prices-extras-row-currency-id', function() {
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllCurrencies'),
                dataType: 'json',
                type: 'GET',      
                async: false,
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
    
    $('.modal').on('click','.prices-options-row-price-bands-charging-policy-id', function() {
        alert('hi');
        if($(this).find('option').length == 1) {
            element_obj = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('getAllChargingPolicies'),
                dataType: 'json',
                type: 'GET', 
                async: false,
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
    
    $('.prices-options-table-status').change( function(){
        func_onload_with_allseason_periods();
    });
    $('.prices-extras-table-status').change( function(){
        func_onload_with_allseason_periods();
    });
    
    
    $('body').on('blur', '.prices-options-row-price-margin', function() {
        if(isNaN(($(this).val()).replace('%',''))){
            $(".prices-options-row-price-margin").addClass("errorbox");
        }else{
            if($(this).val()!=""){
                $(".prices-options-row-price-margin").val(($(this).val()).replace('%','')+"%");
                $(".prices-options-row-price-margin").removeClass("errorbox");
            }else{
                $(".prices-options-row-price-margin").addClass("errorbox");
            }
        }
    });
    $('body').on('blur', '.prices-extras-row-price-margin', function() {
        if(isNaN(($(this).val()).replace('%',''))){
            $(".prices-extras-row-price-margin").addClass("errorbox");
        }else{
            if($(this).val()!=""){
                $(".prices-extras-row-price-margin").val(($(this).val()).replace('%','')+"%");
                $(".prices-extras-row-price-margin").removeClass("errorbox");
            }else{
                $(".prices-extras-row-price-margin").addClass("errorbox");
            }
        }
    });
   
   //    / -------------  Automatic Margin[%] calculation in OPTIONS ------------- /
    $('body').on('keyup', '.prices-options-row-buy-price', function() {
        if(parseInt($(".prices-options-row-buy-price").val()) > 0){
            if($(this).val()!="" && $(this).val()!="%"){
                var revenue_margin = 1-(parseInt($(".prices-options-row-price-margin").val())/100);
                var revenue_sell_price = parseInt($(".prices-options-row-buy-price").val()) / revenue_margin ;
                $(".prices-options-row-sell-price").val(revenue_sell_price);
                
                $(".prices-options-row-sell-price").removeClass("errorbox");
                $(".prices-options-row-buy-price").removeClass("errorbox");
            }
        }else{
            $(".prices-options-row-buy-price").addClass("errorbox");
        }
    });
    $('body').on('keyup', '.prices-options-row-sell-price', function() {
        if(parseInt($(".prices-options-row-sell-price").val()) >= parseInt($(".prices-options-row-buy-price").val())){            
            var revenue_margin = (1-($(".prices-options-row-buy-price").val()/$(this).val()))*100;
            $(".prices-options-row-price-margin").val(revenue_margin);
            $(".prices-options-row-sell-price").removeClass("errorbox");
            $(".prices-options-row-buy-price").removeClass("errorbox");
        }else{
            $(".prices-options-row-sell-price").addClass("errorbox");
            $(".prices-options-row-price-margin").val("");
        }
    });
    $('body').on('change', '.prices-options-row-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#prices_options_row_price_edited_'+num
        $(s_price_edited).val(1);
    });
    $('body').on('change', '.prices-options-row-sell-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#prices_options_row_price_edited_'+num
        $(s_price_edited).val(1);
    });
    

//    / -------------  Automatic SELL calculation in OPTIONS ------------- /
    $('body').on('keyup', '.prices-options-row-price-margin', function() {
        if(parseInt($(".prices-options-row-buy-price").val()) > 0){
            if($(this).val()!="" && $(this).val()!="%"){
                var revenue_margin = 1-(parseInt($(this).val())/100);
                var revenue_sell_price = parseFloatPrice(parseInt($(".prices-options-row-buy-price").val()) / revenue_margin) ;
                $(".prices-options-row-sell-price").val(revenue_sell_price);
                $(".prices-options-row-sell-price").removeClass("errorbox");
                $(".prices-options-row-buy-price").removeClass("errorbox");
            }
        }else{
            $(".prices-options-row-buy-price").addClass("errorbox");
        }
    });

//    / -------------  Automatic Margin[%] calculation in EXTRAS ------------- /
    $('body').on('keyup', '.prices-extras-row-buy-price', function() {
        if(parseInt($(".prices-extras-row-buy-price").val()) > 0){
            if($(this).val()!="" && $(this).val()!="%"){

                var revenue_margin = 1-(parseInt($(".prices-extras-row-price-margin").val())/100);
                var revenue_sell_price = parseInt($(".prices-extras-row-buy-price").val()) / revenue_margin ;
                $(".prices-extras-row-sell-price").val(revenue_sell_price);
                
                
                $(".prices-extras-row-sell-price").removeClass("errorbox");
                $(".prices-extras-row-buy-price").removeClass("errorbox");
            }
        }else{
            $(".prices-extras-row-buy-price").addClass("errorbox");
        }
    });
    $('body').on('keyup', '.prices-extras-row-sell-price', function() {
        if(parseInt($(".prices-extras-row-sell-price").val()) >= parseInt($(".prices-extras-row-buy-price").val())){
            var revenue_margin = (1-($(".prices-extras-row-buy-price").val()/$(this).val()))*100;
            $(".prices-extras-row-price-margin").val(revenue_margin);
            $(".prices-extras-row-sell-price").removeClass("errorbox");
            $(".prices-extras-row-buy-price").removeClass("errorbox");
        }else{
            $(".prices-extras-row-sell-price").addClass("errorbox");
            $(".prices-extras-row-price-margin").val("");
        }
    });
    $('body').on('change', '.prices-extras-row-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#prices_extras_row_price_edited_'+num
        $(s_price_edited).val(1);
    });
    $('body').on('change', '.prices-extras-row-sell-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#prices_extras_row_price_edited_'+num
        $(s_price_edited).val(1);
    });

//    / -------------  Automatic SELL calculation in EXTRAS ------------- /
    $('body').on('keyup', '.prices-extras-row-price-margin', function() {
        if(parseInt($(".prices-extras-row-buy-price").val()) > 0){
            if($(this).val()!="" && $(this).val()!="%"){
                var revenue_margin = 1-(parseInt($(this).val())/100);
                var revenue_sell_price = parseInt($(".prices-extras-row-buy-price").val()) / revenue_margin ;
                $(".prices-extras-row-sell-price").val(revenue_sell_price);
                $(".prices-extras-row-sell-price").removeClass("errorbox");
                $(".prices-extras-row-buy-price").removeClass("errorbox");
            }
        }else{
            $(".prices-extras-row-buy-price").addClass("errorbox");
        }
    });
    
        //    / -------------  Automatic SELL calculation in OPTIONS PRICEBANDS - ------------- /
    $('body').on('keyup', '.prices-options-row-price-bands-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var buy_price = $(this).val();
        var price_margin = $('#pricebands_row_price_margin').val();
        
        
        if(parseInt(buy_price) > 0){            
            var revenue_margin = 1-(parseInt(price_margin)/100);
            var revenue_sell_price = parseFloatPrice(parseInt(buy_price) / revenue_margin) ;
            var s_prices_options_row_price_bands_sell_price = '#prices_options_row_price_bands_sell_price_'+num
            $(s_prices_options_row_price_bands_sell_price).val(revenue_sell_price);
        } else {
            $(".prices-options-row-price-bands-sell-price").addClass("errorbox");
        }
        
    });
    $('body').on('keyup', '.prices-extras-row-price-bands-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var buy_price = $(this).val();
        var price_margin = $('#pricebands_row_price_margin').val();
        
        
        if(parseInt(buy_price) > 0){            
            var revenue_margin = 1-(parseInt(price_margin)/100);
            var revenue_sell_price = parseFloatPrice(parseInt(buy_price) / revenue_margin) ;
            var s_prices_extras_row_price_bands_sell_price = '#prices_extras_row_price_bands_sell_price_'+num
            $(s_prices_extras_row_price_bands_sell_price).val(revenue_sell_price);
        } else {
            $(".prices-extras-row-price-bands-sell-price").addClass("errorbox");
        }
        
    });
    
    $('body').on('change', '.prices-options-row-price-bands-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
    $('body').on('change', '.prices-options-row-price-bands-sell-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
    
    $('body').on('change', '.prices-extras-row-price-bands-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
    $('body').on('change', '.prices-extras-row-price-bands-sell-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
        //    / -------------  Automatic SELL calculation in OPTIONS WeekPrice - ------------- /
    $('body').on('keyup', '.prices-options-row-week-prices-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var buy_price = $(this).val();
        var price_margin = $('#weekprices_row_price_margin').val();
        
        
        if(parseInt(buy_price) > 0){            
            var revenue_margin = 1-(parseInt(price_margin)/100);
            var revenue_sell_price = parseFloatPrice(parseInt(buy_price) / revenue_margin) ;
            var s_prices_options_row_week_prices_sell_price = '#prices_options_row_week_prices_sell_price_'+num
            $(s_prices_options_row_week_prices_sell_price).val(revenue_sell_price);
        } else {
            $(".prices-options-row-week-prices-sell-price").addClass("errorbox");
        }
        
    });
    $('body').on('keyup', '.prices-extras-row-week-prices-buy-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var buy_price = $(this).val();
        var price_margin = $('#weekprices_row_price_margin').val();
        
        
        if(parseInt(buy_price) > 0){            
            var revenue_margin = 1-(parseInt(price_margin)/100);
            var revenue_sell_price = parseFloatPrice(parseInt(buy_price) / revenue_margin) ;
            var s_prices_extras_row_week_prices_sell_price = '#prices_extras_row_week_prices_sell_price_'+num
            $(s_prices_extras_row_week_prices_sell_price).val(revenue_sell_price);
        } else {
            $(".prices-extras-row-week-prices-sell-price").addClass("errorbox");
        }
        
    });
    
    
    $('body').on('change', '.prices-options-row-week-prices-buy-price', function() {        
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
    $('body').on('change', '.prices-options-row-week-prices-sell-price', function() {        
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
    
    $('body').on('change', '.prices-extras-row-week-prices-buy-price', function() {       
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
    $('body').on('change', '.prices-extras-row-week-prices-sell-price', function() {
        var num = parseInt( $(this).prop("id").match(/\d+/g) );
        var s_price_edited = '#price_edited_'+num
        $(s_price_edited).val(1);
    });
       
    /////////////////////////       Click SubmitButton - Start //////////////////////////
    $( '#updateContract' ).on( 'submit', function( event ) {
        
        
        
        
        
        $this = $(this);
        var service_id = $('#service_id').val();       
        var validationCheck;
        
        validationCheck = checkForValidation();
        
        if(validationCheck == true) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                url: Router.route('saveContract'),
                dataType: 'json',
                type: 'POST', 
                async: false,
                data: $( this ).serialize()+'&service_id='+service_id,
                success: function(data) {
                    alert(data.message);                      
                    var url = Router.route('viewService') + '?service_tsid='+data.service_tsid;

                    if(service_id == '') {
                        $(location).attr('href', url);
                    }   else {
                        func_onload_with_allseason_periods();
                        //location.reload();
                    } 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

        return false;
    });   
    
    
    $('body').on('click', '.options-page-nav-change', function() {
        $("#options_navigation_id").empty();
        $("#options_navigation_id").append($(this).html());
        var pageno = $(this).html();
        
        $("#option_page_no").val(pageno);        
        func_onload_with_allseason_periods();
    });
    $('body').on('click', '.extras-page-nav-change', function() {
        $("#extras_navigation_id").empty();
        $("#extras_navigation_id").append($(this).html());
        
        var pageno = $(this).html();
        
        $("#extra_page_no").val(pageno);        
        func_onload_with_allseason_periods();
        
    });
    
    $('body').on('click', '.options-page-navigation-right', function() {
        naxtval=parseInt($("#options_navigation_id").html())+1;
        if($('.options-page-nav-change').length >= naxtval){
            $("#options_navigation_id").empty();
            $("#options_navigation_id").append(naxtval);
            
            var pageno = naxtval;
        
            $("#option_page_no").val(pageno);        
            func_onload_with_allseason_periods();
        
        } 
    });
    $('body').on('click', '.options-page-navigation-left', function() {
        prevval=parseInt($("#options_navigation_id").html())-1;
        if(1 <= prevval){
            $("#options_navigation_id").empty();
            $("#options_navigation_id").append(prevval);
            
            var pageno = prevval;
        
            $("#option_page_no").val(pageno);        
            func_onload_with_allseason_periods();
        }
    });
    $('body').on('click', '.extras-page-navigation-right', function() {
        naxtval=parseInt($("#extras_navigation_id").html())+1;
        if($('.extras-page-nav-change').length >= naxtval){
            $("#extras_navigation_id").empty();
            $("#extras_navigation_id").append(naxtval);
            
            var pageno = naxtval;
        
            $("#extra_page_no").val(pageno);        
            func_onload_with_allseason_periods();
        }
    });
    $('body').on('click', '.extras-page-navigation-left', function() {
        prevval=parseInt($("#extras_navigation_id").html())-1;
        if(1 <= prevval){
            $("#extras_navigation_id").empty();
            $("#extras_navigation_id").append(prevval);
            
            var pageno = prevval;
        
            $("#extra_page_no").val(pageno);        
            func_onload_with_allseason_periods();
        }
    });
    
    
    $('body').on('click', '.view-price', function() {
        
        pricetxt=$(this).attr("data-model-type");
        // ------------  Getting ID of ROW -------------
        var tr_row_id = $(this).closest('tr').attr('id');
        
         
        var str_name = tr_row_id.slice(0, tr_row_id.lastIndexOf("_"))+"_";
//        if(str_name == 'prices_options_row_') {
//            var num = parseInt( $('.optcheckbox:checked').prop("id").match(/\d+/g) );
//        } else {
//            var num = parseInt( $('.extcheckbox:checked').prop("id").match(/\d+/g) );
//        }
        
        var num = parseInt( $(this).closest('tr').prop("id").match(/\d+/g) );
        
        //var str_name = tr_row_id.slice(0, tr_row_id.lastIndexOf("_"))+"_";
        var str_class=str_name.replace(/_/g,"-");
        var str_id = str_name.num;
        var isPriceBandOrWeekPrices = '';
       
        
        //var s_pricebands_or_weekprices = '#prices_options_row_pricebands_or_weekprices_'+num;
        if(str_name == 'prices_options_row_') {
            //alert('ifff ');
            var s_option_id = '#prices_options_row_option_id_'+num;
            var s_season_period_id = '#prices_options_row_season_period_id_'+num;
            var s_pricebands_or_weekprices = '#prices_options_row_pricebands_or_weekprices_'+num;
            var dataFor = 'ServiceOption';
            var option_id = $(s_option_id).val();
            var season_period_id = $(s_season_period_id).val();
            isPriceBandOrWeekPrices = $(s_pricebands_or_weekprices).val();
        } else {
            
            var s_extra_id = '#prices_extras_row_extra_id_'+num;
            var s_season_period_id = '#prices_extras_row_season_period_id_'+num;
            var s_pricebands_or_weekprices = '#prices_extras_row_pricebands_or_weekprices_'+num;
            var dataFor = 'ServiceExtra';
            var extra_id = $(s_extra_id).val();
            var season_period_id = $(s_season_period_id).val();
            isPriceBandOrWeekPrices = $(s_pricebands_or_weekprices).val();
            s_option_id = s_extra_id;
            option_id = extra_id;
        }

        
        var service_id = $('#service_id').val();

        //var data =  getPriceBandAndWeekPriceData(service_id,option_id,season_period_id,isPriceBandOrWeekPrices,dataFor);
        
        var refdata ;
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
             url: Router.route('getPriceBandAndWeekPriceData'),
             dataType: 'json',
             type: 'POST',
             async: false,
             data: {service_id : service_id, option_id: option_id, seasonPeriodId:season_period_id, isPriceBandOrWeekPrices:isPriceBandOrWeekPrices, dataFor:dataFor},
             success: function(data) { 
                  refdata = data;
                 
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });    
         
         
         //console.log(refdata);
         
         var hidden_inputs = '';
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-service-id' name = '"+str_name+"[model_service_id]' id = '"+str_id+"_model_service_id_"+num+"' value='"+service_id+"'>";
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-option-id' name = '"+str_name+"[model_option_id]' id = '"+str_id+"_model_option_id_"+num+"' value='"+option_id+"'>";
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-isPriceBandOrWeekPrices' name = '"+str_name+"[model_isPriceBandOrWeekPrices]' id = '"+str_id+"_model_isPriceBandOrWeekPrices_"+num+"' value='"+isPriceBandOrWeekPrices+"'>";          
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-dataFor' name = '"+str_name+"[model_dataFor]' id = '"+str_id+"_model_dataFor_"+num+"' value='"+dataFor+"'>";
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-seasonPeriodId' name = '"+str_name+"[seasonPeriodId]' id = '"+str_id+"_model_seasonPeriodId_"+num+"' value='"+season_period_id+"'>";
          
         
        var model_heading="";
        var type_div="";
        var head_row="";
        var add_rows="";
        var add_row_button="";
        var save_buttons="";
        if((pricetxt.replace(" ", "")).toLowerCase()=="weekprices"){
            $("#weekModal").remove();
            $(".modal-backdrop").remove();
            $('body').removeAttr("style");
            $('body').removeClass("modal-open");
            
            
            add_rows1 = '';
            week_prices_charging_policy_name = '';
            var counter = parseInt(num);         
           for (row in refdata) { 
               if(row == 'charging_policies') {
                   continue;
               }
               week_prices_monday = (refdata[row].week_prices_monday == 1) ? ' Checked ': '';
               week_prices_tuesday = (refdata[row].week_prices_tuesday == 1) ? ' Checked ': '';
               week_prices_wednesday = (refdata[row].week_prices_wednesday == 1) ? ' Checked ': '';
               week_prices_thursday = (refdata[row].week_prices_thursday == 1) ? ' Checked ': '';
               week_prices_friday = (refdata[row].week_prices_friday == 1) ? ' Checked ': '';
               week_prices_saturday = (refdata[row].week_prices_saturday == 1) ? ' Checked ': '';
               week_prices_sunday = (refdata[row].week_prices_sunday == 1) ? ' Checked ': '';
               
               week_prices_buy_price = refdata[row].buy_price;
               week_prices_sell_price = refdata[row].sell_price;              
               week_prices_charging_policy_id = refdata[row].policy_id;              
               week_prices_charging_policy_name = refdata[row].policy_name;   
               week_prices_id = refdata[row].week_prices_id;
               week_prices_price_id = refdata[row].price_id;
               
               counter = parseInt(counter) + parseInt(row);
               
              add_rows1=add_rows1 + "<div class='row poprecord'><div class='col-md-1 poptdrow'><label>"+hidden_inputs+"<input type='hidden' class='weekcheckbox "+str_class+"week-prices-price-id' id='"+str_id+"_week_prices_price_id_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_price_id]' value="+week_prices_price_id+"><input type='hidden' class='weekcheckbox "+str_class+"week-prices-id' id='"+str_id+"_week_prices_id_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_id]' value="+week_prices_id+"><input type='checkbox' disabled='' "+week_prices_monday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' disabled='' "+week_prices_tuesday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' disabled='' "+week_prices_wednesday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' disabled='' "+week_prices_thursday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' disabled='' "+week_prices_friday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' disabled='' "+week_prices_saturday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' disabled='' "+week_prices_sunday+"></label></div><div class='col-md-2 poptdrow'>"+week_prices_buy_price+"</div><div class='col-md-2 poptdrow'>"+week_prices_sell_price+"</div><div class='col-md-1 poptdrow closeicon' id='"+str_id+"_week_prices_closeicon_"+counter+"'><input type='hidden' class = 'delete_data_for_class' name = 'delete_data_for' id = 'delete_data_for_id_"+num+"' value='weekprices'>&nbsp;</div></div>";
          }
          
          model_heading="<button data-dismiss='modal' class='close' type='button'><i class='fa fa-times-circle-o'><img src='img/close.png' alt='X' title='close'></i></button><h4 class='modal-title'>Week Pricing</h4>";
            type_div="<div class='row'><div class='col-md-8 poppicklbl'>Type &nbsp;</div><div class='col-md-4'><i class='dropdown-icon2 popselicon'></i><select class='form-control popstatussel'><option>"+week_prices_charging_policy_name+"</option></select></div></div>"
            head_row="<div class='row poprecord'><div class='col-md-1 popthrow'>M</div><div class='col-md-1 popthrow'>T</div><div class='col-md-1 popthrow'>W</div><div class='col-md-1 popthrow'>T</div><div class='col-md-1 popthrow'>F</div><div class='col-md-1 popthrow'>S</div><div class='col-md-1 popthrow'>S</div><div class='col-md-2 popthrow'>Buy</div><div class='col-md-2 popthrow'>Sell</div><div class='col-md-1 popthrow'>&nbsp;</div></div>";
          add_rows=head_row+add_rows1;
          
            
            
            var generate_price_model="<div role='dialog' class='modal fade' id='weekModal'><div class='modal-dialog'><div class='modal-content'><div class='modal-header'>"+model_heading+"</div><div class='modal-body'>"+type_div+"<div class='poptab'><div class='addweekrow'>"+add_rows+"</div>"+add_row_button+"</div>"+save_buttons+"</div></div></div></div>";
            $('body').append(generate_price_model);
            $('#weekModal').modal('show');
        }
        else if((pricetxt.replace(" ", "")).toLowerCase()=="pricebands"){
            $("#priceModal").remove();
            $(".modal-backdrop").remove();
            $('body').removeAttr("style");
            $('body').removeClass("modal-open");
            
            add_rows1 = '';
            price_bands_charging_policy_name = '';
           for (row in refdata) { 
               
               if(row == 'charging_policies') {
                   continue;
               }
               
               price_bands_min = refdata[row].price_bands_min;
               price_bands_max = refdata[row].price_bands_max;
               price_bands_buy_price = refdata[row].buy_price;
               price_bands_sell_price = refdata[row].sell_price;
               price_bands_charging_policy_id = refdata[row].policy_id;   
               price_bands_charging_policy_name = refdata[row].policy_name;   
               
               policy_price_bands_id = refdata[row].policy_price_bands_id;   
               price_bands_price_id = refdata[row].price_id;   
               price_bands_id = refdata[row].price_bands_id;
               
               
              add_rows1=add_rows1 + "<div class='row poprecord'>"+hidden_inputs+"<input type='hidden' class='form-control poptdtext "+str_class+"price-bands-price-id' id='"+str_id+"_price_bands_price_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_price_id]' value="+price_bands_price_id+"><input type='hidden' class='form-control poptdtext "+str_class+"price-bands-id' id='"+str_id+"_price_bands_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_id]' value="+price_bands_id+"><input type='hidden' class='form-control poptdtext "+str_class+"policy-price-bands-id' id='"+str_id+"_policy_price_bands_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][policy_price_bands_id]' value="+policy_price_bands_id+"><div class='col-md-3 poptdrow'>"+price_bands_min+"</div><div class='col-md-3 poptdrow'>"+price_bands_max+"</div>   <div class='col-md-3 poptdrow'>"+price_bands_buy_price+"</div><div class='col-md-2 poptdrow'>"+price_bands_sell_price+"</div><div class='col-md-1 poptdrow closeicon'><input type='hidden' class = 'delete_data_for_class' name = 'delete_data_for' id = 'delete_data_for_"+num+"' value='pricebands'>&nbsp;</div></div>";
           }
           
            model_heading="<button data-dismiss='modal' class='close' type='button'><i class='fa fa-times-circle-o'><img src='img/close.png' alt='X' title='close'></i></button><h4 class='modal-title'>Price Band</h4>";
            type_div="<div class='row'><div class='col-md-8 poppicklbl'>Type &nbsp;</div><div class='col-md-4'><i class='dropdown-icon2 popselicon'></i><select class='form-control popstatussel'><option>"+price_bands_charging_policy_name+"</option></select></div></div>"
            head_row="<div class='row poprecord'><div class='col-md-3 popthrow'>Min</div><div class='col-md-3 popthrow'>Max</div><div class='col-md-3 popthrow'>Buy</div><div class='col-md-2 popthrow'>Sell</div><div class='col-md-1 popthrow'>&nbsp;</div></div>";
            
            add_rows=head_row+add_rows1;
            //add_rows=head_row+"<div class='row poprecord'><div class='col-md-3 poptdrow'>2</div><div class='col-md-3 poptdrow'>7</div>   <div class='col-md-3 poptdrow'>1542</div><div class='col-md-2 poptdrow'>1742</div><div class='col-md-1 poptdrow closeicon'>&nbsp;</div></div><div class='row poprecord'><div class='col-md-3 poptdrow'>1</div><div class='col-md-3 poptdrow'>5</div><div class='col-md-3 poptdrow'>1950</div><div class='col-md-2 poptdrow'>2200</div><div class='col-md-1 poptdrow closeicon'>&nbsp;</div></div>";

            var generate_price_model="<div role='dialog' class='modal fade' id='priceModal'><div class='modal-dialog'><div class='modal-content'><div class='modal-header'>"+model_heading+"</div><div class='modal-body'>"+type_div+"<div class='poptab'><div class='addpricerow'>"+add_rows+"</div>"+add_row_button+"</div>"+save_buttons+"</div></div></div></div>";
            $('body').append(generate_price_model);
            $('#priceModal').modal('show');
        }
    });
    $('body').on('click', '.edit-price', function() {
        pricetxt=$(this).attr("data-model-type");
        // ------------  Getting ID of ROW -------------
        var tr_row_id = $(this).closest('tr').attr('id');        
        
        var str_name = tr_row_id.slice(0, tr_row_id.lastIndexOf("_"))+"_";
        if(str_name == 'prices_options_row_') {
            var num = parseInt( $('.optcheckbox:checked').prop("id").match(/\d+/g) );
        } else {
            var num = parseInt( $('.extcheckbox:checked').prop("id").match(/\d+/g) );
        }
        
        var str_class=str_name.replace(/_/g,"-");
        var str_id = str_name.num;
        var isPriceBandOrWeekPrices = '';
        var pricesMargin = '';
        
        //var s_pricebands_or_weekprices = '#prices_options_row_pricebands_or_weekprices_'+num;
        if(str_name == 'prices_options_row_') {
            var s_option_id = '#prices_options_row_option_id_'+num;
            var s_season_period_id = '#prices_options_row_season_period_id_'+num;
            var s_pricebands_or_weekprices = '#prices_options_row_pricebands_or_weekprices_'+num;
            var dataFor = 'ServiceOption';
            var option_id = $(s_option_id).val();
            var season_period_id = $(s_season_period_id).val();
            isPriceBandOrWeekPrices = $(s_pricebands_or_weekprices).val();
            var s_prices_options_row_price_margin = '#prices_options_row_price_margin_'+num;
            pricesMargin = $(s_prices_options_row_price_margin).val();
        } else {
            var s_extra_id = '#prices_extras_row_extra_id_'+num;
            var s_season_period_id = '#prices_extras_row_season_period_id_'+num;
            var s_pricebands_or_weekprices = '#prices_extras_row_pricebands_or_weekprices_'+num;
            var dataFor = 'ServiceExtra';
            var extra_id = $(s_extra_id).val();
            var season_period_id = $(s_season_period_id).val();
            isPriceBandOrWeekPrices = $(s_pricebands_or_weekprices).val();
            s_option_id = s_extra_id;
            option_id = extra_id;
            var s_prices_extras_row_price_margin = '#prices_extras_row_price_margin_'+num;
            pricesMargin = $(s_prices_extras_row_price_margin).val();
        }

        
        var service_id = $('#service_id').val();

        //var data =  getPriceBandAndWeekPriceData(service_id,option_id,season_period_id,isPriceBandOrWeekPrices,dataFor);
        
        var refdata ;
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
             url: Router.route('getPriceBandAndWeekPriceData'),
             dataType: 'json',
             type: 'POST',
             async: false,
             data: {service_id : service_id, option_id: option_id,seasonPeriodId:season_period_id, isPriceBandOrWeekPrices:isPriceBandOrWeekPrices, dataFor:dataFor},
             success: function(data) { 
                  refdata = data;
                 
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });    
       
        //var num = 9;
        if(str_name == 'prices_options_row_') {
            var str_name = 'prices_options_row['+num+']';
            var str_id = 'prices_options_row';
            var str_class = 'prices-options-row-'; 
            var weekprices_data_for = 'ServiceOption';
            var pricebands_data_for = 'ServiceOption';
        } else {
            var str_name = 'prices_extras_row['+num+']';
            var str_id = 'prices_extras_row';
            var str_class = 'prices-extras-row-';
            var weekprices_data_for = 'ServiceExtra';
            var pricebands_data_for = 'ServiceExtra';
        }
        
        
        var model_heading="";
        var type_div="";
        var head_row="";
        var add_rows="";
        var add_row_button="";
        var save_buttons="";
        
                    
                      //service_id : service_id, option_id: option_id,seasonPeriodId:season_period_id, isPriceBandOrWeekPrices:isPriceBandOrWeekPrices, dataFor:dataFor
          var hidden_inputs = '';
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-service-id' name = '"+str_name+"[model_service_id]' id = '"+str_id+"_model_service_id_"+num+"' value='"+service_id+"'>";
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-option-id' name = '"+str_name+"[model_option_id]' id = '"+str_id+"_model_option_id_"+num+"' value='"+option_id+"'>";
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-isPriceBandOrWeekPrices' name = '"+str_name+"[model_isPriceBandOrWeekPrices]' id = '"+str_id+"_model_isPriceBandOrWeekPrices_"+num+"' value='"+isPriceBandOrWeekPrices+"'>";          
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-dataFor' name = '"+str_name+"[model_dataFor]' id = '"+str_id+"_model_dataFor_"+num+"' value='"+dataFor+"'>";
          hidden_inputs += "<input type='hidden' class = '"+str_class+"model-seasonPeriodId' name = '"+str_name+"[seasonPeriodId]' id = '"+str_id+"_model_seasonPeriodId_"+num+"' value='"+season_period_id+"'>";
          
  
  
        if((pricetxt.replace(" ", "")).toLowerCase()=="weekprices"){
            $("#weekModal").remove();
            $(".modal-backdrop").remove();
            $('body').removeAttr("style");
            $('body').removeClass("modal-open");
            
            
            add_rows1 = '';
            var counter = parseInt(num);
            
            week_prices_charging_policy_id = '';
        
           for (row in refdata) { 
               if(row == 'charging_policies') {
                   continue;
               }
               week_prices_monday = (refdata[row].week_prices_monday == 1) ? ' Checked ': '';
               week_prices_tuesday = (refdata[row].week_prices_tuesday == 1) ? ' Checked ': '';
               week_prices_wednesday = (refdata[row].week_prices_wednesday == 1) ? ' Checked ': '';
               week_prices_thursday = (refdata[row].week_prices_thursday == 1) ? ' Checked ': '';
               week_prices_friday = (refdata[row].week_prices_friday == 1) ? ' Checked ': '';
               week_prices_saturday = (refdata[row].week_prices_saturday == 1) ? ' Checked ': '';
               week_prices_sunday = (refdata[row].week_prices_sunday == 1) ? ' Checked ': '';
               
               week_prices_buy_price = refdata[row].buy_price;
               week_prices_sell_price = refdata[row].sell_price;  
               
               price_edited_value = 0;
               if(refdata[row].price_margin != pricesMargin) {
                   price_edited_value = 1;
               }
               
               var revenue_margin = 1-(parseInt(pricesMargin)/100);
               week_prices_sell_price = parseFloatPrice(parseInt(week_prices_buy_price) / revenue_margin) ;
               
               week_prices_charging_policy_id = refdata[row].policy_id;              
               week_prices_charging_policy_name = refdata[row].policy_name;    
               week_prices_id = refdata[row].week_prices_id;
               week_prices_price_id = refdata[row].price_id;
               
               counter = parseInt(counter) + parseInt(row);
               
              add_rows1=add_rows1 + "<div class='row poprecord'><div class='col-md-1 poptdrow'><label>"+hidden_inputs+"<input type='hidden' class='weekcheckbox "+str_class+"week-prices-price-id' id='"+str_id+"_week_prices_price_id_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_price_id]' value="+week_prices_price_id+"><input type='hidden' class='weekcheckbox "+str_class+"week-prices-id' id='"+str_id+"_week_prices_id_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_id]' value="+week_prices_id+"><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-monday' id='"+str_id+"_week_prices_monday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_monday]' "+week_prices_monday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-tuesday' id='"+str_id+"_week_prices_tuesday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_tuesday]' "+week_prices_tuesday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-wednesday' id='"+str_id+"_week_prices_wednesday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_wednesday]' "+week_prices_wednesday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-thursday' id='"+str_id+"_week_prices_thursday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_thursday]' "+week_prices_thursday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-friday' id='"+str_id+"_week_prices_friday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_friday]' "+week_prices_friday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-saturday' id='"+str_id+"_week_prices_saturday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_saturday]' "+week_prices_saturday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-sunday' id='"+str_id+"_week_prices_sunday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_sunday]' "+week_prices_sunday+"></label></div><div class='col-md-2 poptdrow'><input type='text' class='form-control poptdtext "+str_class+"week-prices-buy-price' id='"+str_id+"_week_prices_buy_price_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_buy_price]' placeholder='Price' value='"+week_prices_buy_price+"'></div><div class='col-md-2 poptdrow'><input type='text' class='form-control poptdtext "+str_class+"week-prices-sell-price' id='"+str_id+"_week_prices_sell_price_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_sell_price]' placeholder='Price' value='"+week_prices_sell_price+"' readonly></div><div class='col-md-1 poptdrow closeicon' id='"+str_id+"_week_prices_closeicon_"+counter+"'><input type='hidden' class = 'delete_data_for_class' name = 'delete_data_for' id = 'delete_data_for_id_"+num+"' value='weekprices'><input type='hidden' class = 'price_edited' name='"+str_name+"[weekprices]["+parseInt(row)+"][price_edited]' id = 'price_edited_"+counter+"' value='"+price_edited_value+"'>&nbsp;</div></div>";
          }
          
          var charging_policies =  refdata.charging_policies;
          
         
          
          var str_charging_policy = "<input type='hidden' name = 'weekprices_row_price_margin' id = 'weekprices_row_price_margin' value='"+pricesMargin+"'><input type='hidden' name = 'weekprices_row_number' id = 'weekprices_row_number_id' value='"+num+"'><input type='hidden' name = 'weekprices_data_for' id = 'weekprices_data_for_id' value='"+weekprices_data_for+"'><select id='"+str_id+"_week_prices_charging_policy_id_"+num+"' class='form-control popstatussel "+str_class+"week-prices-charging-policy-id' name='"+str_name+"[weekprices][week_prices_charging_policy_id]'>";
          var str_option = '';
          for (row1 in charging_policies) {
              var str_selected = '';
              if(charging_policies[row1].id == week_prices_charging_policy_id ) {
                  str_selected = ' selected';
              }
              str_option = str_option + "<option value = '"+charging_policies[row1].id+"' "+str_selected+">"+charging_policies[row1].name+"</option>";              
          }          
          str_charging_policy = str_charging_policy +str_option+"</select>";
          
            model_heading="<button data-dismiss='modal' class='close' type='button'><i class='fa fa-times-circle-o'><img src='img/close.png' alt='X' title='close'></i></button><h4 class='modal-title'>Week Pricing</h4>";
            type_div="<div class='row'><div class='col-md-8 poppicklbl'>Type &nbsp;</div><div class='col-md-4'><i class='dropdown-icon2 popselicon'></i>"+str_charging_policy+"</div></div>"
            head_row="<div class='row poprecord'><div class='col-md-1 popthrow'>M</div><div class='col-md-1 popthrow'>T</div><div class='col-md-1 popthrow'>W</div><div class='col-md-1 popthrow'>T</div><div class='col-md-1 popthrow'>F</div><div class='col-md-1 popthrow'>S</div><div class='col-md-1 popthrow'>S</div><div class='col-md-2 popthrow'>Buy</div><div class='col-md-2 popthrow'>Sell</div><div class='col-md-1 popthrow'>&nbsp;</div></div>";
            add_rows=head_row+add_rows1;
            add_row_button="<div class='row model-add-row'><div class='adbtn'><a onclick='' id='addweekprice'><img src='img/add-row.png'><span>Add</span></a><span class='weekerror'>Please select atleast one day..!!</span></div></div>";
            save_buttons="<div class='row model-buttons'><input type='submit' class='savebut weeksave  btn-submit' value = 'SAVE'><div class='resetbut weekreset'>RESET</div></div>";
            var generate_price_model="<div role='dialog' class='modal fade' id='weekModal'><div class='modal-dialog'><div class='modal-content'><div class='modal-header'>"+model_heading+"</div><div class='modal-body'>"+type_div+"<div class='poptab'><div class='addweekrow'>"+add_rows+"</div>"+add_row_button+"</div>"+save_buttons+"</div></div></div></div>";
            //$('body').append(generate_price_model);
            $('#model_id').append(generate_price_model);
            $('#weekModal').modal('show');
        }
        else if((pricetxt.replace(" ", "")).toLowerCase()=="pricebands"){
            $("#priceModal").remove();
            $(".modal-backdrop").remove();
            $('body').removeAttr("style");
            $('body').removeClass("modal-open");
            
           add_rows1 = '';
           var counter = parseInt(num);
           price_bands_charging_policy_id = '';
           for (row in refdata) { 
               
               if(row == 'charging_policies') {
                   continue;
               }
               
               price_bands_min = refdata[row].price_bands_min;
               price_bands_max = refdata[row].price_bands_max;
               price_bands_buy_price = refdata[row].buy_price;
               price_bands_sell_price = refdata[row].sell_price;
               
               price_edited_value = 0;
               if(refdata[row].price_margin != pricesMargin) {
                   price_edited_value = 1;
               }
               
               var revenue_margin = 1-(parseInt(pricesMargin)/100);
               price_bands_sell_price = parseFloatPrice(parseInt(price_bands_buy_price) / revenue_margin) ;
               
               price_bands_charging_policy_id = refdata[row].policy_id;   
               price_bands_charging_policy_name = refdata[row].policy_name;   
               policy_price_bands_id = refdata[row].policy_price_bands_id;   
               price_bands_price_id = refdata[row].price_id;   
               price_bands_id = refdata[row].price_bands_id;   
               
               counter = parseInt(counter) + parseInt(row);
               
              add_rows1=add_rows1 + "<div class='row poprecord'><div class='col-md-3 poptdrow'>"+hidden_inputs+"<input type='hidden' class='form-control poptdtext "+str_class+"price-bands-price-id' id='"+str_id+"_price_bands_price_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_price_id]' value="+price_bands_price_id+"><input type='hidden' class='form-control poptdtext "+str_class+"price-bands-id' id='"+str_id+"_price_bands_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_id]' value="+price_bands_id+"><input type='hidden' class='form-control poptdtext "+str_class+"policy-price-bands-id' id='"+str_id+"_policy_price_bands_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][policy_price_bands_id]' value="+policy_price_bands_id+"><input type='text' id='"+str_id+"_price_bands_min_"+num+"' class='form-control poptdtext "+str_class+"price-bands-min'  name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_min]' placeholder='Min' value='"+price_bands_min+"'></div><div class='col-md-3 poptdrow'><input type='text' id='"+str_id+"_price_bands_max_"+num+"' class='form-control poptdtext "+str_class+"price-bands-max'  name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_max]' placeholder='Max' value='"+price_bands_max+"'></div><div class='col-md-3 poptdrow'><input type='text' id='"+str_id+"_price_bands_buy_price_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_buy_price]' class='form-control poptdtext "+str_class+"price-bands-buy-price' placeholder='Price' value='"+price_bands_buy_price+"'></div><div class='col-md-2 poptdrow'><input type='text' id='"+str_id+"_price_bands_sell_price_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_sell_price]' class='form-control poptdtext "+str_class+"price-bands-sell-price' placeholder='Price' value='"+price_bands_sell_price+"'readonly ></div><div class='col-md-1 poptdrow closeicon' id='"+str_id+"_price_bands_closeicon_"+num+"'><input type='hidden' class = 'delete_data_for_class' name = 'delete_data_for' id = 'delete_data_for_"+num+"' value='pricebands'><input type='hidden' class = 'price_edited' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_edited]' id = 'price_edited_"+counter+"' value='0'>&nbsp;</div></div>";
           }
           
           var charging_policies =  refdata.charging_policies;
          
          var str_charging_policy = "<input type='hidden' name = 'pricebands_row_price_margin' id = 'pricebands_row_price_margin' value='"+pricesMargin+"'><input type='hidden' name = 'pricebands_row_number' id = 'pricebands_row_number_id' value='"+num+"'><input type='hidden' name = 'pricebands_data_for' id = 'pricebands_data_for_id' value='"+pricebands_data_for+"'><select id='"+str_id+"_price_bands_charging_policy_id_"+num+"' class='form-control popstatussel "+str_class+"price-bands-charging-policy-id' name='"+str_name+"[pricebands][price_bands_charging_policy_id]'>";
          var str_option = '';
          for (row1 in charging_policies) {
              var str_selected = '';
              if(charging_policies[row1].id == price_bands_charging_policy_id ) {
                  str_selected = ' selected';
              }
              str_option = str_option + "<option value = '"+charging_policies[row1].id+"' "+str_selected+">"+charging_policies[row1].name+"</option>";              
          }          
          str_charging_policy = str_charging_policy +str_option+"</select>";
          
          
           model_heading="<button data-dismiss='modal' class='close' type='button'><i class='fa fa-times-circle-o'><img src='img/close.png' alt='X' title='close'></i></button><h4 class='modal-title'>Price Band</h4>";
            type_div="<div class='row'><div class='col-md-8 poppicklbl'>Type &nbsp;</div><div class='col-md-4'><i class='dropdown-icon2 popselicon'></i>"+str_charging_policy+"</div></div>"
            
            head_row="<div class='row poprecord'><div class='col-md-3 popthrow'>Min</div><div class='col-md-3 popthrow'>Max</div><div class='col-md-3 popthrow'>Buy</div><div class='col-md-2 popthrow'>Sell</div><div class='col-md-1 popthrow'>&nbsp;</div></div>";
            
            add_rows=head_row+add_rows1;
            
            
            add_row_button="<div class='row model-add-row'><div class='adbtn'><a id='addpriceband' onclick=''><img src='img/add-row.png'><span>Add</span></a></div></div>";
            save_buttons="<div class='row model-buttons'><input type='submit' class='savebut pricesave  btn-submit' value = 'SAVE'><div class='resetbut pricereset'>RESET</div></div>";
            var generate_price_model="<div role='dialog' class='modal fade' id='priceModal'><div class='modal-dialog'><div class='modal-content'><div class='modal-header'>"+model_heading+"</div><div class='modal-body'>"+type_div+"<div class='poptab'><div class='addpricerow'>"+add_rows+"</div>"+add_row_button+"</div>"+save_buttons+"</div></div></div></div>";
            $('#model_id').append(generate_price_model);
            $('#priceModal').modal('show');
            $('#prices_options_row_price_bands_charging_policy_id_'+optrowid).trigger( "click" );
        }
    });
    
    $('#optdate').on('apply.daterangepicker', function(ev, picker) {
        $("#optDateText").empty();
        $("#optDateText").append("<div class='dyndateleft'><span class='txtredcol'>From:</span> "+picker.startDate.format('YYYY-MM-DD')+"</div><div class='dyndateright'> <span class='txtredcol'>To:</span> "+picker.endDate.format('YYYY-MM-DD')+"</div>");
        
        $("#options_date_range_from").val(picker.startDate.format('YYYY-MM-DD'));
        $("#options_date_range_to").val(picker.endDate.format('YYYY-MM-DD'));
        func_onload_with_allseason_periods();
    });
    $('#extdate').on('apply.daterangepicker', function(ev, picker) {
        $("#extDateText").empty();
        $("#extDateText").append("<div class='dyndateleft'><span class='txtredcol'>From:</span> "+picker.startDate.format('YYYY-MM-DD')+"</div><div class='dyndateright'> <span class='txtredcol'>To:</span> "+picker.endDate.format('YYYY-MM-DD')+"</div>");
        
        $("#extras_date_range_from").val(picker.startDate.format('YYYY-MM-DD'));
        $("#extras_date_range_to").val(picker.endDate.format('YYYY-MM-DD'));
        func_onload_with_allseason_periods();
    });
    
    $('body').on('click', '.link-extras-price-row', function() {
       
        var service_id = $('#service_id').val();  
        var option_page_no = $('#option_page_no').val();  
        var extra_page_no = $('#extra_page_no').val();  
        var options_date_range_from = $('#options_date_range_from').val();  
        var options_date_range_to = $('#options_date_range_to').val();  
        var extras_date_range_from = $('#extras_date_range_from').val();  
        var extras_date_range_to = $('#extras_date_range_to').val();  
        var prices_options_table_status = $('#prices_options_table_status').val();  
        var prices_extras_table_status = $('#prices_extras_table_status').val();  
        
        
        var option_id = parseInt( $('.optcheckbox:checked').closest('tr').find('input.prices-options-row-option-id').val());
        var link_extra_id = parseInt( $('.extcheckbox:checked').closest('tr').find('input.prices-extras-row-extra-id').val());
        
        var link_extra_id = '';
        $('.extcheckbox:checked').each(function()
        { 
            link_extra_id = link_extra_id+parseInt( $(this).closest('tr').find('input.prices-extras-row-extra-id').val())+',';
        });
            
//        console.log('option_id : '+option_id);
//        console.log('link_extra_id : '+link_extra_id);
//        
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
             url: Router.route('linkOptionsWithExtras'),
             dataType: 'json',
             type: 'POST',
             async: false,
             data: {service_id : service_id, option_page_no: option_page_no, extra_page_no:extra_page_no,options_date_range_from:options_date_range_from,options_date_range_to:options_date_range_to,extras_date_range_from:extras_date_range_from,extras_date_range_to:extras_date_range_to,prices_options_table_status:prices_options_table_status,prices_extras_table_status:prices_extras_table_status,option_id:option_id,link_extra_id:link_extra_id},
             success: function(data) { 
                 alert('Option and Extra are linked successfully');
                 //populate_dynamic_data('contracts',data); 
                 //pupulate_pagination_dropdown(data);
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });
         
        
    });
    
    
    
    $('body').on('click', '.optcheckbox', function() {
        if (actRow != "") {
            $("#prices_options_row_" + optrowid).empty();
            $("#prices_options_row_" + optrowid).append(actRow);
            actRow = "";
            optrowid = "";
        }
        opttotalcheck = $('.optcheckbox:checked').length;
        if (opttotalcheck == 1) {
            
            var service_id = $('#service_id').val(); 
            var price_id = $('.optcheckbox:checked').val();
            var option_id = $('.optcheckbox:checked').closest('tr').find('input.prices-options-row-option-id').val();
            var extra_id = $('.optcheckbox:checked').closest('tr').find('input.prices-options-row-mandatory-extra-id').val();

            optrowid=$('.optcheckbox:checked').val();
            var num = parseInt( $('.optcheckbox:checked').prop("id").match(/\d+/g) );
            optrowid = num;          
            var opt_start_date = $('#prices_options_row_'+optrowid).children('td:nth-child(4)').html()
            var opt_end_date = $('#prices_options_row_'+optrowid).children('td:nth-child(5)').html()
            
//            console.log(opt_start_date);
//            coconsole.log(nsole.log(opt_end_date);
            
            //

            $('#edit_options_price_row').addClass("butactive");
            $('#remove_options_price_row').addClass("delactive");
            $('#add_options_price_row').addClass("butactive");
            
           // if(parseInt(extra_id) > 0) {
            if(extra_id != '') {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
                    url: Router.route('getExtrasWithIsMandatoryForOption'),
                    dataType: 'json',
                    type: 'POST',
                    async: false,
                    data: {service_id : service_id, option_id: option_id, extra_id:extra_id, opt_start_date:opt_start_date, opt_end_date:opt_end_date, price_id:price_id},
                    success: function(data) { 
                        populate_dynamic_data('contracts',data); 
                        pupulate_pagination_dropdown(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                }); 
                
                
                
            }
            
         
            
        } else if (opttotalcheck > 1) {
            $('#edit_options_price_row').removeClass("butactive");
            $('#remove_options_price_row').addClass("delactive");
            $('#add_options_price_row').removeClass("butactive");
        }else{
            $(".optcheckall").prop('checked', false);
            $('#edit_options_price_row').removeClass("butactive");
            $('#remove_options_price_row').removeClass("delactive");
            $('#add_options_price_row').removeClass("butactive");
            $('#link_extras_price_row').removeClass("butactive");
        }
        if ($('.optcheckbox:checked').length >= 1 && $('.extcheckbox:checked').length >= 1)
            $('#link_extras_price_row').addClass("butactive");
        else
            $('#link_extras_price_row').removeClass("butactive");
        
        
         if(this.checked){
            var opt_check_id = $(this).attr('id');
            var opt_slice_id = opt_check_id.slice(opt_check_id.lastIndexOf("_")+1, opt_check_id.length);
            var mandatory_extra_id_str=$("#prices_options_row_mandatory_extra_id_"+opt_slice_id).val();
            var options_dates = $("#prices_options_row_"+opt_slice_id).children("td:nth-child(4)").html()+$("#prices_options_row_"+opt_slice_id).children("td:nth-child(5)").html();
            
            $("input[id^='prices_extras_row_extra_id_']").each(function (i, el) {
                var ext_check_id = $(this).attr('id');
                var ext_slice_id = ext_check_id.slice(ext_check_id.lastIndexOf("_")+1, ext_check_id.length);
                 var extras_dates = $("#prices_extras_row_"+ext_slice_id).children("td:nth-child(3)").html()+$("#prices_extras_row_"+ext_slice_id).children("td:nth-child(4)").html();
                 
                 var mandatory_extra_id_arr = mandatory_extra_id_str.split(',').map(Number);
                
                 var mandatory_extra_id ='';
                 
                 for(i=0; i < mandatory_extra_id_arr.length; i++) {
                    mandatory_extra_id = mandatory_extra_id_arr[i];
//                    console.log(mandatory_extra_id + '' + $(this).val());
                    if($(this).val() == mandatory_extra_id && options_dates == extras_dates){
                        $("#prices_extras_row_selection_"+ext_slice_id).prop('checked', true);
                    }
                 }                                                 
            });
        }else{
            var opt_check_id = $(this).attr('id');
            var opt_slice_id = opt_check_id.slice(opt_check_id.lastIndexOf("_")+1, opt_check_id.length);
            var mandatory_extra_id_str=$("#prices_options_row_mandatory_extra_id_"+opt_slice_id).val();
            var options_dates = $("#prices_options_row_"+opt_slice_id).children("td:nth-child(4)").html()+$("#prices_options_row_"+opt_slice_id).children("td:nth-child(5)").html();
            
            $("input[id^='prices_extras_row_extra_id_']").each(function (i, el) {
                var ext_check_id = $(this).attr('id');
                var ext_slice_id = ext_check_id.slice(ext_check_id.lastIndexOf("_")+1, ext_check_id.length);
                 var extras_dates = $("#prices_extras_row_"+ext_slice_id).children("td:nth-child(3)").html()+$("#prices_extras_row_"+ext_slice_id).children("td:nth-child(4)").html();
                 
                 var mandatory_extra_id_arr = mandatory_extra_id_str.split(',').map(Number);
                
                 var mandatory_extra_id ='';
                 
                 for(i=0; i < mandatory_extra_id_arr.length; i++) {
                    mandatory_extra_id = mandatory_extra_id_arr[i];
//                    console.log(mandatory_extra_id + '' + $(this).val());
                    if($(this).val() == mandatory_extra_id && options_dates == extras_dates){
                        $("#prices_extras_row_selection_"+ext_slice_id).prop('checked', false);
                    }
                 }                                                 
            });

        }
        
        

    });
    $('body').on('click', '.extcheckbox', function() {
        
       
        var num = parseInt( $(this).prop("id").match(/\d+/g) ); 
        var mandatory_for_option_id_exist = '#prices_extras_row_mandatory_for_option_id_'+num;
        var link_extra_id_name = '#prices_extras_row_extra_id_'+num;
        
        if($(mandatory_for_option_id_exist).length) {
            if(confirm('Do you want to unlink this extra??')) {
                var service_id = $('#service_id').val();  
                var option_page_no = $('#option_page_no').val();  
                var extra_page_no = $('#extra_page_no').val();  
                var options_date_range_from = $('#options_date_range_from').val();  
                var options_date_range_to = $('#options_date_range_to').val();  
                var extras_date_range_from = $('#extras_date_range_from').val();  
                var extras_date_range_to = $('#extras_date_range_to').val();  
                var prices_options_table_status = $('#prices_options_table_status').val();  
                var prices_extras_table_status = $('#prices_extras_table_status').val();

                var option_id = parseInt( $(mandatory_for_option_id_exist).val());
                var link_extra_id = parseInt( $(link_extra_id_name).val());
                var mandatory_extra_id_str=$("#prices_options_row_mandatory_extra_id_"+num).val();
                var link_extra_id = '';
                $('.extcheckbox:checked').each(function()
                { 
                    link_extra_id = link_extra_id+parseInt( $(this).closest('tr').find('input.prices-extras-row-extra-id').val())+',';
                });
        
                $.ajax({
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
                     url: Router.route('linkOptionsWithExtras'),
                     dataType: 'json',
                     type: 'POST',
                     async: false,
                     data: {service_id : service_id, option_page_no: option_page_no, extra_page_no:extra_page_no,options_date_range_from:options_date_range_from,options_date_range_to:options_date_range_to,extras_date_range_from:extras_date_range_from,extras_date_range_to:extras_date_range_to,prices_options_table_status:prices_options_table_status,prices_extras_table_status:prices_extras_table_status,option_id:option_id,link_extra_id:link_extra_id,link_operation:0},
                     success: function(data) { 
                         alert('Mandatory Extra for Option updated successfully');
                         //populate_dynamic_data('contracts',data); 
                         //pupulate_pagination_dropdown(data);
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                         alert(errorThrown);
                     }
                 });
         
         
            } 
        }
        
        if (actRow != "") {
            $("#prices_extras_row_" + extrowid).empty();
            $("#prices_extras_row_" + extrowid).append(actRow);
            actRow = "";
            extrowid = "";
        }
        exttotalcheck = $('.extcheckbox:checked').length;
        if (exttotalcheck == 1) {
            $('#edit_extras_price_row').addClass("butactive");
            $('#remove_extras_price_row').addClass("delactive");
            $('#add_extras_price_row').addClass("butactive");
        } else if (exttotalcheck > 1) {
            $('#edit_extras_price_row').removeClass("butactive");
            $('#remove_extras_price_row').addClass("delactive");
            $('#add_extras_price_row').removeClass("butactive");
        }else{
            $(".extcheckall").prop('checked', false);
            $('#edit_extras_price_row').removeClass("butactive");
            $('#remove_extras_price_row').removeClass("delactive");
            $('#add_extras_price_row').removeClass("butactive");
            $('#link_extras_price_row').removeClass("butactive");
        }
        if ($('.optcheckbox:checked').length >= 1 && $('.extcheckbox:checked').length >= 1)
            $('#link_extras_price_row').addClass("butactive");
        else
            $('#link_extras_price_row').removeClass("butactive");

    });
    /////////////////////////  Function Definations - Start //////////////////////////
    
    function func_onload_with_allseason_periods() { 
        
        var service_id = $('#service_id').val();  
        var option_page_no = $('#option_page_no').val();  
        var extra_page_no = $('#extra_page_no').val();  
        var options_date_range_from = $('#options_date_range_from').val();  
        var options_date_range_to = $('#options_date_range_to').val();  
        var extras_date_range_from = $('#extras_date_range_from').val();  
        var extras_date_range_to = $('#extras_date_range_to').val();  
        var prices_options_table_status = $('#prices_options_table_status').val();  
        var prices_extras_table_status = $('#prices_extras_table_status').val();  
        
        $('.page-loader').css('display','block');
        
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
             url: Router.route('getServiceSeasonPeriodsData'),
             dataType: 'json',
             type: 'GET',
             async: false,
             data: {service_id : service_id, option_page_no: option_page_no, extra_page_no:extra_page_no,options_date_range_from:options_date_range_from,options_date_range_to:options_date_range_to,extras_date_range_from:extras_date_range_from,extras_date_range_to:extras_date_range_to,prices_options_table_status:prices_options_table_status,prices_extras_table_status:prices_extras_table_status},
             success: function(data) { 
                 populate_dynamic_data('contracts',data); 
                 pupulate_pagination_dropdown(data);
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });   
         
         $('.page-loader').css('display','none')
    }
    function populate_dynamic_data(arg, data) {
        for (row in data) {             
            // Populate Option Price Data           
            if(row == 'options_all') {
               $('#prices_option_table tbody').empty();
               var counter = 0;
               
               if($.isEmptyObject(data[row]) === true) {
                   options = {
                       'contract_id':null,
                       'contract_period_id':null,
                       'season_id':null,
                       'price_id':null,
                       'option_id':null,
                       'buy_price':null,
                       'sell_price':null,
                       'week_prices_id':null,
                       'policy_price_bands_id':null,
                       'WEEKDAYPRICES_EXISTS':null,
                       'PRICEBAND_EXISTS':null,
                       'currency_code':null,
                       'service_currency_code':null,
                       'option_name':null,
                       'occupancy_name':null,
                       'price_status':null,
                       'price_margin':null,
                       'status':null,
                       'meal_plan_name':null,
                       'policy_name':null,
                       'prices_season_period_start':null,
                       'prices_season_period_end':null
                   };
                   option_price_row_template(0,options); 
               } else {
                    for (row1 in data[row]) {
                        var options = data[row][row1];  
                        option_price_row_template(counter, options); 
                        counter++;
                        if(counter >= recordsPerPage) {
                             break;
                         }                   
                    }
                }
            }
            // Populate Extra price Data            
            if(row == 'extras_all') {
                $('#prices_extra_table tbody').empty();
                var counter = 0;
                if($.isEmptyObject(data[row]) === true) {
                    options = {
                       'contract_id':null,
                       'contract_period_id':null,
                       'season_id':null,
                       'price_id':null,
                       'extra_id':null,
                       'buy_price':null,
                       'sell_price':null,
                       'week_prices_id':null,
                       'policy_price_bands_id':null,
                       'WEEKDAYPRICES_EXISTS':null,
                       'PRICEBAND_EXISTS':null,
                       'currency_code':null,
                       'service_currency_code':null,
                       'extra_name':null,
                       'occupancy_name':null,
                       'price_status':null,
                       'price_margin':null,
                       'status':null,
                       'meal_plan_name':null,
                       'policy_name':null,
                       'prices_season_period_start':null,
                       'prices_season_period_end':null
                    };
                    extra_price_row_template(0,options); 
                } else {
                   
                    for (row1 in data[row]) {  
                        var extras = data[row][row1];
                        extra_price_row_template(counter, extras);
                        counter++;
                        if(counter >= recordsPerPage) {
                            break;
                        }
                    }

                }
            }
        }
    }
    function option_price_row_template(counter, options) {
//      console.log(options);
        var hidden_elements = '';
        var status_active;
        var status_inactive;
        var status_text = null;
        
        var contract_id = options.contract_id;
        var contract_period_id = options.contract_period_id;
        var season_id = options.season_id;
        var season_period_id = options.season_period_id;        
        var buy_price = options.buy_price;        
        var sell_price = options.sell_price;
        var week_prices_id = options.week_prices_id;
        var policy_price_bands_id = options.policy_price_bands_id;
        
        if(options.price_status == 1) { // because we options status not working as it gets in duplicate record 
            status_active = 'selected';
            status_text = "Active";
        } else  if(options.price_status == 0) {
            status_inactive = 'selected';
            status_text = "In-Active";
        }
        
        buy_price = parseFloatPrice(buy_price);
        sell_price = parseFloatPrice(sell_price);
        
        if(buy_price == '') {
            buy_price = '-';
        }
        if(sell_price == '') {
            sell_price = '-';
        }
        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-price-id" id = "prices_options_row_price_id_'+counter+'" name = "prices_options_row['+counter+'][price_id]" placeholder="price_id" value = "'+options.price_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-option-id" id = "prices_options_row_option_id_'+counter+'" name = "prices_options_row['+counter+'][option_id]" placeholder="Option ID" value = "'+options.option_id+'">';
        
        //prices-options-row-mandatory-extra-id
        if(options.multiple_mandatory_extra != '') {
            hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-mandatory-extra-id" id = "prices_options_row_mandatory_extra_id_'+counter+'" name = "prices_options_row['+counter+'][mandatory_extra_id]" placeholder="Mandatory Extra ID" value = "'+options.multiple_mandatory_extra+'">';
        } else {
            hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-mandatory-extra-id" id = "prices_options_row_mandatory_extra_id_'+counter+'" name = "prices_options_row['+counter+'][mandatory_extra_id]" placeholder="Mandatory Extra ID" value = "'+options.mandatory_extra+'">';
        }
        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-contract-id" id = "prices_options_row_contract_id_'+counter+'" name = "prices_options_row['+counter+'][contract_id]" placeholder="Contract ID" value = "'+contract_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-contract-period-id" id = "prices_options_row_contract_period_id_'+counter+'" name = "prices_options_row['+counter+'][contract_period_id]" placeholder="Contract Period ID" value = "'+contract_period_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-season-id" id = "prices_options_row_season_id_'+counter+'" name = "prices_options_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'">';        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-season-period-id" id = "prices_options_row_season_period_id_'+counter+'" name = "prices_options_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'">';
        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-week-prices-id" id = "prices_options_row_week_prices_id_'+counter+'" name = "prices_options_row['+counter+'][week_prices_id]" placeholder="week_prices_id" value = "'+week_prices_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-policy-price-bands-id" id = "prices_options_row_policy_price_bands_id_'+counter+'" name = "prices_options_row['+counter+'][policy_price_bands_id]" placeholder="policy_price_bands_id" value = "'+policy_price_bands_id+'">';
        var pricebands_or_weekprices = '';   
        if(options.WEEKDAYPRICES_EXISTS == 'NO' && options.PRICEBAND_EXISTS == 'YES') {
            pricebands_or_weekprices = 'pricebands';
        } else if(options.WEEKDAYPRICES_EXISTS == 'YES' && options.PRICEBAND_EXISTS == 'NO') {
            pricebands_or_weekprices = 'weekprices';
        }
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-pricebands-or-weekprices" id = "prices_options_row_pricebands_or_weekprices_'+counter+'" name = "prices_options_row['+counter+'][pricebands_or_weekprices]" placeholder="pricebands-or-weekprices" value = "'+pricebands_or_weekprices+'">';
        
       
        var price_col = '';
        
        if(parseInt(week_prices_id)  > 0 && options.WEEKDAYPRICES_EXISTS == 'YES') {
        //if(0) {
            price_col = '<td colspan="2"><span class="view-price" data-model-type="weekprices">View Price</span></td>';
        } else if(parseInt(policy_price_bands_id) > 0  && options.PRICEBAND_EXISTS == 'YES') {
        //} else if( 0) {
            price_col = '<td colspan="2"><span class="view-price" data-model-type="pricebands">View Price</span></td>';
        } else {
            price_col = '<td>'+buy_price+'</td><td>'+sell_price+'</td>';
        }
        
        if(options.currency_code == null) {
            options.currency_code = options.service_currency_code;
        }
        
        if(parseInt(options.price_meal_plan_id) > 0) {
            //options.price_meal_plan_id
        }
        
        if(options.prices_season_period_start != '0000-00-00') {
            options.season_period_start_date = options.prices_season_period_start;
        }
        
        if(options.prices_season_period_end != '0000-00-00') {
            options.season_period_end_date = options.prices_season_period_end;
        }
        
        $('#prices_option_table').find('tbody').append('<tr id ="prices_options_row_'+counter+'"><td>'+hidden_elements+'<input type="checkbox" class="optcheckbox" value="'+options.price_id+'" name = "prices_options_row['+counter+'][row_selection]" id ="prices_options_row_selection_'+counter+'"></td><td>'+options.option_name+'</td><td>'+options.occupancy_name+'</td><td>'+options.season_period_start_date+'</td><td>'+options.season_period_end_date+'</td><td>'+options.policy_name+'</td><td>'+options.meal_plan_name+'</td><td>'+options.currency_code+'</td>'+price_col+'<td>'+options.price_margin+'</td><td>'+status_text+'</td></tr>');
    }
    function extra_price_row_template(counter, extras) {
        
        //console.log(extras);
        var hidden_elements = '';
        var status_active;
        var status_inactive;
        var status_text = "In-Active";
        var status_extra_is_mandatory_yes = '';
        var extra_is_mandatory_text = 'No';
        
        var contract_id = extras.contract_id;
        var contract_period_id = extras.contract_period_id;
        var season_id = extras.season_id;
        var season_period_id = extras.season_period_id;        
        var buy_price = extras.buy_price;        
        var sell_price = extras.sell_price;
        var week_prices_id = extras.week_prices_id;
        var policy_price_bands_id = extras.policy_price_bands_id;
        
        if(extras.price_status == 1) { // because we options status not working as it gets in duplicate record 
            status_active = 'selected';
            status_text = "Active";
        } else  if(extras.price_status == 0) {
            status_inactive = 'selected';
            status_text = "In-Active";
        }        
        
        if(extras.extra_is_mandatory == 1) { // because we options status not working as it gets in duplicate record 
            status_extra_is_mandatory_yes = 'selected';
            extra_is_mandatory_text = "Yes";
        } else  if(extras.extra_is_mandatory == 0) {
            status_extra_is_mandatory_no = 'selected';
            extra_is_mandatory_text = "No";
        }
        
        
        
        buy_price = parseFloatPrice(buy_price);
        sell_price = parseFloatPrice(sell_price);  
        
        if(buy_price == '') {
            buy_price = '-';
        }
        if(sell_price == '') {
            sell_price = '-';
        }
        
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-price-id" id = "prices_extras_row_price_id_'+counter+'" name = "prices_extras_row['+counter+'][price_id]" placeholder="Extra PRICE ID" value = "'+extras.price_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-extra-id" id = "prices_extras_row_extra_id_'+counter+'" name = "prices_extras_row['+counter+'][extra_id]" placeholder="Extra ID" value = "'+extras.extra_id+'">';
        
        
        if(typeof(extras.mandatory_for_option_id) != 'undefined' && extras.mandatory_for_option_id != '' && parseInt(extras.mandatory_for_option_id) > 0) {
            hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-mandatory-for-option-id" id = "prices_extras_row_mandatory_for_option_id_'+counter+'" name = "prices_extras_row['+counter+'][mandatory_for_option_id]" placeholder="mandatory_for_option_id" value = "'+extras.mandatory_for_option_id+'">';
        }
        
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-contract-id" id = "prices_extras_row_contract_id_'+counter+'" name = "prices_extras_row['+counter+'][contract_id]" placeholder="contract ID" value = "'+contract_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-contract-period-id" id = "prices_extras_row_contract_period_id_'+counter+'" name = "prices_extras_row['+counter+'][contract_period_id]" placeholder="contract Period ID" value = "'+contract_period_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-season-id" id = "prices_extras_row_season_id_'+counter+'" name = "prices_extras_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'">';
        hidden_elements = hidden_elements + '<input type="hidden" class="form-control prices-extras-row-season-period-id "id = "prices_extras_row_season_period_id_'+counter+'" name = "prices_extras_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'">';
        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-week-prices-id" id = "prices_options_row_week_prices_id_'+counter+'" name = "prices_options_row['+counter+'][week_prices_id]" placeholder="week_prices_id" value = "'+week_prices_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-policy-price-bands-id" id = "prices_options_row_policy_price_bands_id_'+counter+'" name = "prices_options_row['+counter+'][policy_price_bands_id]" placeholder="policy_price_bands_id" value = "'+policy_price_bands_id+'">';
        
        var pricebands_or_weekprices = '';
        if(extras.WEEKDAYPRICES_EXISTS == 'NO' && extras.PRICEBAND_EXISTS == 'YES') {
            pricebands_or_weekprices = 'pricebands';
        } else if(extras.WEEKDAYPRICES_EXISTS == 'YES' && extras.PRICEBAND_EXISTS == 'NO') {
            pricebands_or_weekprices = 'weekprices';
        }
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-pricebands-or-weekprices" id = "prices_extras_row_pricebands_or_weekprices_'+counter+'" name = "prices_extras_row['+counter+'][pricebands_or_weekprices]" placeholder="pricebands-or-weekprices" value = "'+pricebands_or_weekprices+'">';
        
        var price_col = '';
        
        if(parseInt(week_prices_id)  > 0) {
        //if( 0) {
            price_col = '<td colspan="2"><span class="view-price" data-model-type="weekprices">View Price</span></td>';
        } else if(parseInt(policy_price_bands_id) > 0) {
        //} else if(0) {
            price_col = '<td colspan="2"><span class="view-price" data-model-type="pricebands">View Price</span></td>';
        } else {
            price_col = '<td>'+buy_price+'</td><td>'+sell_price+'</td>';
        }
        
        if(extras.currency_code == null) {
            extras.currency_code = extras.service_currency_code;
        }
        
        if(extras.prices_season_period_start != '0000-00-00') {
            extras.season_period_start_date = extras.prices_season_period_start;
        }
        
        if(extras.prices_season_period_end != '0000-00-00') {
            extras.season_period_end_date = extras.prices_season_period_end;
        }
        
        
        
        $('#prices_extra_table').find('tbody').append('<tr id ="prices_extras_row_'+counter+'"><td>'+hidden_elements+'<input type="checkbox" class="extcheckbox" value="'+extras.price_id+'" name = "prices_extras_row['+counter+'][row_selection]" id ="prices_extras_row_selection_'+counter+'"></td><td>'+extras.extra_name+'</td><td>'+extras.season_period_start_date+'</td><td>'+extras.season_period_end_date+'</td><td>'+extras.policy_name+'</td><td>'+extra_is_mandatory_text+'</td><td>'+extras.currency_code+'</td>'+price_col+'</td><td>'+extras.price_margin+'</td><td>'+status_text+'</td></tr>');
    }
    function parseFloatPrice(price) {            
            price = parseFloat(price).toFixed(2);
            if(price == 'NaN') {
                return '';
            }
            return price;
        }   
    function populate_meal_and_policy_dropdown_dynamically(data, element_obj, element_name, populate_for) {
        $this = element_obj;
        var counter = parseInt( $this.prop("id").match(/\d+/g) );
        var num = parseInt( $this.prop("name").match(/\d+/g) );
        var select_val = $this.text();
        var $str_select = '';
        var str_class = '';

        if(element_name=='charging_policy_id') {            
            var element_class_name = 'charging-policy-id';
            str_class = ' tdpriceband ';            
        } else if(element_name=='meal_plan_id') {
            var element_class_name = 'meal-plan-id';
            str_class = ' tdtxtsel ';
        } else if(element_name=='currency_id') {
            var element_class_name = 'currency-id';
            str_class = ' tdtxtsel ';
        } else if(element_name=='occupancy_id') {
            var element_class_name = 'occupancy-id';
            str_class = ' tdtxtsel ';
        }
        
        var element_class_name = element_name.replace(/\_/g,'-');


        if(populate_for=='prices-extras-row') {
            $str_select = '<select class ="form-control '+str_class+' inputval prices-extras-row-'+element_class_name+'" name ="prices_extras_row['+num+']['+element_name+']" id="prices_extras_row_'+element_name+'_'+counter+'" >';
        } else if(populate_for=='prices-options-row') {
            $str_select = '<select class ="form-control '+str_class+' inputval prices-options-row-'+element_class_name+'" name ="prices_options_row['+num+']['+element_name+']" id="prices_options_row_'+element_name+'_'+counter+'" >';
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
                $str_option = $str_option + '<option value="'+optionValue+'">'+optionText+'</option>';
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
    /*
    function pupulate_pagination_dropdown(data) {
        
        var total_pages_options = data.total_pages_options;        
        if(parseInt(total_pages_options) > 0) {
            var option_page_no = parseInt($('#option_page_no').val());                  
            var option_pegination_li = '';
            for(var loop = 1; loop <= total_pages_options; loop++) {
                var num = loop ;
               option_pegination_li = option_pegination_li+ '<li class="options-page-nav-change">'+num+'</li>';
            }

            var option_pegination = '<div data-toggle="dropdown" class="page-navigation-block"><span id="options_navigation_id" class="options-navigation-id">'+option_page_no+'</span><span class="caret"></span></div><ul class="dropdown-menu">'+option_pegination_li+'</ul>';

            $('#option_page_nevigation .page-navigation').html(option_pegination);
        } else {
            $('#option_page_nevigation .page-navigation').html('');
        }
        
        var total_pages_extras = data.total_pages_extras;            
        if(parseInt(total_pages_extras) > 0) {
            var extra_page_no = parseInt($('#extra_page_no').val());                  
            var extra_pegination_li = '';
            for(var loop = 1; loop <= total_pages_extras; loop++) {
                var num = loop;
               extra_pegination_li = extra_pegination_li+ '<li class="extras-page-nav-change">'+num+'</li>';
            }

            var extra_pegination = '<div data-toggle="dropdown" class="page-navigation-block"><span id="extras_navigation_id" class="extras-navigation-id">'+extra_page_no+'</span><span class="caret"></span></div><ul class="dropdown-menu">'+extra_pegination_li+'</ul>';

            $('#extra_page_nevigation .page-navigation').html(extra_pegination);
       
        } else {
            $('#extra_page_nevigation .page-navigation').html('');
        }
        
        

    }
    */
   function pupulate_pagination_dropdown(data) {        
        
        if(typeof(data.total_pages_options) != 'undefined') {
            var total_pages_options = data.total_pages_options; 
            if(parseInt(total_pages_options) > 0) {
                var option_page_no = parseInt($('#option_page_no').val());                  
                var option_pegination_li = '';
                for(var loop = 1; loop <= total_pages_options; loop++) {
                    var num = loop ;
                   option_pegination_li = option_pegination_li+ '<li class="options-page-nav-change">'+num+'</li>';
                }

                var option_pegination = '<div data-toggle="dropdown" class="page-navigation-block"><span id="options_navigation_id" class="options-navigation-id">'+option_page_no+'</span><span class="caret"></span></div><ul class="dropdown-menu">'+option_pegination_li+'</ul>';

                $('#option_page_nevigation .page-navigation').html(option_pegination);
            } else {
                $('#option_page_nevigation .page-navigation').html('');
            }
        }
        
        if(typeof(data.total_pages_extras) != 'undefined') {
            var total_pages_extras = data.total_pages_extras;            
            if(parseInt(total_pages_extras) > 0) {
                var extra_page_no = parseInt($('#extra_page_no').val());                  
                var extra_pegination_li = '';
                for(var loop = 1; loop <= total_pages_extras; loop++) {
                    var num = loop;
                   extra_pegination_li = extra_pegination_li+ '<li class="extras-page-nav-change">'+num+'</li>';
                }

                var extra_pegination = '<div data-toggle="dropdown" class="page-navigation-block"><span id="extras_navigation_id" class="extras-navigation-id">'+extra_page_no+'</span><span class="caret"></span></div><ul class="dropdown-menu">'+extra_pegination_li+'</ul>';

                $('#extra_page_nevigation .page-navigation').html(extra_pegination);

            } else {
                $('#extra_page_nevigation .page-navigation').html('');
            }
        }
       
    }
    
    function checkForValidation() {
        
        var validationCheck = true;
        
        var counta = 0;
        $(".sinputval").each(function () {
            if ($(this).val() == "") {
                counta++;
                if (counta == 1)
                    $(this).focus();
                $(this).addClass("errorbox");
            } else {
                $(this).removeClass("errorbox");
            }
        });
        countb = 0;
        $(".inputval").each(function () {
            if ($(this).val() == "") {
                countb++;
                if (countb == 1)
                    $(this).focus();
                $(this).addClass("errorbox");
            } else {
                $(this).removeClass("errorbox");
            }
        });        

        return validationCheck;
    }
    
    function getPriceBandAndWeekPriceData(service_id,option_id,season_period_id,isPriceBandOrWeekPrices,dataFor){
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
             url: Router.route('getPriceBandAndWeekPriceData'),
             dataType: 'json',
             type: 'POST',
             async: false,
             data: {service_id : service_id, option_id: option_id,seasonPeriodId:season_period_id, isPriceBandOrWeekPrices:isPriceBandOrWeekPrices, dataFor:dataFor},
             success: function(data) { 
                 return data;
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });      
    }
    
});
