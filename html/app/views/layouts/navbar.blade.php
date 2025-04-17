        <nav class="navbar navbar-inverse navbar-fixed-top"  id="ds-a-menu">
@if ($showDropDownArrow)
		<span id="navbar-arrow-dropdown"><i class="fa fa-caret-down yellowTxt"></i></span>
@endif	
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#integrumNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/" >
                        <img class="logo" src="/img/logo_integrum_navbar.svg" width="177" alt="INTEGRUM logo" />
                    </a>
@if($showRegions)
                    <a id="tree-toggle" class="hidden-xs" title="{[ Lang::get('content.hierarchy')]}"><i  class="fa fa-sitemap" style="cursor:default;"></i></a>
@endif	
                </div><!-- navbar-header -->

                <div class="collapse navbar-collapse" id="integrumNavbar">

                    <ul class="nav navbar-nav">
@if($showUsers)
                        <li role="presentation" {[ (Request::is('users*') ? 'class="active"' : '') ]}><a href="/users/"><span class="fa-stack"><i class="fa fa-stack-1x fa-user" id="user-icon-1"></i><span  id="user-icon-2" ><i class="fa fa-stack-1x fa-user"></i></span></span><span class="hidden-sm"> {[ Lang::get('content.users') ]}</span></a></li>
@endif	
@if($showPanels)
                        <li role="presentation" {[ (Request::is('control*') ? 'class="active"' : '') ]}><a href="/control/"><i class="fa fa-calculator"></i><span class="hidden-sm"> {[ Lang::get('content.panels') ]}</span></a></li>
@endif	
@if($showEvents)
                        <li role="presentation" {[ (Request::is('event*') ? 'class="active"' : '') ]}><a href="/event"><i class="fa fa-file-alt"></i><span class="hidden-sm"> {[ Lang::get('content.events') ]}</span></a></li>
@endif
                        <li role="presentation" class="hidden-sm hidden-md hidden-lg"><a id="tree-togglemenu"><i class="fa fa-sitemap"></i> {[ Lang::get('content.hierarchy') ]}</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
@if($showDashboard)
                        <li role="presentation" {[ (Request::is('dashboard*') ? 'class="active"' : '') ]}><a href="/dashboard"><i class="fa fa-tachometer-alt" title="{[ Lang::get('content.dashboard')]}"></i><span class="hidden-sm hidden-md hidden-lg">{[ Lang::get('content.dashboard') ]}</span></a></li>
@endif
@if($admProfile||$admRegions||$admRoles)
					  <li role="presentation" {[ (Request::is('admin*')||Request::is('hierarchy*') ? 'class="dropdown active"' : 'class="dropdown"') ]} title="{[ Lang::get('content.user-settings')]}">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i id="mainMenuSettings" class="fa fa-cog"></i><span class="hidden-sm hidden-md hidden-lg">{[ Lang::get('content.user-settings') ]}</span>
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li><a id="mainMenuStatus" href="/status"><i class="fa fa-info-circle hidden-sm hidden-md hidden-lg"></i>{[ Lang::get('content.status') ]}</a></li>
						  <li class="divider"></li>
@if($admProfile)
						  <li><a id="mainMenuManageProfile" href="/admin/profile"><i class="fa fa-check-circle hidden-sm hidden-md hidden-lg"></i>{[ Lang::get('content.profiles') ]}</a></li>
@endif
@if($admRoles)
						  <li><a id="mainMenuManageRoles" href="/admin/roles"><i class="fa fa-check-circle hidden-sm hidden-md hidden-lg"></i>{[ Lang::get('content.login-roles') ]}</a></li>
@endif
@if($admRegions)
						  <li><a id="mainMenuManageRegions" href="/hierarchy#edit"><i class="fa fa-edit hidden-sm hidden-md hidden-lg"></i>{[Lang::get('content.settings')]}</a></li>
@endif	
@if($admEvents)
                          <li><a id="mainMenuEventSettings" href="{[route('event.management')]}"><i class="fa fa-archive hidden-sm hidden-md hidden-lg"></i>{[Lang::get('content.event-settings')]}</a></li>
@endif		 
     						</ul>
					  </li>
@else
                        <li><a href="/status"><i class="fa fa-info-circle" title="{[ Lang::get('content.status') ]}"></i><span class="hidden-sm hidden-md hidden-lg">{[ Lang::get('content.status') ]}</span></a></li>
@endif	
                        <li class="divider"></li>
						<li><a href="#" id="hlp-button"><i class="fa fa-question-circle" ></i><span class="hidden-sm hidden-md hidden-lg">{[ Lang::get('content.help') ]}</span></a></li>
						<li><a id="mainMenuCurrUser" href="/users/{[Session::get('idUser')]}/edit#user-2"><i class="fa fa-user fa-fw" title="{[ Lang::get('content.user-settings') ]}"></i><span class="hidden-sm hidden-md hidden-lg">{[ Lang::get('content.user') ]}: </span><span class="hidden-sm">{[ Session::get('nameUser') ]}</span></a></li>
						<li><a id="mainMenuLogout" href="/logout"><i class="fa fa-sign-out-alt" title="{[ Lang::get('content.logout') ]}"></i><span class="hidden-sm hidden-md hidden-lg">{[ Lang::get('content.logout') ]}</span></a></li>
                    </ul>
                </div><!-- navbar collapse -->
            </div><!-- container -->
        </nav>
@if ($showDropDownArrow)
        <div id="navbar-backdrop" class=""></div>
@endif	
