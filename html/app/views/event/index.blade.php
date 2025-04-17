@extends('layouts.list', ['customButtons' =>
	'<span id="event-colors" style="display:inline;padding: 0px 12px;float:right;" class="btn btn-create-blank btn-create" data-toggle="tooltip" data-placement="bottom" title="'. Lang::get('content.event-colors') .'" ><i style="width: 25px;" class="fa fa-lg fa-paint-brush"></i></span>
	 <span id="event-condensed" style="display:inline;padding: 0px 12px;float:right;margin-right:8px;" class="btn btn-create-blank btn-create" data-toggle="tooltip" data-placement="bottom" title="'. Lang::get('content.event-condensed') .'" ><i style="width: 25px;" class="fa fa-lg fa-align-justify"></i></span>
	 <span id="event-export" style="display:inline;padding: 0px 12px;float:right;margin-right:8px;" class="btn btn-create-blank btn-create" data-toggle="tooltip" data-placement="bottom" title="'. Lang::get('content.list-getcsv') .'" ><i style="width: 25px;" class="fa fa-lg fa-upload"></i></span>
	'])

@section('listcontent')
<div class="row">
    <div class="col-sm-12" id="middle">

{[ Form::hidden('trans-comment', Lang::get('content.comment-do',['id'=>'trans-comment'])) ]}
{[ Form::hidden('trans-comment-add', Lang::get('content.comment-add',['id'=>'trans-comment-add'])) ]}
{[ Form::hidden('trans-comment-delay', Lang::get('content.comment-delay',['id'=>'trans-comment-delay'])) ]}
{[ Form::hidden('trans-comment-date', Lang::get('content.comment-date',['id'=>'trans-comment-date'])) ]}
{[ Form::hidden('trans-comment-operator', Lang::get('content.comment-operator',['id'=>'trans-comment-operator'])) ]}
{[ Form::hidden('trans-comment-descr', Lang::get('content.comment-descr',['id'=>'trans-comment-descr'])) ]}
{[ Form::hidden('trans-comment-descr-add', Lang::get('content.comment-descr-add',['id'=>'trans-comment-descr-add'])) ]}
{[ Form::hidden('trans-comment-close', Lang::get('content.comment-close',['id'=>'trans-comment-close'])) ]}
{[ Form::hidden('trans-comment-close-handling', Lang::get('content.comment-close-handling',['id'=>'trans-comment-close-handling'])) ]}
{[ Form::hidden('trans-comment-confirm', Lang::get('content.comment-confirm',['id'=>'trans-comment-confirm'])) ]}
{[ Form::hidden('trans-comment-confirm-yes', Lang::get('content.comment-confirm-yes',['id'=>'trans-comment-confirm-yes'])) ]}
{[ Form::hidden('trans-comment-confirm-no', Lang::get('content.comment-confirm-no',['id'=>'trans-comment-confirm-no'])) ]}
{[ Form::hidden('trans-comment-default', Lang::get('content.comment-default',['id'=>'trans-comment-default'])) ]}
{[ Form::hidden('trans-comment-clear-alarm', Lang::get('content.clearAlarm',['id'=>'trans-comment-clear-alarm'])) ]}
{[ Form::hidden('trans-comment-disarm', Lang::get('content.disarm',['id'=>'trans-comment-disarm'])) ]}
    
{[ Form::hidden('trans-part', Lang::get('content.partition',['id'=>'trans-part'])) ]}
{[ Form::hidden('trans-zone', Lang::get('content.zone',['id'=>'trans-zone'])) ]}
{[ Form::hidden('trans-line', Lang::get('content.line',['id'=>'trans-line'])) ]}

{[ Form::hidden('trans-date-picker-Format', Lang::get('content.datePickerFormat',['id'=>'trans-date-picker-Format'])) ]}
{[ Form::hidden('trans-date-picker-FormatSec', Lang::get('content.datePickerFormatSec'),['id'=>'trans-date-picker-FormatSec']) ]}
{[ Form::hidden('trans-date-picker-Locale', Lang::get('content.datePickerLocale',['id'=>'trans-date-picker-Locale'])) ]}
{[ Form::hidden('trans-date-picker-Today', Lang::get('content.datePickerToday',['id'=>'trans-date-picker-Today'])) ]}
{[ Form::hidden('trans-date-picker-Clear', Lang::get('content.datePickerClear',['id'=>'trans-date-picker-Clear'])) ]}
{[ Form::hidden('trans-date-picker-Close', Lang::get('content.datePickerClose',['id'=>'trans-date-picker-Close'])) ]}
{[ Form::hidden('trans-date-picker-SelectMonth', Lang::get('content.datePickerSelectMonth',['id'=>'trans-date-picker-SelectMonth'])) ]}
{[ Form::hidden('trans-date-picker-PrevMonth', Lang::get('content.datePickerPrevMonth',['id'=>'trans-date-picker-PrevMonth'])) ]}
{[ Form::hidden('trans-date-picker-NextMonth', Lang::get('content.datePickerNextMonth',['id'=>'trans-date-picker-NextMonth'])) ]}
{[ Form::hidden('trans-date-picker-SelectYear', Lang::get('content.datePickerSelectYear',['id'=>'trans-date-picker-SelectYear'])) ]}
{[ Form::hidden('trans-date-picker-PrevYear', Lang::get('content.datePickerPrevYear',['id'=>'trans-date-picker-PrevYear'])) ]}
{[ Form::hidden('trans-date-picker-NextYear', Lang::get('content.datePickerNextYear',['id'=>'trans-date-picker-NextYear'])) ]}
{[ Form::hidden('trans-date-picker-SelectDecade', Lang::get('content.datePickerSelectDecade',['id'=>'trans-date-picker-SelectDecade'])) ]}
{[ Form::hidden('trans-date-picker-PrevDecade', Lang::get('content.datePickerPrevDecade',['id'=>'trans-date-picker-PrevDecade'])) ]}
{[ Form::hidden('trans-date-picker-NextDecade', Lang::get('content.datePickerNextDecade',['id'=>'trans-date-picker-NextDecade'])) ]}
{[ Form::hidden('trans-date-picker-PrevCentury', Lang::get('content.datePickerPrevCentury',['id'=>'trans-date-picker-PrevCentury'])) ]}
{[ Form::hidden('trans-date-picker-NextCentury', Lang::get('content.datePickerNextCentury',['id'=>'trans-date-picker-NextCentury'])) ]}
{[ Form::hidden('trans-date-picker-PickHour', Lang::get('content.datePickerPickHour',['id'=>'trans-date-picker-PickHour'])) ]}
{[ Form::hidden('trans-date-picker-IncrementHour', Lang::get('content.datePickerIncrementHour',['id'=>'trans-date-picker-IncrementHour'])) ]}
{[ Form::hidden('trans-date-picker-DecrementHour', Lang::get('content.datePickerDecrementHour',['id'=>'trans-date-picker-DecrementHour'])) ]}
{[ Form::hidden('trans-date-picker-PickMinute', Lang::get('content.datePickerPickMinute',['id'=>'trans-date-picker-PickMinute'])) ]}
{[ Form::hidden('trans-date-picker-IncrementMinute', Lang::get('content.datePickerIncrementMinute',['id'=>'trans-date-picker-IncrementMinute'])) ]}
{[ Form::hidden('trans-date-picker-DecrementMinute', Lang::get('content.datePickerDecrementMinute',['id'=>'trans-date-picker-DecrementMinute'])) ]}
{[ Form::hidden('trans-date-picker-PickSecond', Lang::get('content.datePickerPickSecond',['id'=>'trans-date-picker-PickSecond'])) ]}
{[ Form::hidden('trans-date-picker-IncrementSecond', Lang::get('content.datePickerIncrementSecond',['id'=>'trans-date-picker-IncrementSecond'])) ]}
{[ Form::hidden('trans-date-picker-DecrementSecond', Lang::get('content.datePickerDecrementSecond',['id'=>'trans-date-picker-DecrementSecond'])) ]}
{[ Form::hidden('trans-date-picker-TogglePeriod', Lang::get('content.datePickerTogglePeriod',['id'=>'trans-date-picker-TogglePeriod'])) ]}
{[ Form::hidden('trans-date-picker-SelectTime', Lang::get('content.datePickerSelectTime',['id'=>'trans-date-picker-SelectTime'])) ]}

        <input type="hidden" name="currEventColor" id="currEventColor" value=""/>
        <input type="hidden" name="currEventCondensed" id="currEventCondensed" value=""/>
		<script type="text/javascript">
		document.integrumEventShowComments={[$eventComments?1:0]};
		</script>
        {[ Form::open( array(
            'route' => 'event.filtercsv',
            'method' => 'post',
            'id'=> 'form-csv'
            ) ) ]}
            <input type="hidden" name="data" id="event-list-getcsv" data-value="" >
            {[Form::close()]} 	
        {[ Form::open( array(
        'route' => 'event.create',
        'method' => 'post',
        'id' => 'form-add-setting'
        ) ) ]}
        <input type="hidden" name="idOffset" id="idOffset" value="0"/>
        <input type="hidden" name="idQueryStartIdx" id="idQueryStartIdx" />
        <input type="hidden" name="idTree" id="idTree" />
        <div class="row">
            <div class="col-sm-12 top-buffer">
                <table class="table table-hover tabela-wynik" data-toggle="table" >
                    <thead class="filter">
                        <tr class="tabela-head panel-event {[$archivePanel]}">
                            <th data-field="date" style="min-width: 52px;"><button type="button" class="btn btn-block btn-collapse" data-toggle="collapse" data-target="#eventdata" id="btn-filter-date">{[Lang::get('content.list-date')]}</button></th>
                            <th data-field="description" style="min-width: 152px;">
							{[ Form::select('controlList',[],null,[
                            'class'=>'form-control',  'id'=>'controlList','style'=>'width:100%', 'data-placeholder'=>Lang::get('content.list-source') 
							]); ]}</th>
                            <th data-field="source" style="width:80px">
                                <input type="hidden" id="sourceJSON" value="[]"/>
                                <button type="button" class="btn btn-block btn-collapse" data-toggle="collapse" data-target="#eventtype" id="btn-filter-source">{[Lang::get('content.class')]}</button>
                            </th>
                            <th data-field="type" style="min-width: 30%;">
                                <select class="form-control" name="type" id="type">
								@foreach($eventType as $type)
                                    <option class="event-list event-list{[$type['evtClass']]}" value="{[$type['id']]}">{[$type['name']]}</option>
								@endforeach
                                </select>
							</th>
                            <th data-field="user" style="min-width: 25%;">
                                <select class="form-control" name="eventUsers" id="eventUsers" data-placeholder="{[Lang::get('content.user')]}" >
								@foreach($eventUsers as $user)
                                    <option value="{[$user->id]}">{[$user->name]}</option>
								@endforeach
                                </select>
                            </th>
                            <th style="min-width: 166px;max-width: 166px;">
							    <div class="btn-group">
                                <button class="btn btn-filter form-control ml-10 no-margin-xs" id='btnFilter' type="submit"><i class="fa fa-filter"></i></button>
                                <button class="btn btn-collapse dropdown-toggle" id='btnCollapse' type="button" data-toggle="collapse" aria-haspopup="true" aria-expanded="false"><i class="fa fa-lg fa-caret-right"></i></button>
                                </div>
								<button type="button" class="btn btn-filter form-control" id="btn-filter-clear">
									<span class="fa-stack filterButton">
										<i class="fa fa-stack-1x fa-filter filterButtonIco"></i>
										<span>
											<i class="fa fa-stack-1x fa-ban filterButtonIco2"></i>
										</span>
									</span>
								</button>
                                <img src="/css/select2-spinner.gif" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.event-archive') ]}" class="ml-1x {[$archive]} ev-spinner">																
							</th>								
								
                        </tr>
                        <tr><th colspan="6" class="clear-tab">
                    <div id="eventdata" class="row collapse"><div class="col-sm-2">{[Lang::get('content.filter-date-range')]} </div>
                        <div class="col-sm-2">
                            <div class='input-group date' id='date1'>
                                <input type='text' class="form-control no-margin-xs" placeholder="{[Lang::get('content.filter-date-from')]}"/>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar-alt"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class='input-group date' id='date2'>
                                <input type='text' class="form-control no-margin-xs" placeholder="{[Lang::get('content.filter-date-to')]}"/>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar-alt"></span>
                                </span>
                            </div>
                        </div></div>
                    </th></tr>
                <tr><th colspan="6" class="clear-tab">
                    <div id="eventpanel" class="row collapse">
                        <div class="col-sm-2">{[Lang::get('content.filter-evnt-source')]}</div>
                        <div class="col-sm-2">
                            <select class="form-control" name="integraPartition" id="integraPartition">
                                <option value="">{[Lang::get('content.partition')]}</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="integraZone" id="integraZone">
                                <option value="" disabled selected>{[Lang::get('content.zone')]}</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="integraLine" id="integraLine">
                                <option value="" disabled selected>{[Lang::get('content.line')]}</option>
                            </select>
                        </div>
                        </div></th></tr>
                    <tr><th colspan="6" class="clear-tab">
                    <div id="eventtype" class="row collapse">
                        <div class="col-sm-2">{[Lang::get('content.class')]}</div>
                        <div class="col-sm-9">
                            @foreach($eventSource as $index => $type)
                                <span class="btn event-list event-list{[$index]}" data-idx="{[$index]}" data-toggle="tooltip" data-placement="top" data-original-title="{[$type]}"><span class="event-type event-type{[$index]}"></span></span>
                            @endforeach
                        </div>
                        </div></th></tr>
                    <tr><th colspan="6" class="clear-tab">
                    <div id="eventcomment" class="row collapse">
                        <div class="col-sm-2">{[Lang::get('content.list-state-comment')]}</div>
                        <div class="col-sm-2">
						<div class="switch-toggle switch-3 switch-candy">

                            <input id="comment-na" name="withcomments" type="radio" checked="checked" value="null">
                                <label for="comment-na" title="{[Lang::get('content.comment-ev-filter-all')]}">
                                    <span class="editEvent label label-default-light"><i class="far fa-lg fa-comment"></i> &nbsp;</span>
                                </label>

                            <input id="comment-on" name="withcomments" type="radio" value="true">
                            <label for="comment-on" title="{[Lang::get('content.comment-ev-filter-with')]}">
                                    <span class="editEvent label label-default"><i class="far fa-lg fa-comment"></i> <span class="commentCount">X</span></span>
							</label>

                            <input id="comment-off" name="withcomments" type="radio" value="false">
                            <label for="comment-off" title="{[Lang::get('content.comment-ev-filter-without')]}">
                                    <span class="addEvent label label-default-light"><i class="far fa-lg fa-comment"></i> <span class="commentCount" style="font-weight:bold;font-size:15px;">+</span></span>
                            </label>

                            <a></a>
													</div>
										</div>
										<div class="col-sm-4">
												<input id="comment-text" name="comment-text" type="text" class="form-control">
											</div>
												<div class="col-sm-4 hidden-xs">
                        </div>
                        </div></th></tr>
                            </thead>

                            <tbody id='eventsTable'>
                            </tbody>
                            <tr id="btnNext"><td colspan="6" class="tabela-wiecej text-center"><button class="fa fa-lg fa-angle-down btn-more btn-block" name="btnNext" style="" type="submit" value="Starsze"></button></td></tr>
                            </table>

                            <div align="center"><img src="/css/select2-spinner.gif" id="idSpinner"/></div>
                        </div>
                    </div>
                    {[ Form::close() ]}
            </div>
        </div>

        @stop
        @section('listjavascripts')
        <script src="/js/event-common.fb01d372.js"></script>
        <script src="/js/event-new.c6eda945.js"></script>
        @stop
		@section('stylesheets')
        <link rel="stylesheet" href="/css/event-dialog.d1193720.css">
        @stop