<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>@yield('title')Talismanfly</title>
<meta name="viewport" content="width=1170,initial-scale=1">
<!-- Bootstrap 3.3.4 -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"
	type="text/css" />
<!-- Font Awesome Icons -->
<link
	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"
	rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" />
<!-- iCheck -->
<!-- <link href="plugins/iCheck/square/blue.css" rel="stylesheet"
	type="text/css" /> -->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
	<div class="login-box">
		<div class="login-logo">
			<i></i>
		</div>
		<!-- /.login-logo -->
		@yield('content')
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->
</body>
</html>