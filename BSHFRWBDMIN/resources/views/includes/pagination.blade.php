<!-- app/views/includes/pagination.blade.php -->
<div class="pagination clearfix">
   
       @if($data->lastPage() > 1)
			<ul class="pagination">
        		<?php 
        		$perSide = 3;
        		$currentPage = $data->currentPage();
                $leftSide = $tempLeft = $currentPage - $perSide;
                $rightSide = $currentPage + $perSide;
                
                if($rightSide >= $data->lastPage()){
                	$leftSide += $data->lastPage() - $rightSide;
                }
                
                if($tempLeft <= 0){
                	$rightSide = $rightSide - ($tempLeft-1);
                }
                $queryString='';
                if(\Request::has('q')!=''){
                	$queryString="q=".\Request::get('q')."&";
                }
                if(\Request::has('query')!=''){
                	$queryString="query=".\Request::get('query')."&";
                }
                if(\Request::has('is_active')!=''){
                	$queryString.="is_active=".\Request::get('is_active')."&";
                }
                if(\Request::has('continent_id')){
                  $queryString.="continent_id=".\Request::get('continent_id')."&";
                }
               	$queryString.='page=';
               
                ?>
        		
        	    @if($data->currentPage()!= 1)
        	      <li class="prev"><a class="page" href="{{URL::current()}}?{{$queryString}}{{$data->currentPage()-1}}"><span>&larr;</span></a></li>
    	        @else
    	           <li class="prev disabled"><a href="javascript::void(0);" ><span>&larr;</span></a></li>
        	    @endif
        	    
        	    @if($leftSide > 1)
        	      <li><span>....</span></li>
        	    @endif
        		@for($i = 1; $i <= $data->lastPage(); $i++)
        	      @if($i>= $leftSide && $i<=$rightSide)
            		  @if($i == $data->currentPage())
                          <li class="active"><span class="page active">{{ $i }}</span></li>
            		  @else
            		      <li><a href="{{URL::current()}}?{{$queryString}}{{$i}}" class="page">{{ $i }}</a></li>
        		      @endif
        		      
        	      @endif
        		@endfor
        		@if($rightSide < $data->lastPage())
        	      <li><span>....</span></li>
        	    @endif
        		@if($data->currentPage() != $data->lastPage())
        	      <li class="next"><a class="page" href="{{URL::current()}}?{{$queryString}}{{ $data->currentPage()+1 }}">&rarr;</a></li>
        	    @else
        	       <li class="next last disabled"><a href="javascript::void(0);">&rarr;</a></li>
        	    @endif
        	</ul>
    	@endif
		<input type="hidden" name="page" id="page" value="{{\Request::get('page')}}"/>
</div>

