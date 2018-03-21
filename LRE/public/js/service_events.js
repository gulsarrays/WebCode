jQuery(document).ready(function($){
    $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
    options.async = false;
    });
    var winHeight = $(window).height();
    $(window).scroll(function(){
        var docHeight = $(document).height();
        var nowScroll=$(this).scrollTop();
        if((docHeight-90)<(winHeight+nowScroll)){
            $(".flydiv").removeClass('flyactive');
        }else if(docHeight>700){
            $(".flydiv").addClass('flyactive');
        }
    });
    $(".panel-heading").click(function(){
        setTimeout(function(){
            docHeight = $(document).height();
            nowScroll=$(this).scrollTop();
            if((docHeight>670))
                $(".flydiv").addClass('flyactive');
            else
                $(".flydiv").removeClass('flyactive');
            if((docHeight-90)<(winHeight+nowScroll))
                $(".flydiv").removeClass('flyactive');
        },500);
    });
});
function formSubmit(){
    var count=0;
    $( ".sinputval" ).each(function() {
        if($(this).val()==""){
            count++;
            if(count == 1)
                $( this ).focus();
            $( this ).addClass( "errorbox" );
        }else{
            $( this ).removeClass( "errorbox" );
        }
    });
    $( ".inputval" ).each(function() {

        if($(this).val()==""){
            count++;
            if(count == 1)
                $( this ).focus();
            $( this ).addClass( "errorbox" );
        }else{
            $( this ).removeClass( "errorbox" );
        }
    });
}
function showPriceBox(pricetxt) {
    if(pricetxt=="weekprice")
        $('#weekModal').modal('show');
    else if(pricetxt=="priceband")
        $('#priceModal').modal('show');
}
$(function() {
    $(".pagereset").click(function(){
        count=0;
        $( ".inputval" ).each(function() {
            count++;
            if(count == 1)
                $( this ).focus();
            $( this ).addClass( "errorbox" );
        });
    });
    $('body').on('click', '.weekreset', function() {    
        $(".weekcheckbox").prop('checked', false);
        count=0;
        $( ".poptdtext" ).each(function() {
            count++;
            if(count == 1)
                $( this ).focus();
            $( this ).addClass( "errorbox" );
            $( this ).val("");
        });
    });
    $('body').on('click', '.pricereset', function() {
        count=0;
        $( ".poptdtext" ).each(function() {
            count++;
            if(count == 1)
                $( this ).focus();
            $( this ).addClass( "errorbox" );
            $( this ).val("");
        });
    });
    $('body').on('click', '.weeksave', function() {
        count=0; var r=0; var k=0; var s=0;
        $('.weekcheckbox').each(function(){
            r++
            if($(this).prop('checked'))
                s++;
            if((r%7)==0){
                if(s==0){
                    k++;
                }s=0;
            }
            if(k>0)
                $('.weekerror').addClass('weekerror-show');
            else
                $('.weekerror').removeClass('weekerror-show');
        });
        $( ".poptdtext" ).each(function() {
            if($(this).val()=="") {
                count++;
                if (count == 1)
                    $(this).focus();
                $(this).addClass("errorbox");
            }else{
                $(this).removeClass("errorbox");
            }
        });

    });
    $('body').on('click', '.pricesave', function() {
        count=0;
        $( ".poptdtext" ).each(function() {
            if($(this).val()=="") {
                count++;
                if (count == 1)
                    $(this).focus();
                $(this).addClass("errorbox");
            }else{
                $(this).removeClass("errorbox");
            }
        });
    });
   
    $('body').on('click', '.closeicon', function() {        
        hh=$(this).parent('div');
       
        $('.delpopup').css("display","block");
    });
    $('body').on('click', '.nobut', function() {    
        $('.delpopup').css("display","none");
    });
    $('body').on('click', '.yesbut', function() {
    
        var num = parseInt( hh.find(".delete_data_for_class").prop("id").match(/\d+/g) );
        var delete_data_for = hh.find(".delete_data_for_class").val();
        
        var service_id = hh.find(".prices-options-row-model-service-id").val();
        var option_id = hh.find(".prices-options-row-model-option-id").val();
        var isPriceBandOrWeekPrices = hh.find(".prices-options-row-model-isPriceBandOrWeekPrices").val();
        var dataFor = hh.find(".prices-options-row-model-dataFor").val();
        var seasonPeriodId = hh.find(".prices-options-row-model-seasonPeriodId").val();                 
        
        if(dataFor == 'ServiceOption') {
            
            if(isPriceBandOrWeekPrices == 'weekprices') {
                var week_prices_id = hh.find(".prices-options-row-week-prices-id").val();
                var price_id = hh.find(".prices-options-row-week-prices-price-id").val();
                url = Router.route('deleteWeekPrices');
            } else if(isPriceBandOrWeekPrices == 'pricebands') {
                var policy_price_bands_id = hh.find(".prices-options-row-policy-price-bands-id").val();
                var price_id = hh.find(".prices-options-row-price-bands-price-id").val();
                url = Router.route('deletePriceBands');
            }
            
        } else if(dataFor == 'ServiceExtra') {
            
            if(isPriceBandOrWeekPrices == 'weekprices') {
                var week_prices_id = hh.find(".prices-extras-row-week-prices-id").val();
                var price_id = hh.find(".prices-extras-row-week-prices-price-id").val();
                url = Router.route('deleteWeekPrices');
            }  else if(isPriceBandOrWeekPrices == 'pricebands') {
                var policy_price_bands_id = hh.find(".prices-extras-row-policy-price-bands-id").val();
                var price_id = hh.find(".prices-extras-row-price-bands-price-id").val();
                url = Router.route('deletePriceBands');
            }
            
        }
        
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},             
             url: url,
             dataType: 'json',
             type: 'POST',
             async: false,
             data: {service_id:service_id, option_id:option_id, price_id: price_id, week_prices_id: week_prices_id, policy_price_bands_id:policy_price_bands_id,isPriceBandOrWeekPrices:isPriceBandOrWeekPrices,dataFor:dataFor,seasonPeriodId:seasonPeriodId},
             success: function(data) { 
                
                if(data.status == false) {
                   var s_id =  '#prices_options_row_pricebands_or_weekprices_'+num;
                   $(s_id).val('');
                }
                hh.remove();
                //$('.delpopup').css("display","none");
                 
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(errorThrown);
             }
         });   
        
       // hh.remove();
        $('.delpopup').css("display","none");
    });

    $('body').on('click', '#addweekprice', function() {
        //console.log(($('.addweekrow').children().length-1));
        
        var num = parseInt( $('#weekprices_row_number_id').val());
        var weekprices_data_for =  $('#weekprices_data_for_id').val();
        
        var counter;
        counter = ($('.addweekrow').children().length-1);
        
        //if(($('.addweekrow').children().length-1) <= 6) {
        if(counter <= 6) {
            if(weekprices_data_for == 'ServiceOption') {
                var str_name = 'prices_options_row['+num+']';
                var str_id = 'prices_options_row';
                var str_class = 'prices-options-row-';
            } else {
                var str_name = 'prices_extras_row['+num+']';
                var str_id = 'prices_extras_row';
                var str_class = 'prices-extras-row-';
            }

            week_prices_monday = '';
            week_prices_tuesday = '';
            week_prices_wednesday = '';
            week_prices_thursday = '';
            week_prices_friday = '';
            week_prices_saturday = '';
            week_prices_sunday = '';

            week_prices_buy_price = '';
            week_prices_sell_price = '';              

            week_prices_id = '';
            week_prices_price_id = ''; 
            row = counter; 
               
               
            var row_data = '';
            row_data = "<div class='row poprecord'><div class='col-md-1 poptdrow'><label><input type='hidden' class='weekcheckbox "+str_class+"week-prices-price-id' id='"+str_id+"_week_prices_price_id_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_price_id]' value="+week_prices_price_id+"><input type='hidden' class='weekcheckbox "+str_class+"week-prices-id' id='"+str_id+"_week_prices_id_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_id]' value="+week_prices_id+"><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-monday' id='"+str_id+"_week_prices_monday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_monday]' "+week_prices_monday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-tuesday' id='"+str_id+"_week_prices_tuesday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_tuesday]' "+week_prices_tuesday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-wednesday' id='"+str_id+"_week_prices_wednesday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_wednesday]' "+week_prices_wednesday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-thursday' id='"+str_id+"_week_prices_thursday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_thursday]' "+week_prices_thursday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-friday' id='"+str_id+"_week_prices_friday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_friday]' "+week_prices_friday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-saturday' id='"+str_id+"_week_prices_saturday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_saturday]' "+week_prices_saturday+"></label></div><div class='col-md-1 poptdrow'><label><input type='checkbox' class='weekcheckbox "+str_class+"week-prices-sunday' id='"+str_id+"_week_prices_sunday_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_sunday]' "+week_prices_sunday+"></label></div><div class='col-md-2 poptdrow'><input type='text' class='form-control poptdtext "+str_class+"week-prices-buy-price' id='"+str_id+"_week_prices_buy_price_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_buy_price]' placeholder='Price' value='"+week_prices_buy_price+"'></div><div class='col-md-2 poptdrow'><input type='text' class='form-control poptdtext "+str_class+"week-prices-sell-price' id='"+str_id+"_week_prices_sell_price_"+counter+"' name='"+str_name+"[weekprices]["+parseInt(row)+"][week_prices_sell_price]' placeholder='Price' value='"+week_prices_sell_price+"'></div><div class='col-md-1 poptdrow showcloseicon'>&nbsp;</div></div>";
            
            $(".addweekrow").append(row_data);            
            
            $(".showcloseicon").click(function () {
                $(this).parent('div').remove();
            });
        }
    });

    $('body').on('click', '#addpriceband', function() {
        
        var num = parseInt( $('#pricebands_row_number_id').val());
        var pricebands_data_for =  $('#pricebands_data_for_id').val();
        var counter;
        counter = ($('.addpricerow').children().length-1);
        //alert(counter);
        if(pricebands_data_for == 'ServiceOption') {
            var str_name = 'prices_options_row['+num+']';
            var str_id = 'prices_options_row';
            var str_class = 'prices-options-row-';
        } else {
            var str_name = 'prices_extras_row['+num+']';
            var str_id = 'prices_extras_row';
            var str_class = 'prices-extras-row-';
        }
            
        price_bands_min = '';
        price_bands_max = '';
        price_bands_buy_price = '';
        price_bands_sell_price = '';
        price_bands_charging_policy_id = '';   
        price_bands_charging_policy_name = ''; 
        policy_price_bands_id = ''; 
        price_bands_price_id = '';   
        price_bands_id = '';
               
        
        row = counter; 
        
        var row_data = '';
            row_data = "<div class='row poprecord'><div class='col-md-3 poptdrow'><input type='hidden' class='form-control poptdtext "+str_class+"price-bands-price-id' id='"+str_id+"_price_bands_price_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_price_id]' value="+price_bands_price_id+"><input type='hidden' class='form-control poptdtext "+str_class+"price-bands-id' id='"+str_id+"_price_bands_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_id]' value="+price_bands_id+"><input type='hidden' class='form-control poptdtext "+str_class+"policy-price-bands-id' id='"+str_id+"_policy_price_bands_id_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][policy_price_bands_id]' value="+policy_price_bands_id+"><input type='text' id='"+str_id+"_price_bands_min_"+num+"' class='form-control poptdtext "+str_class+"price-bands-min'  name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_min]' placeholder='Min' value='"+price_bands_min+"'></div><div class='col-md-3 poptdrow'><input type='text' id='"+str_id+"_price_bands_max_"+num+"' class='form-control poptdtext "+str_class+"price-bands-max'  name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_max]' placeholder='Max' value='"+price_bands_max+"'></div><div class='col-md-3 poptdrow'><input type='text' id='"+str_id+"_price_bands_buy_price_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_buy_price]' class='form-control poptdtext "+str_class+"price-bands-buy-price' placeholder='Price' value='"+price_bands_buy_price+"'></div><div class='col-md-2 poptdrow'><input type='text' id='"+str_id+"_price_bands_sell_price_"+counter+"' name='"+str_name+"[pricebands]["+parseInt(row)+"][price_bands_sell_price]' class='form-control poptdtext "+str_class+"price-bands-sell-price' placeholder='Price' value='"+price_bands_sell_price+"'></div><div class='col-md-1 poptdrow showcloseicon'>&nbsp;</div></div>";
        
        $(".addpricerow").append(row_data);
        
        $(".showcloseicon").click(function(){
            $(this).parent('div').remove();
        });
    });
    
    
    options_holdrows = [];
    extras_holdrows = [];
    options_hidden_hold_str="";
    extras_hidden_hold_str="";

    $('body').on('click', '.rowyesbut', function() {
        if(options_holdrows.length>0) {
            $('#delete_option_prices').val(options_hidden_hold_str.slice(0,-1));
            $.each( options_holdrows, function( key, value ) {
                $(value).remove();
            });
            $('#edit_options_price_row').removeClass("butactive");
            $('#remove_options_price_row').removeClass("delactive");
            $('#add_options_price_row').removeClass("butactive");
        }else if(extras_holdrows.length>0) {
            $('#delete_extra_prices').val(extras_hidden_hold_str.slice(0,-1));
            $.each( extras_holdrows, function( key, value ) {
                $(value).remove();
            });
            $('#edit_extras_price_row').removeClass("butactive");
            $('#remove_extras_price_row').removeClass("delactive");
            $('#add_extras_price_row').removeClass("butactive");
        }
        options_holdrows = [];
        extras_holdrows = [];
        options_hidden_hold_str="";
        extras_hidden_hold_str="";
        $('.rowdelpopup').css("display","none");
    });
    $(".rownobut").click(function(){
        $('.rowdelpopup').css("display","none");
        options_holdrows = [];
        extras_holdrows = [];
        options_hidden_hold_str="";
        extras_hidden_hold_str="";
    });
    $('body').on('click', '#remove_options_price_row', function() {
        var i=0;
        options_hidden_hold_str=$('#delete_option_prices').val();
        if(options_hidden_hold_str!="")
            options_hidden_hold_str+=",";
        $('.optcheckbox:checked').each(function(){
            options_holdrows[i]="#"+$($(this).closest('tr')).attr('id');
            options_hidden_hold_str+=$(this).val()+",";
            i++;
        });
        if(i>0){
            $('.rowdelpopup').css("display","block");
        }
    });
    actRow="";
    $("#edit_options_price_row").on('click', function(){
        if($('.optcheckbox:checked').length==1 && $('.tdtext').length==0) {
            optrowid=$('.optcheckbox:checked').val();
            var num = parseInt( $('.optcheckbox:checked').prop("id").match(/\d+/g) );
            //alert(optrowid + ' > ' + num);
            optrowid = num;
            actRow=$('#prices_options_row_'+optrowid).html();
            
            var hidden_elements = '';
            var price_id = '';
            var option_id = '';
            var contract_id = '';
            var contract_period_id = '';
            var season_id = '';
            var season_period_id = '';
            var week_prices_id = '';
            var policy_price_bands_id = '';
            var pricebands_or_weekprices = '';
            var counter = optrowid;
            
            hidden_elements_col = $('#prices_options_row_'+optrowid).children('td:nth-child(1)');
            
            price_id = hidden_elements_col.find('.prices-options-row-price-id').val();
            option_id = hidden_elements_col.find('.prices-options-row-option-id').val();
            contract_id = hidden_elements_col.find('.prices-options-row-contract-id').val();
            contract_period_id = hidden_elements_col.find('.prices-options-row-contract-period-id').val();
            season_id = hidden_elements_col.find('.prices-options-row-season-id').val();
            season_period_id = hidden_elements_col.find('.prices-options-row-season-period-id').val();            
            week_prices_id = hidden_elements_col.find('.prices-options-row-week-prices-id').val();
            policy_price_bands_id = hidden_elements_col.find('.prices-options-row-policy-price-bands-id').val();
            pricebands_or_weekprices = hidden_elements_col.find('.prices-options-row-pricebands-or-weekprices').val();
        
            
            hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-price-id" id = "prices_options_row_price_id_'+counter+'" name = "prices_options_row['+counter+'][price_id]" placeholder="Option ID" value = "'+price_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-option-id" id = "prices_options_row_option_id_'+counter+'" name = "prices_options_row['+counter+'][option_id]" placeholder="Option ID" value = "'+option_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-contract-id" id = "prices_options_row_contract_id_'+counter+'" name = "prices_options_row['+counter+'][contract_id]" placeholder="Contract ID" value = "'+contract_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-contract-period-id" id = "prices_options_row_contract_period_id_'+counter+'" name = "prices_options_row['+counter+'][contract_period_id]" placeholder="Contract Period ID" value = "'+contract_period_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-season-id" id = "prices_options_row_season_id_'+counter+'" name = "prices_options_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'">';        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-season-period-id" id = "prices_options_row_season_period_id_'+counter+'" name = "prices_options_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'">';
        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-week-prices-id" id = "prices_options_row_week_prices_id_'+counter+'" name = "prices_options_row['+counter+'][week_prices_id]" placeholder="week_prices_id" value = "'+week_prices_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-policy-price-bands-id" id = "prices_options_row_policy_price_bands_id_'+counter+'" name = "prices_options_row['+counter+'][policy_price_bands_id]" placeholder="policy_price_bands_id" value = "'+policy_price_bands_id+'">';
        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-options-row-pricebands-or-weekprices" id = "prices_options_row_pricebands_or_weekprices_'+counter+'" name = "prices_options_row['+counter+'][pricebands_or_weekprices]" placeholder="pricebands-or-weekprices" value = "'+pricebands_or_weekprices+'"><input type="hidden" class="form-control prices-options-row-price-edited" id = "prices_options_row_price_edited_'+counter+'" name = "prices_options_row['+counter+'][price_edited]" value = "1">';
        
        
        
        
            
        var price_col = '';
        
        if(pricebands_or_weekprices == 'weekprices' || pricebands_or_weekprices == 'pricebands') {
            //price_col = "<td colspan='2'><span class='edit-price' data-model-type='"+$('#prices_options_row_'+optrowid).children('td:nth-child(6)').html()+"'>Edit Price</span></td>";
            price_col = "<td colspan='2'><span class='edit-price' data-model-type='"+pricebands_or_weekprices+"'>Edit Price</span></td>";
            var str_margin = $('#prices_options_row_'+optrowid).children('td:nth-child(10)').html();
            var status = $('#prices_options_row_'+optrowid).children('td:nth-child(11)').html();
        } else {
            price_col = "<td><input id='prices_options_row_buy_price_"+optrowid+"' class='form-control tdsmtxt inputval prices-options-row-buy-price' name='prices_options_row["+optrowid+"][buy_price]' type='text' value='"+$('#prices_options_row_'+optrowid).children('td:nth-child(9)').html()+"' placeholder='Price'></td><td><input id='prices_options_row_sell_price_"+optrowid+"' class='form-control tdsmtxt inputval prices-options-row-sell-price' name='prices_options_row["+optrowid+"][sell_price]' type='text' value='"+$('#prices_options_row_'+optrowid).children('td:nth-child(10)').html()+"' placeholder='Price'></td>";
            var str_margin = $('#prices_options_row_'+optrowid).children('td:nth-child(11)').html();
            var status = $('#prices_options_row_'+optrowid).children('td:nth-child(12)').html();
        }
//        var str_margin =  $('#prices_options_row_'+optrowid).children('td:nth-child(11)').html();
//        var status = $('#prices_options_row_'+optrowid).children('td:nth-child(12)').html();
         
         var str_status_active = '';
         var str_status_in_active = '';
         
         if(status == 'Active') {
             str_status_active = ' selected ';
             str_status_in_active = '  ';
         } else {
             str_status_active = '';
             str_status_in_active = ' selected ';
         }
         
         var start_date_str = $('#prices_options_row_'+optrowid).children('td:nth-child(4)').html();
         var end_date_str = $('#prices_options_row_'+optrowid).children('td:nth-child(5)').html();
         
        
        var tdate = new Date();
        var dd = strpad00(tdate.getDate()); //yields day
        var MM = strpad00(tdate.getMonth()); //yields month
        var yyyy = tdate.getFullYear(); //yields year
        var nyyyy = yyyy+1;
   
         if(start_date_str == 'null' ) {            
             start_date_str = yyyy+'-'+MM+'-'+dd;
         }
         if(end_date_str == 'null' ) {            
             end_date_str = nyyyy+'-'+MM+'-'+dd;
         }



            appendStr="<td><input type='hidden' id='options_hidden_"+optrowid+"'>"+hidden_elements+"<input id='prices_options_row_selection_"+optrowid+"' class='optcheckbox' name='prices_options_row_selection' type='checkbox' value='"+optrowid+"' checked></td><td><input type='text' id='prices_options_row_option_name_"+optrowid+"' class='form-control tdtext inputval prices-options-row-option-name' name='prices_options_row["+optrowid+"][option_name]'  placeholder='Name' value='"+$('#prices_options_row_'+optrowid).children('td:nth-child(2)').html()+"' ></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_options_row_occupancy_id_"+optrowid+"' class='form-control tdtxtsel inputval prices-options-row-occupancy-id' name='prices_options_row["+optrowid+"][occupancy_id]'><option value='"+$('#prices_options_row_'+optrowid).children('td:nth-child(3)').html()+"'>"+$('#prices_options_row_'+optrowid).children('td:nth-child(3)').html()+"</option></select></div></td><td><div class='elehold'><lable for ='prices_options_row_start_date_"+optrowid+"'><i class='datecalicon'></i></lable><input id='prices_options_row_start_date_"+optrowid+"' class='form-control opttddatetxt inputval prices-options-row-start-date' name='prices_options_row["+optrowid+"][start_date]' type='text' value='"+start_date_str+"' placeholder='From Date'></div></td><td><div class='elehold'><lable for ='prices_options_row_end_date_"+optrowid+"'><i class='datecalicon'></i></lable><input id='prices_options_row_end_date_"+optrowid+"' class='form-control opttddatetxt inputval prices-options-row-end-date' name='prices_options_row["+optrowid+"][end_date]' type='text' value='"+end_date_str+"' placeholder='To Date'></div></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_options_row_charging_policy_id_"+optrowid+"' class='form-control tdpriceband inputval prices-options-row-charging-policy-id' name='prices_options_row["+optrowid+"][charging_policy_id]' onchange='showPriceBox(this.value)'><option value='"+$('#prices_options_row_'+optrowid).children('td:nth-child(6)').html()+"'>"+$('#prices_options_row_'+optrowid).children('td:nth-child(6)').html()+"</option></select></div></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_options_row_meal_plan_id_"+optrowid+"' class='form-control tdtxtsel inputval prices-options-row-meal-plan-id' name='prices_options_row["+optrowid+"][meal_plan_id]'><option value='"+$('#prices_options_row_'+optrowid).children('td:nth-child(7)').html()+"'>"+$('#prices_options_row_'+optrowid).children('td:nth-child(7)').html()+"</option></select></div></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_options_row_currency_id_"+optrowid+"' class='form-control tdtxtsel inputval prices-options-row-currency-id' name='prices_options_row["+optrowid+"][currency_id]'><option value='"+$('#prices_options_row_'+optrowid).children('td:nth-child(8)').html()+"'>"+$('#prices_options_row_'+optrowid).children('td:nth-child(8)').html()+"</option></select></div></td>"+price_col+"<td><input id='prices_options_row_price_margin_"+optrowid+"' class='form-control tdsmtxt inputval prices-options-row-price-margin' name='prices_options_row["+optrowid+"][price_margin]' type='text' value='"+str_margin+"' placeholder='%'></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_options_row_status_"+optrowid+"' class='form-control tdtxtsel inputval prices-options-row-status' name='prices_options_row["+optrowid+"][status]'><option value='1' "+str_status_active+">Active</option><option value='0' "+str_status_in_active+">In-Active</option></select></div></td>";
            
            $("#prices_options_row_"+optrowid).empty();
            $("#prices_options_row_"+optrowid).append(appendStr);
            $(".opttddatetxt").daterangepicker({
                singleDatePicker: true,
                "autoUpdateInput": true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            } ,function(){
                setTimeout(function () {
                    datefrom = new Date($(".prices-options-row-start-date").val());
                    dateto = new Date($(".prices-options-row-end-date").val());
                    if(dateto<=datefrom){
                        $(".prices-options-row-end-date").addClass("errorbox");
                    }else{
                        $(".prices-options-row-end-date").removeClass("errorbox");
                    }
                }, 100);
            });
            
            $('#prices_options_row_occupancy_id_'+optrowid).trigger( "click" );
            $('#prices_options_row_charging_policy_id_'+optrowid).trigger( "click" );
            $('#prices_options_row_meal_plan_id_'+optrowid).trigger( "click" );
            $('#prices_options_row_currency_id_'+optrowid).trigger( "click" );
            
        }
    });
    
    $("#add_options_price_row").on('click', function(){
        if($('.optcheckbox:checked').length==1 && $('.tdtext').length==0) {
            optrowid=$('.optcheckbox:checked').val();
            var num = parseInt( $('.optcheckbox:checked').prop("id").match(/\d+/g) );
            //alert(optrowid + ' > ' + num);
            optrowid = num;
            
            newid=$('.optcheckbox').length+1;
            //newid=optrowid+1;
            rowStr=$("#prices_options_row_"+optrowid).html();
            
            var pricebands_or_weekprices = $("#prices_options_row_pricebands_or_weekprices_"+optrowid).val();
            //alert(pricebands_or_weekprices);
            
            var pricebands_or_weekprices_str = '<input id="prices_options_row_pricebands_or_weekprices_'+optrowid+'" class="form-control prices-options-row-pricebands-or-weekprices" type="hidden" value="'+pricebands_or_weekprices+'" placeholder="pricebands-or-weekprices" name="prices_options_row['+optrowid+'][pricebands_or_weekprices]">';
            //var pricebands_or_weekprices_str = '';
            
            $(".optcheckbox:checked").prop('checked', false);
            $("#prices_option_table").append("<tr class='justadded prices-options-row' id='prices_options_row_"+newid+"'><td><input type='hidden' id='options_hidden_"+newid+"'>"+pricebands_or_weekprices_str+"<input id='prices_options_row_selection_"+newid+"' class='optcheckbox' name='prices_options_row_selection' type='checkbox' value='"+newid+"' checked></td>"+rowStr.substr(rowStr.indexOf("</td>") + 1)+"</tr>");
            setTimeout(function () {
                $('tr').removeClass('justadded');
            }, 500);
            
            $('#edit_options_price_row').addClass("butactive");
            $('#remove_options_price_row').addClass("delactive");
            $('#add_options_price_row').addClass("butactive");
            
            $('#edit_options_price_row').trigger("click");
        }
    });

    $("#optdate").daterangepicker({
        "autoUpdateInput": false,
        "cancelClass": "closecan",
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
   
    $("#add_extras_price_row").on('click', function(){
        if($('.extcheckbox:checked').length==1 && $('.tdtext').length==0) {
            extrowid=$('.extcheckbox:checked').val();
             var num = parseInt( $('.extcheckbox:checked').prop("id").match(/\d+/g) );
            //alert(optrowid + ' > ' + num);
            extrowid = num;
            newid=$('.extcheckbox').length+1;
            rowStr=$("#prices_extras_row_"+extrowid).html();
            $(".extcheckbox:checked").prop('checked', false);
            
            $("#prices_extra_table").append("<tr class='justadded prices-extras-row' id='prices_extras_row_"+newid+"'><td><input type='hidden' id='extras_hidden_"+newid+"'><input id='prices_extras_row_selection_"+newid+"' class='extcheckbox' name='prices_extras_row_selection' type='checkbox' value='"+newid+"' checked></td>"+rowStr.substr(rowStr.indexOf("</td>") + 1)+"</tr>");
            setTimeout(function () {
                $('tr').removeClass('justadded');
            }, 500);
            
            $('#edit_extras_price_row').addClass("butactive");
            $('#remove_extras_price_row').addClass("delactive");
            $('#add_extras_price_row').addClass("butactive");
            $('#link_extras_price_row').removeClass("butactive");
            
            $('#edit_extras_price_row').trigger("click");
        }
    });
    $("#edit_extras_price_row").on('click', function(){
        if($('.extcheckbox:checked').length==1 && $('.tdtext').length==0) {
            extrowid=$('.extcheckbox:checked').val();
            var num = parseInt( $('.extcheckbox:checked').prop("id").match(/\d+/g) );            
            extrowid = num;
            actRow=$('#prices_extras_row_'+extrowid).html();

            var hidden_elements = '';
            var price_id = '';
            var extra_id = '';
            var contract_id = '';
            var contract_period_id = '';
            var season_id = '';
            var season_period_id = '';
            var week_prices_id = '';
            var policy_price_bands_id = '';
            var pricebands_or_weekprices = '';
            var hidden_elements_col = '';
            var counter = extrowid;
            
            hidden_elements_col = $('#prices_extras_row_'+extrowid).children('td:nth-child(1)');
            
            price_id = hidden_elements_col.find('.prices-extras-row-price-id').val();
           
            
            extra_id = hidden_elements_col.find('.prices-extras-row-extra-id').val();
            contract_id = hidden_elements_col.find('.prices-extras-row-contract-id').val();
            contract_period_id = hidden_elements_col.find('.prices-extras-row-contract-period-id').val();
            season_id = hidden_elements_col.find('.prices-extras-row-season-id').val();
            season_period_id = hidden_elements_col.find('.prices-extras-row-season-period-id').val();            
            week_prices_id = hidden_elements_col.find('.prices-extras-row-week-prices-id').val();
            policy_price_bands_id = hidden_elements_col.find('.prices-extras-row-policy-price-bands-id').val();
            pricebands_or_weekprices = hidden_elements_col.find('.prices-extras-row-pricebands-or-weekprices').val();
        
        
            
            hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-price-id" id = "prices_extras_row_price_id_'+counter+'" name = "prices_extras_row['+counter+'][price_id]" placeholder="Price Id" value = "'+price_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-option-id" id = "prices_extras_row_extra_id_'+counter+'" name = "prices_extras_row['+counter+'][extra_id]" placeholder="extra ID" value = "'+extra_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-contract-id" id = "prices_extras_row_contract_id_'+counter+'" name = "prices_extras_row['+counter+'][contract_id]" placeholder="Contract ID" value = "'+contract_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-contract-period-id" id = "prices_extras_row_contract_period_id_'+counter+'" name = "prices_extras_row['+counter+'][contract_period_id]" placeholder="Contract Period ID" value = "'+contract_period_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-season-id" id = "prices_extras_row_season_id_'+counter+'" name = "prices_extras_row['+counter+'][season_id]" placeholder="Season ID" value = "'+season_id+'">';        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-season-period-id" id = "prices_extras_row_season_period_id_'+counter+'" name = "prices_extras_row['+counter+'][season_period_id]" placeholder="Season Period Id" value = "'+season_period_id+'">';
        
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-week-prices-id" id = "prices_extras_row_week_prices_id_'+counter+'" name = "prices_extras_row['+counter+'][week_prices_id]" placeholder="week_prices_id" value = "'+week_prices_id+'">';
        hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-policy-price-bands-id" id = "prices_extras_row_policy_price_bands_id_'+counter+'" name = "prices_extras_row['+counter+'][policy_price_bands_id]" placeholder="policy_price_bands_id" value = "'+policy_price_bands_id+'">';
       hidden_elements = hidden_elements+'<input type="hidden" class="form-control prices-extras-row-pricebands-or-weekprices" id = "prices_extras_row_pricebands_or_weekprices_'+counter+'" name = "prices_extras_row['+counter+'][pricebands_or_weekprices]" placeholder="pricebands-or-weekprices" value = "'+pricebands_or_weekprices+'"><input type="hidden" class="form-control prices-extras-row-price-edited" id = "prices_extras_row_price_edited_'+counter+'" name = "prices_extras_row['+counter+'][price_edited]" value = "1">';     
       
            
        var price_col = '';
        var policy_name = '';
       // policy_name = 'weekprice';
       //alert('pricebands_or_weekprices : '+pricebands_or_weekprices);
        if(pricebands_or_weekprices == 'weekprices' || pricebands_or_weekprices == 'pricebands') {
            //price_col = "<td colspan='2'><span class='edit-price' data-model-type='"+$('#prices_extras_row_'+extrowid).children('td:nth-child(6)').html()+"'>Edit Price</span></td>";
            
            price_col = "<td colspan='2'><span class='edit-price' data-model-type='"+pricebands_or_weekprices+"'>Edit Price</span></td>";
            var str_margin = $('#prices_extras_row_'+extrowid).children('td:nth-child(9)').html();
            var status = $('#prices_extras_row_'+extrowid).children('td:nth-child(10)').html();
            
        } else {
            price_col = "<td><input id='prices_extras_row_buy_price_"+extrowid+"' class='form-control tdsmtxt inputval prices-extras-row-buy-price' name='prices_extras_row["+extrowid+"][buy_price]' type='text' value='"+$('#prices_extras_row_'+extrowid).children('td:nth-child(8)').html()+"' placeholder='Price'></td><td><input id='prices_extras_row_sell_price_"+extrowid+"' class='form-control tdsmtxt inputval prices-extras-row-sell-price' name='prices_extras_row["+extrowid+"][sell_price]' type='text' value='"+$('#prices_extras_row_'+extrowid).children('td:nth-child(9)').html()+"' placeholder='Price' readonly></td>";
            
            var str_margin = $('#prices_extras_row_'+extrowid).children('td:nth-child(10)').html();
            var status = $('#prices_extras_row_'+extrowid).children('td:nth-child(11)').html();
        }
         var is_mandatory = $('#prices_extras_row_'+extrowid).children('td:nth-child(6)').html();
         var str_is_mandatory_yes = '';
         var str_is_mandatory_no = '';
         
         if(is_mandatory == 'Yes') {
             str_is_mandatory_yes = ' selected ';
             str_is_mandatory_no = ' selected ';
         } else {
             var str_is_mandatory_yes = '';
             var str_is_mandatory_no = ' selected ';
         }
         //var status = $('#prices_extras_row_'+extrowid).children('td:nth-child(11)').html();
         
         var str_status_active = '';
         var str_status_in_active = '';
         
         if(status == 'Active') {
             str_status_active = ' selected ';
             str_status_in_active = '  ';
         } else {
             str_status_active = '';
             str_status_in_active = ' selected ';
         }
         
        var start_date_str = $('#prices_extras_row_'+extrowid).children('td:nth-child(3)').html();
        var end_date_str = $('#prices_extras_row_'+extrowid).children('td:nth-child(4)').html();

        var tdate = new Date();
        var dd = strpad00(tdate.getDate()); //yields day
        var MM = strpad00(tdate.getMonth()); //yields month
        var yyyy = tdate.getFullYear(); //yields year
        var nyyyy = yyyy+1;
   
         if(start_date_str == 'null' ) {            
             start_date_str = yyyy+'-'+MM+'-'+dd;
         }
         if(end_date_str == 'null' ) {            
             end_date_str = nyyyy+'-'+MM+'-'+dd;
         }

            
            appendStr="<td><input type='hidden' id='extras_hidden_"+extrowid+"'>"+hidden_elements+"<input id='prices_extras_row_selection_"+extrowid+"' class='extcheckbox' name='prices_extras_row_selection' type='checkbox' value='"+extrowid+"' checked></td><td><input type='text' id='prices_extras_row_extra_name_"+extrowid+"' class='form-control tdtext inputval prices-extras-row-extra-name' name='prices_extras_row["+extrowid+"][extra_name]' placeholder='Name' value='"+$('#prices_extras_row_'+extrowid).children('td:nth-child(2)').html()+"'></td><td><div class='elehold'><i class='datecalicon'></i><input id='prices_extras_row_start_date_"+extrowid+"' class='form-control exttddatetxt inputval prices-extras-row-start-date' name='prices_extras_row["+extrowid+"][start_date]' value='"+start_date_str+"' type='text' placeholder='From Date'></div></td><td><div class='elehold'><i class='datecalicon'></i><input id='prices_extras_row_end_date_"+extrowid+"' class='form-control exttddatetxt inputval prices-extras-row-end-date' name='prices_extras_row["+extrowid+"][end_date]' value='"+end_date_str+"' type='text' placeholder='To Date'></div></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_extras_row_charging_policy_id_"+extrowid+"' class='form-control tdpriceband inputval prices-extras-row-charging-policy-id' name='prices_extras_row["+extrowid+"][charging_policy_id]' onchange='showPriceBox(this.value)'><option value='"+$('#prices_extras_row_'+extrowid).children('td:nth-child(5)').html()+"'>"+$('#prices_extras_row_'+extrowid).children('td:nth-child(5)').html()+"</option></select></div></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_extras_row_is_mandatory_"+extrowid+"' class='form-control tdtxtsel inputval prices-extras-row-is-mandatory' name='prices_extras_row["+extrowid+"][is_mandatory]'><option value='1' "+str_is_mandatory_yes+">Yes</option><option value='0' "+str_is_mandatory_no+">No</option></select></div></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_extras_row_currency_id_"+extrowid+"' class='form-control tdtxtsel inputval prices-extras-row-currency-id' name='prices_extras_row["+extrowid+"][currency_id]'><option value='"+$('#prices_extras_row_'+extrowid).children('td:nth-child(7)').html()+"'>"+$('#prices_extras_row_'+extrowid).children('td:nth-child(7)').html()+"</option></select></div></td>"+price_col+"<td><input id='prices_extras_row_price_margin_"+extrowid+"' class='form-control tdsmtxt inputval prices-extras-row-price-margin' name='prices_extras_row["+extrowid+"][price_margin]' type='text' value='"+str_margin+"' placeholder='%'></td><td><div class='elehold'><i class='dropdown-icon2 tdtxticon'></i><select id='prices_extras_row_status_"+extrowid+"' class='form-control tdtxtsel inputval prices-extras-row-status' name='prices_extras_row["+extrowid+"][status]'><option value='1' "+str_status_active+">Active</option><option value='0' "+str_status_in_active+">In-Active</option></select></div></td>";
            $("#prices_extras_row_"+extrowid).empty();
            $("#prices_extras_row_"+extrowid).append(appendStr);
            $(".exttddatetxt").daterangepicker({
                singleDatePicker: true,
                "autoUpdateInput": true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            } ,function(){
                setTimeout(function () {
                    datefrom = new Date($(".prices-extras-row-start-date").val());
                    dateto = new Date($(".prices-extras-row-end-date").val());
                    if(dateto<=datefrom){
                        $(".prices-extras-row-end-date").addClass("errorbox");
                    }else{
                        $(".prices-extras-row-end-date").removeClass("errorbox");
                    }
                }, 100);
            });
            
            $('#prices_extras_row_charging_policy_id_'+extrowid).trigger( "click" );
            $('#prices_extras_row_currency_id_'+extrowid).trigger( "click" );
        }
    });
    $('body').on('click', '#remove_extras_price_row', function() {
        var i=0;
        extras_holdrows=[];
        extras_hidden_hold_str=$('#delete_extra_prices').val();
        if(extras_hidden_hold_str!="")
            extras_hidden_hold_str+=",";
        $('.extcheckbox:checked').each(function(){
            extras_holdrows[i]="#"+$($(this).closest('tr')).attr('id');
            extras_hidden_hold_str+=$(this).val()+",";
            i++;
        });
        if(i>0){
            $('.rowdelpopup').css("display","block");
        }
    });
    $("#extdate").daterangepicker({
        "autoUpdateInput": false,
        "cancelClass": "closecan",
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
    
    $(document).delegate('.optcheckall', 'change', function(){
        if(this.checked) {
            $(".optcheckbox").prop('checked', $(this).prop("checked"));
            $('#remove_options_price_row').addClass("delactive");
            $('#edit_options_price_row').removeClass("butactive");
            $('#add_options_price_row').removeClass("butactive");
        }else{
            $(".optcheckbox").prop('checked', false);
            $('#edit_options_price_row').removeClass("butactive");
            $('#remove_options_price_row').removeClass("delactive");
            $('#add_options_price_row').removeClass("butactive");
        }
    });
    $(document).delegate('.extcheckall', 'change', function(){
        if(this.checked) {
            $(".extcheckbox").prop('checked', $(this).prop("checked"));
            $('#remove_extras_price_row').addClass("delactive");
            $('#edit_extras_price_row').removeClass("butactive");
            $('#add_extras_price_row').removeClass("butactive");
        }else{
            $(".extcheckbox").prop('checked', false);
            $('#edit_extras_price_row').removeClass("butactive");
            $('#remove_extras_price_row').removeClass("delactive");
            $('#add_extras_price_row').removeClass("butactive");
        }
    });
    
    $('body').on('keydown', '.poptdtext', function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
                // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('body').on('keydown', '.prices-options-row-buy-price', function(e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode == 67 && e.ctrlKey === true) ||
            (e.keyCode == 88 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }
        if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('body').on('keydown', '.prices-options-row-sell-price', function(e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode == 67 && e.ctrlKey === true) ||
            (e.keyCode == 88 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }
        if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    function strpad00(s){
        s = s + '';
        if (s.length === 1) s = '0'+s;
        return s;
    }

});
