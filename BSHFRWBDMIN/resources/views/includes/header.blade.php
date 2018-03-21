<header class="main-header">
			<!-- Logo -->
			<a href="{{url('dashboard')}}" class="logo"> <!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-lg"><img alt="Surgcase" src="{{asset('img/logo.png')}}" class="img-responsive"></span>
			</a>

			<!-- Header Navbar -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- User Account Menu -->
						<li class="dropdown user user-menu">
							<!-- Menu Toggle Button --> <a href="#" class="dropdown-toggle"
							data-toggle="dropdown"> <!-- The user image in the navbar-->
								<img src="{{asset('img/default.png')}}" class="user-image"
								alt="User Image" /> <!-- hidden-xs hides the username on small devices so only the image appears. -->
								<span class="hidden-xs">Hi,Welcome</span><i class="fa fa-angle-down pull-right" style="margin: 3px 7px;"></i>
						</a>
							<ul class="dropdown-menu">
								<li><a href="{{url('user/logout')}}"><i class='glyphicon glyphicon-off'></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
