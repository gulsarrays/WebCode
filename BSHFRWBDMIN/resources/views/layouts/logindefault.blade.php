<!DOCTYPE>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

		<link rel="icon" href="{{ URL::asset('assets/img/bushfirelogo1.png') }}"/>
		<title>
			Bushfire - Web
		</title>
		
		<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ URL::asset('assets/css/adminstyle.css') }}" rel="stylesheet" type="text/css" />
		
		<link href="{{ URL::asset('assets/css/skin-red.min.css') }}" rel="stylesheet"	type="text/css" />
		<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap3-wysihtml5.min.css') }}">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		    <![endif]-->
		
		
		<script src="{{ URL::asset('assets/js/jquery/jQuery-2.1.4.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/jquery/jquery-ui-1.10.3.min.js') }}"	type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/bootstrap/bootstrap3-wysihtml5.all.min.js') }}"></script>
		<script>
	      $(function () {
	        $(".textarea").wysihtml5();
	      });
		</script>
		<script src="{{ URL::asset('assets/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('assets/js/app.min.js') }}" type="text/javascript"></script>
			
	</head>
	<body class="login-page">
		<div class="login-box">
			<div class="login-logo">
				<i></i>
			</div>
			@yield('content')
		</div>
	</body>
</html>
