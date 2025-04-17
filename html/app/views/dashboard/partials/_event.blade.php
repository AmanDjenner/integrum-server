<div class="col-lg-4">
    <div class="panel-wrapper h1-3">
        <div class="panel panel-default">
            <div class="panel-heading panel-event">
                <h3 class="panel-title"><i class="fa fa-clock fa-fw"></i>{[ $title ]}</id><i id="event-refresh-link-{[ $id ]}" data-type="{[ $id ]}" class="dashboard-event-refresh fa fa-sync pull-right" style="cursor:pointer"></i>
                <span class="mr-1x pull-right badge event-refresh-interval" title="{[ Lang::get('content.event-refresh-interval') ]}" data-idx="0">0.5</span>
                <img src="/css/select2-spinner.gif" class="hidden mr-1x pull-right ev-spinner" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.event-archive') ]}"></h3>
            </div>
            <div class="panel-body-wrapper">
                <table id="table-event-{[ $id ]}" class="dashboard-event table table-condensed table-hover table-event" data-type="{[ $id ]}" data-toggle="table" >
                    <thead id='thead-event-{[ $id ]}' class="dashboard-event-head">
                        <tr class="tabela-head">
                            <th data-field="date">Data i czas</th>
                            <th data-field="description">Źródło</th>
                            <th data-field="type">Zdarzenie</th>
                            <th data-field="user">Użytkownik</th>
                        </tr>
                    </thead>
                    <tbody id='eventsTable-db-{[ $id ]}'>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>