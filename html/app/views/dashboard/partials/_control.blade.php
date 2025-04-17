<div class="panel panel-default">
    <div class="panel-heading">
            <script type="text/javascript">
            document.integrumEventShowDialog={[$showEventDialog?1:0]};
            document.integrumEventShowComments={[$eventComments?1:0]};
            </script>
        <h3 class="panel-title"><i class="fa fa-long-arrow-alt-right fa-fw"></i> <span id="name" style="cursor: pointer;">INTEGRUM [{[$currentHierarchy->getName()]}]</span>
        <i id="overall-refresh-link" class="fa fa-sync pull-right" style="margin-left:15px;cursor:pointer"></i>
            @if ($showEventDialog)
                <span class=" pull-right">
                    <span id="eventCountBadge" style="font-size:18px;color:#666;cursor:pointer;" title="{[Lang::get('content.comment-queue')]}"><i class="fa fa-file-alt"></i>  <span id="eventCountBadgeCount">0</span></span>&nbsp;
                    <span id="myEventCountBadge" style="font-size:18px;color:#666;cursor:pointer;" title="{[Lang::get('content.comment-my-queue')]}"><i class="fa fa-user"></i>  <span id="myEventCountBadgeCount">0</span></span>
                </span>
                    {[ Form::hidden('_token', csrf_token()) ]}
            @endif	
        </h3>
    </div>
    <div class="panel-body" style="padding:10px;">
        <ul class="nav nav-pills nav-justified" id="integrum-info">
        @foreach ($buttons as $btn)
            <li role="presentation">
                <div class="btn-group">                
                    <span class="btn btn-sm btn-control-db {[ $btn["class"] ]}" href="#" data-level="{[$btn["level"] or 1000 ]}" data-system="{[ $btn["system"] ]}" data-type="{[ $btn["type"] ]}" id="btn-control-db-{[ $btn["id"] ]}" data-toggle="tooltip" data-placement="top" title="{[ ucfirst(Lang::get($btn["title"])) ]}">
                        <i class="fa {[ $btn["icon"] ]}"></i>
                        <div class="huge-db" id="huge-db-{[ $btn["id"] ]}">0</div>
                    </span>
                    <span class="btn btn-sm hideChart {[ $btn["class"] ]}" data-datasetlabel='{[ $btn["id"] ]}' style="float: right;"><i class="fa fa-eye"></i></span>
                </div>
            </li>
        @endforeach
        </ul>
        <div id="integrum-area-chart"></div>
    </div>
</div>