<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle fa-fw"></i><span id='control-db-name' ></span> </h3>
    </div>
    <div class="panel-body">
        <div class="list-group">
            <a href="#" class="list-group-item">
                <span id="control-db-type" class="badge"></span>
                <i class="fa fa-fw fa-align-left"></i> {[ ucfirst(Lang::get('content.type')) ]}
            </a>
            <a href="#" class="list-group-item">
                <span id="control-db-version" class="badge"></span>
                <i class="fa fa-fw fa-calendar"></i> {[ ucfirst(Lang::get('content.version')) ]}
            </a>
            <ul class="nav nav-pills nav-justified list-group-item">
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('content.alarm')) ]}">
                        <i class="fa fa-fw fa-bell"></i>
                        <div id='diode-1'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('content.trouble')) ]}">
                        <i class="fa fa-fw fa-exclamation-triangle"></i>
                        <div id='diode-2'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('content.armed')) ]}">
                        <i class="fa fa-fw fa-eye"></i>
                        <div id='diode-3'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('content.service')) ]}">
                        <i class="fa fa-fw fa-wrench"></i>
                        <div id='diode-4'></div>
                    </button>
                </li>
                <li role="presentation">
                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get('content.noConnection')) ]}">
                        <i class="fa fa-fw fa-globe-africa"></i>
                        <div id='diode-5'></div>
                    </button>
                </li>
            </ul>
            <a id='a-db-structure' href="#" target="integrum" class="btn btn-primary btn-block" role="button">{[ Lang::get('content.structure') ]}</a>
        </div>

    </div>
</div>