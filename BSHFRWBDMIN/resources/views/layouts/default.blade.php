<!DOCTYPE>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

		<link rel="icon" href="{{ URL::asset('assets/img/bushfirelogo1.png') }}"/>
		<title>
			@yield('title')
		</title>

		<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		
		<!-- <link href="" rel="stylesheet" type="text/css" /> -->
		<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ URL::asset('assets/css/adminstyle.css') }}" rel="stylesheet" type="text/css" />
		
		<link href="{{ URL::asset('assets/css/skin-red.min.css') }}" rel="stylesheet"	type="text/css" />
		<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap3-wysihtml5.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datetimepicker.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker.css') }}">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		    <![endif]-->

<!--                DataTables css -  Start-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
<!--                DataTables css -  End-->

		<script src="{{ URL::asset('assets/js/jquery/jQuery-2.1.4.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/jquery/jquery-ui-1.10.3.min.js') }}"	type="text/javascript"></script>
	   <!--<script src="{{ URL::asset('assets/js/jquery/jquery-1.12.4.js') }}"	type="text/javascript"></script>-->
	    <script src="{{ URL::asset('assets/js/jquery/jquery.dataTables.min.js') }}"	type="text/javascript"></script>
	     <script src="{{ URL::asset('assets/js/jquery/dataTables.bootstrap.min.js') }}"	type="text/javascript"></script>
		
		
		
		<script type="text/javascript">
			var baseUrl = "{{ URL::to('/') }}";
			$(function () {
				$(".textarea").wysihtml5();
			});
                        
                        var lengthMenu = [[25, 50,100, -1], [25, 50,100, "All"]];
                        var DefaultDisplayLength = 25;
                        
                        var lengthMenu_modal = [[5,10,25, 50,100, -1], [5,10,25, 50,100, "All"]];
                        var DefaultDisplayLength_modal =  5;
		</script>
		<script src="{{ URL::asset('assets/js/bootstrap/bootstrap3-wysihtml5.all.js') }}"></script>
		<script src="{{ URL::asset('assets/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/app.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/common.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/bootstrap/moment-with-locales.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/bootstrap/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/bootstrap/bootstrap-datepicker.js') }}" type="text/javascript"></script>
		
		<script src="{{ URL::asset('assets/js/jquery.MultiFile.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/broadcast_users.js') }}" type="text/javascript"></script>

                         
                <!--                DataTables Js -  Start-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
<!--                DataTables Js -  End-->

		<style type="text/css">
		.main-header .logo, .main-header .logo span {
			height: 65px;
		}
		.logo-lg img{
			width: 60px;
		}
		.main-sidebar{
			margin-top: 15px;
		}

		</style>
				
				<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
				<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
	</head>
	<body class="skin-green">
		<div class="">
			@include('layouts.header')
	
			@yield('content')
			
			@include('layouts.footer')
		</div>
		<div class="modal fade" id="confirm-delete" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Confirmation</h4>
					</div>
					<div class="modal-body">Are you sure you want to delete?</div>
					<div class="modal-footer">
						<a class="btn btn-danger btn-ok" id="btn-ok1">Delete</a> <a
							class="btn btn-default" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="loading" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">		 
					<img src="{{ url('assets/img/wait.gif') }}">
                   </div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="confirm-logout" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Confirmation</h4>
					</div>
					<div class="modal-body">Are you sure you want to logout?</div>
					<div class="modal-footer">
						<a class="btn btn-danger btn-ok">Ok</a> <a
							class="btn btn-default" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="confirm-change" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Confirmation</h4>
					</div>
					<div class="modal-body">Are you sure you want to Proceed?</div>
					<div class="modal-footer">
						<a class="btn btn-danger btn-yes">Yes</a> <a
							class="btn btn-default" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
