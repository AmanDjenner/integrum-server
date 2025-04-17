@extends('layouts.list')

@section('listcontent')
<div class="row">
    <div class="col-sm-12" id="middle">
        <div class="row">
            <div class="col-sm-12 top-buffer">
                <table class="table table-condensed table-hover table-hover filter">
                    <thead>
                        {[ Form::open( array(
                        'route' => 'ethm.filter',
                        'method' => 'post',
                        'id' => 'form-filter-setting'
                        ) ) ]}
                    <input type="hidden" name="hierarchytree" id="hierarchytree" value="0"/>
                    <input type="hidden" name="ptoken" id="ptoken" value="{[ csrf_token() ]}" >
                    <input type="hidden" name="notAssigned" id="notAssigned" />
                    <tr>
                        <th>
                            {[ Form::text('ethmName','',['class'=>'form-control', 'placeholder'=>Lang::get('content.list-objectname'), 'id'=>"ethmName"]) ]}
                        </th>
                        <th>{[ Form::text('ip','',['class'=>'form-control', 'placeholder'=>Lang::get('content.list-ipaddr'), 'id'=>"ip"]) ]} </th>
                        <th>{[Lang::get('content.list-tcpport')]}</th>
                        <th>
                            <div style="float:left;">{[Lang::get('content.panel')  ]}
@if(Config::get('parameters.EthmNewServer', false))
{[ " (" . Lang::get('content.list-ethpanelwithout') ]} </div>
                            <span id="toggleNotAssigned" class="form-control-toggle fa fa-toggle-off" style="display:block; float:left;"></span>
                            <div style="float:left;">)</div>
							@else
								</div>
							@endif
                        </th>
                        <th style="max-width:45px;text-align: center;"><span id="state-ethm-ver" class="btn btn-xs" data-val="false" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.list-ethm-version') ]}" ><i class="fa fa-lg fa-check-square"></i></span></th>
                        <th style="max-width:45px;text-align: center;"><span id="state-ethm-mac" class="btn btn-xs" data-val="false" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.list-ethm-mac') ]}" ><i class="fa fa-lg fa-plug"></i></span></th>
                        <th style="max-width:45px;text-align: center;"><span id="state-ethm-lic" class="btn btn-xs" data-val="false" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.list-ethm-licensed') ]}" ><i class="fa fa-lg fa-registered"></i></span></th>
                        <th style="min-width:145px;">{[ Lang::get('content.list-action') ]} &nbsp;&nbsp;
                            <button class="btn btn-filter form-control" id='btnFilter' disabled='disabled' type="submit">
                                <i class="fa fa-filter"></i>
                            </button>
							<button type="button" class="btn btn-filter form-control" id="btn-filter-clear">
									<span class="fa-stack filterButton">
										<i class="fa fa-stack-1x fa-filter filterButtonIco"></i>
										<span>
											<i class="fa fa-stack-1x fa-ban filterButtonIco2"></i>
										</span>
									</span>
								</button>
						</th>
                    </tr>
                    {[ Form::close() ]}
                    </thead>
                    <tbody id='integraTable'>
                    </tbody>
                </table>
            </div>
        </div>
        <div align="center"><img src="/css/select2-spinner.gif" id="idSpinner"/></div>
        <!--
                <div class="row">
                    <button type="button" class="btn btn-default pull-right mr-15"><i class="fa fa-file-alt"></i>&nbsp; {[ Lang::get('content.list-getcsv') ]}</button>
                </div>
        -->
    </div>
</div>
<div class="row"></div>
@stop
@section('listjavascripts')
<script src="/js/integraethm.35e5dbd3.js"></script>
@stop