@extends('layouts.default')
@section('title') Dashboard @stop
<link rel="stylesheet" href="{{ URL::asset('assets/css/sb-admin.css') }}">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Dashboard</h1>			
		</section>

		<section class="content">
			<div class="box box-info">
			<div class="box-header with-border">				
				
			</div>
			<div class="box-body">				
				<div class="">
					<div class="col-md-12" style="text-align: center; margin-left: 2%;">
				        <div class="col-xl-3 col-sm-6 mb-3 col-md-6">
				          <div class="card text-white bg-primary o-hidden h-100">
				            <div class="card-body">
				              <div class="mr-5">{{count($appUsers)}}</div>
				            </div>
				            <div class="card-footer text-white clearfix small z-1" >
				              <span class="float-left">Total number of APP Users</span>
				              
				            </div>
				          </div>
				        </div>

				        <div class="col-xl-3 col-sm-6 mb-3 col-md-6">
				          <div class="card text-white bg-warning o-hidden h-100">
				            <div class="card-body">
				              <div class="mr-5">{{count($businessUsers)}}</div>
				            </div>
				            <div class="card-footer text-white clearfix small z-1" >
				              <span class="float-left">Total number of Business Account</span>				              
				            </div>
				          </div>
				        </div>
				        <div class="col-xl-3 col-sm-6 mb-3 col-md-6">
				          <div class="card text-white bg-success o-hidden h-100">
				            <div class="card-body">
				              <div class="mr-5">{{count($adUsers)}}</div>
				            </div>
				            <div class="card-footer text-white clearfix small z-1" >
				              <span class="float-left">Total number of AD Account</span>
				              
				            </div>
				          </div>
				        </div>
				        <div class="col-xl-3 col-sm-6 mb-3 col-md-6">
				          <div class="card text-white bg-danger o-hidden h-100">
				            <div class="card-body">
				              <div class="mr-5">{{count($categories)}}</div>
				            </div>
				            <div class="card-footer text-white clearfix small z-1" >
				              <span class="float-left">Total number of Categories</span>
				              
				            </div>
				          </div>
				        </div>
				    </div>
				    <div style="clear: both;height:50px;"></div>
				    <canvas id="myChart"  width="300" height="100"></canvas>
<script>
  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: [<?php echo $dates; ?>],
          datasets: [{
              label: 'No.of Users Registered',
              data: [{{$usercount}}],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255,99,132,1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });
</script>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</section>
	</div>
@endsection