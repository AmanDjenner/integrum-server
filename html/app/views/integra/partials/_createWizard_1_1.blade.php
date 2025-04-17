<div class="tab-content" id='createFile'>
<input type="text" style="display:none">
<input type="password" style="display:none">
    <div class="row div-wizard">
        {[ Form::open(array('route' => 'control.storeXcx' , 'files' => true , 'method' => 'post')) ]}
        <input type="hidden" name="idGroup" id="idGroup"/>
        <fieldset>
            <div class="form-group">
                <div class="col-sm-12">
                    <h4>{[ ucfirst(Lang::get('content.integra')) ]}</h4>
                </div>
            </div>
            <div class="form-group">
                {[ Form::label('name', ucfirst(Lang::get('content.name')).': ',['class'=>'col-sm-2 control-label'] ) ]}
                <div class="col-sm-10">
                    {[ Form::text('name',NULL,['class'=>'form-control frm-mr-ln']) ]}
                    @if($errors->first('name'))
                    <div class="alert alert-warning" role="alert">{[ $errors->first('name') ]}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                {[ Form::label('xcxCode', ucfirst(Lang::get('content.xcxCode')).':',['class'=>'col-sm-2 control-label']) ]}
                <div class="col-sm-10">
                    <div class="input-group frm-mr-ln">
                        {[ Form::password('xcxCode',['class'=>'form-control', 'id'=>'input-pin']) ]}
                        <span class="input-group-btn">
                            <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["input-pin"]}' class="btn changeToText" >
                                <span id="changeSpan" class="fa fa-eye"></span>
                            </a>
                        </span>
                    </div>
                    @if($errors->first('xcxCode'))
                    <div class="alert alert-warning" role="alert">{[ $errors->first('xcxCode') ]}</div>
                    @endif
                </div>
            </div>
            <div><br /></div>
            <div class="form-group">
                {[ Form::label('file', ucfirst(Lang::get('content.file')).':' ,['class'=>'col-sm-2 control-label']) ]}
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="alert alert-default" role="alert" id='icon-xcx'>
                            <span>
                                <i class="fa fa-lg fa-file-code-o"></i> - XCX
                            </span>
                            <span style="float:right;"><i class="fa fa-lg fa-check"></i></span>
                        </div>
                        <div>
                            <span class="btn btn-default btn-file btn-icon" title="{[Lang::get('content.add')]}">
                                <span class="fileinput-new"><i class="fa fa-upload fa-lg"></i></span>
                                <input type='file' id="asd" />
                            </span>
                        </div>
                    </div>
                    <input id="xcx" name="xcx" hidden="hidden"/>
                    @if($errors->first('xcx'))
                    <div class="alert alert-warning" role="alert">{[ $errors->first('xcx') ]}</div>
                    @endif
                </div>
            </div>
            <div><br /></div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3 text-right">
                    <button type="submit" title="{[ Lang::get('content.saveCreate') ]}" class="btn btn-icon btn-default frm-mr-ln" >
                        <span class="fa-stack cardButton">
                            <i class="fa fa-lg fa-stack-1x fa-download"></i>
                            <span class="save-userredo-overlay">
                                <i class="fa fa-stack-1x fa-undo"></i>
                            </span>
                        </span>
                    </button>
                    <button type="submit" title="{[ Lang::get('content.save') ]}" class="btn btn-icon btn-warning frm-mr-ln" ><i class="fa fa-lg fa-download"></i></button>
                </div>
            </div>
        </fieldset>
        {[ Form::close() ]}
    </div>
</div>