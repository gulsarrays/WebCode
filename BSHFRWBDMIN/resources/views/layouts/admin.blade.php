<!DOCTYPE html>
<html>
<head>
@include('includes.style')
<script type="text/javascript">
	 var baseUrl="{{URL::to('/')}}";
</script>
<link rel="shortcut icon" href="{{asset('img/fav.png')}}">
<script src="{{asset('js/jquery-2.1.3.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>


<script type="text/javascript" src="{{asset('js/beep.js')}}"></script>
<script type="text/javascript" src="{{asset('js/hmac-sha1.js')}}"></script>
<script src="https://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/enc-base64-min.js"></script>
<script type="text/javascript" src="{{asset('js/CryptoJS.js')}}"></script>
<script type="text/javascript" src="{{asset('js/compassitesFly.js')}}"></script>
<script type="text/javascript" src="{{asset('js/customchat.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
@yield('scripts')
</head>
<body class="skin-green">
	<div class="">
		@include('includes.header')
		@include('includes.sidebar')
		@yield('content')
		<div class="modal fade" id="confirm-delete" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Confirmation</h4>
					</div>
					<div class="modal-body">Are you sure you want to send job?</div>
					<div class="modal-footer">
						<a class="btn btn-danger btn-ok">Okay</a> <a
							class="btn btn-default" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		@include('includes.footer')
	</div>
</body>
</html>