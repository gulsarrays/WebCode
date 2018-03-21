<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<!-- Optionally, you can add icons to the links -->
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], 'users' ) >= 1) active @endif"><a
				href="{{url('users')}}"><i class='fa fa-briefcase'></i><span>
						Manage Contacts</span></a></li>
			<li class="treeview @if( substr_count ($_SERVER['REQUEST_URI'], 'reports' ) >= 1) active  @endif"><a
				href="{{url('reports')}}"><i class='fa fa-building'></i><span>
						Manage Reports</span></a></li>
			
		</ul>
		<!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>
