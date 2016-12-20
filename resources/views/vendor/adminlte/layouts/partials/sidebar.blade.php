<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		@if (! Auth::guest())
			<div class="user-panel">
				<div class="pull-left image">
					<img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
				</div>
				<div class="pull-left info">
					<p>{{ Auth::user()->name }}</p>
					<!-- Status -->
					<a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
				</div>
			</div>
		@endif

		<!-- search form (Optional) -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
			  <span class="input-group-btn">
				<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
			  </span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">{{ trans('adminlte_lang::message.header') }}</li>
			<!-- Optionally, you can add icons to the links -->
			<li class="active"><a href="{{ url('/employee') }}"><i class='fa fa-black-tie'></i> <span>{{ trans('adminlte_lang::message.employeers') }}</span></a></li>
			<li><a href="{{ url('home') }}"><i class='fa fa-users'></i> <span>{{ trans('adminlte_lang::message.clients') }}</span></a></li>
			<li><a href="#"><i class='fa fa-newspaper-o'></i> <span>{{ trans('adminlte_lang::message.review') }}</span></a></li>
			<li><a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('adminlte_lang::message.stats') }}</span></a></li>
			<li><a href="#"><i class='fa fa-rub'></i> <span>{{ trans('adminlte_lang::message.finance') }}</span></a></li>
			<li><a href="#"><i class='fa fa-archive'></i> <span>{{ trans('adminlte_lang::message.stock') }}</span></a></li>
			<li><a href="#"><i class='fa fa-calendar-check-o'></i> <span>{{ trans('adminlte_lang::message.registration') }}</span></a></li>
			<li><a href="#"><i class='fa fa-cogs'></i> <span>{{ trans('adminlte_lang::message.settings') }}</span></a></li>
			<li><a href="#"><i class='fa fa-credit-card'></i> <span>{{ trans('adminlte_lang::message.balance') }}</span></a></li>
			<li><a href="#"><i class='fa fa-book'></i> <span>{{ trans('adminlte_lang::message.backoffice') }}</span></a></li>
			<li><a href="#"><i class='fa fa-user'></i> <span>{{ trans('adminlte_lang::message.profile') }}</span></a></li>
			<li><a href="#"><i class='fa fa-question'></i> <span>{{ trans('adminlte_lang::message.support') }}</span></a></li>

			{{-- <li class="treeview">
				<a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.multilevel') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
					<li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
				</ul>
			</li> --}}
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>
