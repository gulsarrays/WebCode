@extends('layouts.admin_interface_master')
@section('title')
List Contracts
@stop

@section('styles')
{{ HTML::style('css/jquery-ui.css') }}
{{ HTML::style('css/contract.css') }}
@stop


@section('body')
  

  <div class="container">
    <header class="col-md-12">
      <div class="wrapper">
        <a href="" class="pull-left logo-container">
          {{ HTML::image('img/logo.png') }}
        </a>

        <nav class="pull-left">
          <ul class="nav nav-tabs">
            <li role="presentation" class="pull-left">
              <a href="{{ URL::route('addContract') }}" class="active"> ADD CONTRACT</a>
            </li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="col-md-12 main-container">
      <div class="wrapper">
        <div class="to-top"> </div>
        <div class="panel-group col-md-12" id="accordion" role="tablist" aria-multiselectable="true">
             {{ Form::open(array('name'=>'frm_search', 'id'=> 'frm_search', 'method' => 'POST', 'action' => array('adminController@listSearchContracts'))) }}
          <div class="panel panel-default col-md-12">
            <div class="panel-heading col-md-12" role="tab" id="headingaccord1">
              <h4 class="panel-title col-md-12" >
                <a class="col-md-12" role="button" data-toggle="collapse" href="#tripdetails" aria-expanded="true" aria-controls="collapseOne">
                  <div class="titletxt">SEARCH SERVICES</div>
                  <span class="plus">+</span>
                  <span class="minus">-</span>
                </a>
              </h4>
            </div>
           
            <div id="tripdetails" class=" overflowhidden panel-collapse collapse in col-md-12" role="tabpanel" aria-labelledby="headingaccord1" >
              <div class="panel-body col-md-12">
                <div class="col-md-12 sscont">
                  <div class="sscontlines">
                    <div class="form-group mgn-rgt30 col-md-8">
                      <label for="service_name">Service Name:</label>
                      <input type="text" class="form-control" id="service_name" name = "service_name">
                    </div>
                    <div class="form-group col-md-4 wdt307perc mgn-tp27 ">
                      <input type="button" name="next" class="wdt100perc btn btn-primary btn-search" value="SEARCH">
                    </div>
                  </div>

                  <div class="sscontlines selectioncontainer">
                    <div class="selectionconts">
                      <label>Regions:</label>
                      <div class="listcontainer" id="regions">
                        <ul>
                        @foreach($regions as $key => $region)
                            @if($region->name !== '')
                          <li>
                              <input id="regions_{{$key}}" type="checkbox" name="regions[]" value = {{$region->id}} />
                            <label for="regions_{{$key}}">{{$region->name}}</label>
                          </li>
                          @endif
                        @endforeach
                        </ul>
                      </div>
                    </div>
                    <div class="selectionconts">
                      <label>Service Type:</label>
                      <div class="listcontainer mgn-btm14" id="interests">
                        <ul>
                          
                        @foreach($serviceTypes as $key => $serviceType)
                            @if($serviceType->name !== '')
                          <li>
                              <input id="serviceType_{{$key}}" type="checkbox" name="service_type[]" value = {{$serviceType->id}} />
                              <label for="serviceType_{{$key}}">{{$serviceType->name}}</label>
                          </li>
                          @endif
                        @endforeach
                          
                        </ul>
                      </div>
                    </div>

                    <div class="selectiondispconts">
                      <label>Selections:</label>
                      <div class="listcontainer listselected" id="listselected">
                        <ul>
                        </ul>
                      </div>
                    </div>

                  </div>

                  <div class="sscontlines">
                    <label for="first-name">Service Status:</label>
                    <form class="checkbox"> 
                      <input type="checkbox" name="status[]" id="active" value="1">
                      <label for="active">Active</label>   
                      <input type="checkbox" name="status[]" id="inactive" value="0">
                      <label for="inactive">Inactive</label>               
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            
          </div>
 {{ Form::close() }} 



          <div class="panel panel-default col-md-12">
            <div class="panel-heading col-md-12" role="tab" id="headingaccord4">
              <h4 class="panel-title col-md-12" >
                <a class="col-md-12" role="button" data-toggle="collapse" href="#summaryacco" aria-expanded="true" aria-controls="collapseOne">
                  <div class="titletxt">SERVICES LIST</div>
                  <span class="plus"> + </span>
                  <span class="minus"> - </span>
                </a>
              </h4>
            </div>
            <div id="summaryacco" class="panel-collapse collapse in col-md-12" role="tabpanel" aria-labelledby="headingaccord4">
              <div class="panel-body col-md-12">
                <div class="slcontainer">

                  <div class="slcontlinesdottec">
                    <div class="slcontlines">
                      <div class="form-group goldencont">
                        <label for="status">Status:</label>
                        <i class="dropdown-icon"></i>
                        <select class="form-control" id="apply_status">
                          <option>Active</option>
                          <option>Inactive</option>
                        </select>
                      </div>
                      <div class="form-group goldencont">
                        <label for="margin">Margin:</label>
                        <input type="text" class="form-control" id="apply_margin">
                      </div>
                      <div class="form-group wdt307perc displayinflex">
                        <input type="button" name="apply_to_all" class="btn btn-primary btn-apply-to-all" value="APPLY TO ALL">
                      </div>
                    </div>
                  </div>

                    {{ Form::open(array('name'=>'frm_list', 'id'=> 'frm_list', 'method' => 'POST', 'action' => array('adminController@updateContract'))) }}
                  <div class="slserviectable">

                    <table class="slserviectabletb" id="serviceListTable">
                      <thead>
                        <tr>
                          <th class="checkbox"> 
                            <input type="checkbox" name="service" id="checking">
                            <label for="checking"></label>
                          </th>
                          <th class="wdt25per"> Service Name </th>
                          <th class="wdt20per"> Service Type  </th>
                          <th class="wdt18per"> Region </th>
                          <th class="wdt18per"> Status </th>
                          <th class="wdt11per"> Margin </th>
                        </tr>
                      </thead>
                      
                      <tbody>
                      
                        <input type="hidden" name="selected_service_tsid" id="selected_service_tsid" value=''>
                        <input type="hidden" name="selected_service_id" id="selected_service_id" value=''>
                          @foreach($services as $key => $service)
                          
                         
                          
                          <tr>
                            <td class="checkbox">
                              <input class="list_tsid_check" type="hidden" name="service_tsid[]" id="serviceTsId_{{$service->service_id}}" value='{{ $service->ts_id }}'>
                              <input class="list_check" type="checkbox" name="serviceId[]" id="serviceId_{{$service->service_id}}" value='{{ $service->service_id }}' >
                              <label for="serviceId_{{$service->service_id}}"></label>
                            </td>
                            <td class="wdt25per">{{ $service->ts_id. " - " .$service->service_name }} </td>
                            <td class="wdt20per">{{ $service->service_types }} </td>
                            <td class="wdt18per">{{ $service->region_name  }} </td>
                            <td class="wdt18per">
                                @if($service->service_status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                               
                            </td>
                            <td class="wdt11per">{{ adminController::getMarginForSellPrice($service->buy_price, $service->sell_price)}} % </td>
                            </tr>
                          @endforeach
                      
                        <tr class="loadmorerow">
                          <td colspan="6" class="loadmore">
                            <a href="javascript:;"onClick='getMoreResults("service_name=",2);' class = 'btn-loadmore'>load more</a>
                          </td>
                        </tr>

                      </tbody>
                      
                    </table>

                  </div>
                  <div>
                    <input type="button" name="next" class="btn btn-primary mgn-rgt30 btn-submit" value="EDIT">
                    <input type="button" name="next" class="btn btn-gold" value="EXPORT">
                  </div>
                    {{ Form::close() }}  
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
    <!-- main container -->


  </div>

@section('scripts')
{{ HTML::script('js/jquery-ui.js') }}
{{ HTML::script('js/script.js') }}
{{ HTML::script('js/ie10-viewport-bug-workaround.js') }}

<script>

        
    function getMoreResults(post_string,current_page) { //user clicks on button  
        loadServiceList(post_string,current_page); 
    }
    function loadServiceList(post_string,current_page,apply_changes=false) {

        var checkValues = $('input.list_check:checked').map(function()
            {
                return $(this).val();
            }).get();
            
        if(post_string =='') {
            post_string = $( '#frm_search' ).serialize();
        }
            
        if(apply_changes == true) {                
            var apply_status = $( '#apply_status' ).val();
            var apply_margin = $( '#apply_margin' ).val();

            post_string = post_string+'&checkValues='+checkValues+'&apply_status='+apply_status+'&apply_margin='+apply_margin;

        }
            
        $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: $( '#frm_search' ).attr( 'action' ),
                    cache: false,
                    type: 'POST',
                    data: post_string+'&current_page='+current_page,
                    dataType: 'json',
                    success: function( data ) {
                        //console.log(data.services[0]);
                            // Show title
                            if ( data.status == 'error' ) {
                                    //$( '#results' ).html( '<h3>Error: ' + data.message + '</h3>' );
                                    alert('Error');
                                    return;
                            }
                            if ( data.status == 'success' ) { 
                                console.log(data);
                                if(current_page==1) {
                                    $('table#serviceListTable > tbody > tr').not(':last').remove();
                                }
                                 $.each( data.services, function( key, value ) {  
                                     //value.service_name
                                     if(value.service_status == 1) {
                                         value.service_status = "Active";
                                     } else {
                                         value.service_status = "Inactive";
                                     }

                                    $('#serviceListTable tr.loadmorerow').before('<tr><td class="checkbox"><input class="list_tsid_check" type="hidden" name="service_tsid[]" id="serviceTsId_'+value.service_id+'" value="'+value.ts_id+'"><input class="list_check" type="checkbox" name="serviceId[]" id="serviceId_'+value.service_id+'" value="'+value.service_id+'" ><label for="serviceId_'+value.service_id+'"></label></td><td class="wdt25per">'+value.ts_id+'-'+value.service_name+'</td><td class="wdt20per">'+value.service_types+' </td><td class="wdt18per">'+value.region_name+' </td> <td class="wdt18per">'+value.service_status+'</td><td class="wdt11per">'+value.margin+'%</td></tr>');


                                });

                                if(data.total_pages > 1) {   
                                    poststr = $( '#frm_search' ).serialize();
                                    current_page = current_page + 1;
                                    $(".loadmore").html('<a class= "btn-loadmore" href="javascript:;" onClick="getMoreResults(\'' + poststr + '\','+current_page +')">load more</a>');
                                } else {
                                    $(".loadmore").html('');
                                }


                            }else{
                            alert('else');
                             /*   			
                             proceedResult(data,'first');  
                             */
                            }



                    },
                    error: function() {
                            alert( 'AJAX Error' );
                            //$( '#results .sort' ).html( '' );
                    }
            });
            
 }
        
 jQuery(document).ready(function ($) {       
        $("#frm_list").on('click', "input.list_check", function () {
            $this = $(this);
            var len_list = $(".list_check:checked").length;            
//            if(len_list > 1) {
//               $('.list_check').prop('checked', false); 
//               $this.prop('checked', true);
//               
//            }  
            $('#selected_service_id').val($this.val());
            $('#selected_service_tsid').val($this.siblings('input.list_tsid_check').val());
            
        });
        
        $(".btn-submit").on('click', function () {
            var len_list = $(".list_check:checked").length;            
            if(len_list > 1) {
                alert('Only one selection is allowed');
                $('.list_check').prop('checked', false);
                $('#selected_service_id').val('');
                $('#selected_service_tsid').val('');
                return;
            }
            $('#frm_list').submit();
        });

        $(".btn-loadmore").on('click', function () {
            //alert('hii');
        });
        
        $(".btn-apply-to-all").on('click', function () {
            var current_page = 1;
            loadServiceList('',current_page,true);
        });
        
        $(".btn-search").on('click', function () {
            //$('#frm_search').submit();           
            var current_page = 1;
            loadServiceList('',current_page);
        });
        
        
        
 }); 
 
 
</script>
@stop 
@stop

