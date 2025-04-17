<div class="tab-content">
    {[ Form::open(array('route' => 'control.storeValid' , 'files' => true , 'method' => 'post', 'id' => 'form-add-integra')) ]}
    <input type="hidden" name="idGroup" id="idGroup"/>
    <input type="hidden" name="create" id="create" value="false"/>
    <input type="hidden" name="online" id="online" value="false"/>
<input type="text" style="display:none">
<input type="password" style="display:none">
    <div class="div-wizard" style="padding-left:15px;padding-right:15px">
        <div class="form-group row">
            <div class="col-sm-12">
                <h4>{[ ucfirst(Lang::get('content.integra')) ]}</h4>
            </div>
        </div>
        <div class="form-group row{[ ($errors->first('name'))?' has-error':'' ]}">
            {[ Form::label('name', ucfirst(Lang::get('content.name')).': ',['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                {[ Form::text('name',NULL,['autocomplete'=>'off', 'class'=>'form-control']) ]}
                <span id="helpBlock-name" class="help-block{[ ($errors->first('name'))?'':' hidden' ]}">{[$errors->first('name')]}</span>
            </div>
        </div>
        <div class="form-group row{[ ($errors->first('serviceCode'))?' has-error':'' ]}">
            {[ Form::label('serviceCode', ucfirst(Lang::get('content.addServiceCode')).': ',['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                <div class="input-group">
                    {[ Form::password('serviceCode',['autocomplete'=>'off', 'class'=>'form-control', 'maxlength'=>'8', 'id' => 'input-pin']) ]}
                    <span class="input-group-btn">
                        <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["input-pin"]}' class="btn changeToText" >
                            <span id="changeSpan" class="fa fa-eye"></span>
                        </a>
                    </span>
                </div>
                <span id="helpBlock-scode" class="help-block{[ ($errors->first('serviceCode'))?'':' hidden' ]}">{[ $errors->first('serviceCode') ]}</span>
            </div>
        </div>
        <div class="form-inline row{[ ($errors->first('intergrid')||$errors->first('dloadid')||$errors->first('guardid'))?' has-error':'' ]}" style="margin-bottom:15px">
            {[ Form::label('identyfikator', ucfirst(Lang::get('content.id')).': ',['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10 ">
                <div class="form-group" style="vertical-align:top;">
                    {[ Form::text('intergrid',NULL,['class'=>'form-control', 'maxlength'=>'10', 'placeholder'=> ucfirst(Lang::get('content.integra')) ]) ]}
                    <span id="helpBlock-iid" class="help-block{[ ($errors->first('integrid'))?'':' hidden' ]}">{[ $errors->first('intergrid') ]}</span>
                </div>
                <div class="form-group" style="vertical-align:top;">
                    {[ Form::text('dloadid',NULL,['class'=>'form-control', 'maxlength'=>'10', 'placeholder'=> ucfirst(Lang::get('content.dloadX')) ]) ]}
                    <span id="helpBlock-did" class="help-block{[ ($errors->first('dloadid'))?'':' hidden' ]}">{[ $errors->first('dloadid') ]}</span>
                </div>
                <div class="form-group" style="vertical-align:top;">
                    {[ Form::text('guardid',NULL,['class'=>'form-control', 'maxlength'=>'10', 'placeholder'=> ucfirst(Lang::get('content.guardX')) ]) ]}
                    <span id="helpBlock-gid" class="help-block{[ ($errors->first('guardid'))?'':' hidden' ]}">{[ $errors->first('guardid') ]}</span>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2 form-inline text-right">
                {[ Form::submit( Lang::get('content.next'),['class'=>'btn btn-warning btn-icon']) ]}
            </div>
        </div>
    </div>
    {[ Form::close() ]}
</div>