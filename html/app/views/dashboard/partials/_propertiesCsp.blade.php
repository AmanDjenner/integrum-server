<div class="panel panel-default" style="min-height:250px;">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle fa-fw"></i><span id='csp-control-db-name' ></span> <i id="detail-refresh-link" class="fa fa-sync pull-right" style="cursor:pointer"></i></h3>
    </div>
    <div class="panel-body">
        <div class="list-group">
            <a href="#" class="list-group-item">
                <span id="csp-control-db-type" class="badge"></span>
                <i class="fa fa-fw fa-align-left"></i> {[ ucfirst(Lang::get('content.type')) ]}
            </a>
            <a href="#" class="list-group-item">
                <span id="csp-control-db-level" class="badge"></span>
                <i class="fa fa-fw fa-align-left"></i> {[ ucfirst(Lang::get('content.login-role')) ]}
            </a>
<!--            <a href="#" class="list-group-item">
                <span id="csp-control-db-version" class="badge"></span>
                <i class="fa fa-fw fa-calendar"></i> {[ ucfirst(Lang::get('content.version')) ]}
            </a>
-->			
            <ul class="nav nav-pills nav-justified list-group-item">
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.fire')) ]}">
                        <i class="fa fa-fw fa-bell"></i>
                        <div id='csp-diode-fire'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.fault')) ]}">
                        <i class="fa fa-fw fa-exclamation-triangle"></i>
                        <div id='csp-diode-trouble'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.blocked')) ]}">
                        <i class="fa fa-fw fa-lock"></i>
                        <div id='csp-diode-blocked'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.test')) ]}">
                        <i class="fa fa-fw fa-user-md"></i>
                        <div id='csp-diode-test'></div>
                    </button>
                </li>
				<li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.delayed')) ]}">
                        <i class="fa fa-fw fa-hourglass-end"></i>
                        <div id='csp-diode-delay'></div>
                    </button>
                </li>
				<li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('content.noConnection')) ]}">
                        <i class="fa fa-fw fa-globe-africa"></i>
                        <div id='csp-diode-offline'></div>
                    </button>
                </li>
			</ul>

            <ul class="nav nav-pills nav-justified list-group-item">
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.powerfault')) ]}">
                        <i class="fa fa-fw fa-battery-half"></i>
                        <div id='csp-diode-powerfault'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.auxfault')) ]}">
                        <i class="fa fa-fw fa-sign-in-alt"></i>
                        <div id='csp-diode-auxfault'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.systemfault')) ]}">
                        <i class="fa fa-fw fa-rocket"></i>
                        <div id='csp-diode-systemfault'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.silenced')) ]}">
                        <i class="fa fa-fw fa-volume-off"></i>
                        <div id='csp-diode-silenced'></div>
                    </button>
                </li>
<!--                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.auxfault')) ]}">
                        <i class="fa fa-fw fa-sign-in-alt"></i>
                        <div id='csp-diode-txfault'></div>
                    </button>
                </li>				-->
            </ul>
            <ul class="nav nav-pills nav-justified list-group-item">
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.txfire')) ]}">
                        <i class="fa fa-fw fa-exchange"></i>
                        <i class="fa fa-fw fa-bell"></i>
                        <div id='csp-diode-txfire'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('csp.txfault')) ]}">
                        <i class="fa fa-fw fa-exchange"></i>
                        <i class="fa fa-fw fa-exclamation-triangle"></i>
                        <div id='csp-diode-txfault'></div>
                    </button>
                </li>
            </ul>			<!--
            <a id='csp-a-db-structure' href="#" target="integrum" class="btn btn-primary btn-block" role="button">{[ Lang::get('content.structure') ]}</a> -->
        </div>

    </div>
</div>