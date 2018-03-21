<header>
	<nav class="navbar navbar-default navbar-block">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     	<a  href="{{url((auth()->user()->user_type==1 ? 'dashboard' : 'dashboard'))}}" class="logo">
		<span class="logo-lg"><img alt="Compass" src="{{ URL::asset('assets/img/bushfirelogo1.png') }}" class="img-responsive"></span>
	</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-custom">

      	@if(auth()->user()->user_type == 1)
	      	<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/dashboard' ) >= 1)active @endif"><a href="{{ url('dashboard') }}"><i class='fa fa-dashboard'></i><span>Dashboard</span></a></li>

			<li class="treeview dropdown dropdown-custom 
			@if( substr_count ($_SERVER['REQUEST_URI'], 'other/users' ) >= 1 || 
			substr_count ($_SERVER['REQUEST_URI'], 'sadmin' ) >= 1 || 
			substr_count ($_SERVER['REQUEST_URI'], 'adUser' ) >= 1 || 
			substr_count ($_SERVER['REQUEST_URI'], 'app-users' ) >= 1 )active @endif
			">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-users"></i> All Users<span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            	@permission('user-list')
					<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], 'other/users' ) >= 1)active @endif"><a href="{{ url('other/users') }}"><i class='fa fa-user-secret'></i><span>Bushfire Admin</span></a></li>
					@endpermission
					@permission('list-business-users')
					<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/sadmin' ) >= 1)active @endif"><a href="{{ url('sadmin') }}"><i class='fa fa-user-circle'></i><span>Business Account</span></a></li>
					@endpermission
					@permission('list-ad-users')
					<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/adUser' ) >= 1)active @endif"><a href="{{ url('adUser') }}"><i class='fa fa-camera-retro'></i><span>Ad Account</span></a></li>
					@endpermission
					<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/app-users' ) >= 1)active @endif"><a href="{{ route('get:users') }}"><i class='fa fa-group'></i><span>App Users</span></a></li>
	          </ul>
        	</li>
        	
         	@permission('role-list')
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/roles' ) >= 1)active @endif"><a href="{{ url('roles') }}"><i class='fa fa-vcard-o'></i><span>Roles</span></a></li>
			@endpermission
			<!-- @permission('permission-list')
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/permission' ) >= 1)active @endif"><a href="{{ url('permission') }}"><i class='fa fa-list'></i><span>Permission</span></a></li>
			@endpermission -->

			<!-- <li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/others' ) >= 1)active @endif"><a href="{{ url('others') }}"><i class='fa fa-plus-square'></i><span>Others</span></a></li> -->
			
			@permission('settings')
				@if(CustomHelper::checkRoute(Route::getCurrentRoute()->getPath(),'settings'))
					<li class="treeview dropdown dropdown-custom  
					@if( substr_count ($_SERVER['REQUEST_URI'], 'categories' ) >= 1 || 
					substr_count ($_SERVER['REQUEST_URI'], 'ageGroups' ) >= 1 || 
					substr_count ($_SERVER['REQUEST_URI'], 'gender' ) >= 1 || 
					substr_count ($_SERVER['REQUEST_URI'], '/settings' ) >= 1)active @endif">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-cog'></i>Settings <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/settings' ) >= 1)active @endif"><a href="{{ url('settings') }}"><i class='fa fa-wrench'></i><span>General</span></a></li>
			            	@permission('view-categories')
							<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/categories' ) >= 1)active @endif"><a href="{{ url('categories') }}"><i class='fa fa-cubes'></i><span>Categories</span></a></li>
							@endpermission

							@permission('view-age-groups')
							<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/ageGroups' ) >= 1)active @endif"><a href="{{ url('ageGroups') }}"><i class='fa fa-object-ungroup'></i><span>AgeGroups</span></a></li>
							@endpermission

							@permission('view-gender')
							<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/gender' ) >= 1)active @endif"><a href="{{ url('gender') }}"><i class='fa fa-venus-mars'></i><span>Gender</span></a></li>
							@endpermission
	          			</ul>
					</li>
				@endif
			@endpermission

			@permission('view-audits')
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/audits' ) >= 1)active @endif"><a href="{{ url('audits') }}"><i class='fa fa-tasks'></i><span>Audit</span></a></li>
			@endpermission

			@permission('view-channel-content-reports')
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/reports' ) >= 1)active @endif"><a href="{{ url('reports') }}"><i class='fa fa-tasks'></i><span>Report</span></a></li>
			@endpermission

			@permission('content-repo')
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/content-repo' ) >= 1)active @endif"><a href="{{ url('content-repo') }}"><i class='fa fa-tasks'></i><span>Content Repo</span></a></li>
			@endpermission
                        
			@permission('content-repo')
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/emojis' ) >= 1)active @endif"><a href="{{ url('emojis') }}"><i class='fa fa-tasks'></i><span>Emojis</span></a></li>
			@endpermission
		
		@elseif(auth()->user()->hasRole('pj'))
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/pj' ) >= 1)active @endif"><a href="{{ url('pj') }}"><i class='fa fa-tasks'></i><span>Home</span></a></li>

		@else
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/stringer' ) >= 1)active @endif"><a href="{{ url('stringer') }}"><i class='fa fa-tasks'></i><span>Home</span></a></li>

		@endif

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="treeview dropdown dropdown-custom
        @if( substr_count ($_SERVER['REQUEST_URI'], '/profile/edit/' ) >= 1 || 
			substr_count ($_SERVER['REQUEST_URI'], '/change-password' ) >= 1)active @endif
        ">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 16px;">
				<i class="fa fa-user-circle"></i>{{ ucwords(auth()->user()->username) }} <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/profile/edit/' ) >= 1)active @endif"><a href="{{ url('profile/edit/'.auth()->user()->id) }}"><i class='fa fa-user'></i> <span>Profile</span></a></li>
					<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], '/change-password' ) >= 1)active @endif"><a href="{{ url('change-password') }}"><i class='fa fa-key'></i><span>Change Password</span></a></li>	
					<li class="treeview"><a data-href="{{ URL::route('get:logout') }}" class= "log-out" id="log-out"><i class='glyphicon glyphicon-off' data-target="#confirm-logout"></i> <span>Logout</span></a></li> 
				</ul>
		</li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</header>
<style type="text/css">
.sidebar-menu li ul li{
	text-indent: 20px;
    line-height: 40px;
}
.sidebar-menu li ul li.active{
    color: #fff;
    background: #323265;
    border-left-color: #f7a100;
}
</style>