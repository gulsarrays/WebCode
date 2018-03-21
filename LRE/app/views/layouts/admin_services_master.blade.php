<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>
      Service Rates
      @yield('title')
    </title>

    @include('partials.styles')
    @yield('styles')
  </head>
  
  <body>
    
    <div class="container">
      <div class="" id="alert">
      </div>
      <div class="" id="success">
      </div>

      @yield('body')
	  </div><!-- /.container -->
  </body>
   
    @include('partials.scripts')
    @yield('scripts')
</html>