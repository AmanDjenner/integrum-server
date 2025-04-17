<div class="ethm-content div-wizard panel-body">
    {[ Form::open(array('route' => 'ethm.store' , 'files' => true , 'method' => 'post')) ]}
    <input type="hidden" name="type" id="type-a" value="a"/>
    <input type="hidden" name="idGroup" id="idGroup-a"/>
    <fieldset>
        <div class="form-group row {[ ($errors->first('name'))?'has-error':'' ]}">
            {[ Form::label('nameEthmMac', ucfirst(Lang::get('content.nameEthm')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                {[ Form::text('nameEthm','ETHM ' . Session::get('integra_1')->getData()->getName(),['class'=>'form-control', 'id'=>'nameEthmMac']) ]}
                <span id="helpBlock-name" class="help-block{[ ($errors->first('name'))?'':' hidden' ]}">{[ $errors->first('name') ]}</span>
            </div>
        </div>
        <div class="form-group row {[ ($errors->first('macORimei'))?'has-error':'' ]}">
            {[ Form::label('macORimei', ucfirst(Lang::get('content.macORimei')),['class'=>'col-sm-2 control-label'])]}
            <div class="col-sm-10">
                {[ Form::text('macORimei',NULL,['class'=>'form-control', 'id'=>'macORimei', 'maxlength'=>'17']) ]}
                <span id="helpBlock-macorimei" class="help-block{[ ($errors->first('macORimei'))?'':' hidden' ]}">{[ $errors->first('macORimei') ]}</span>
            </div>
        </div>
        <div class="form-group row{[($errors->first('guardkey')||$errors->first('dloadkey')) ? ' has-error' : '']}">
            {[ Form::label('guardkey', ucfirst(Lang::get('content.key')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10 form-inline">
                <div class="form-group">
                    {[ Form::input('password','guardkey',NULL,['class'=>'form-control', 'maxlength'=>'12', 'id'=>'guardkey', 'placeholder'=>ucfirst(Lang::get('content.guardX'))]) ]}
                </div>
                <div class="form-group">
                    <div class="input-group">
                        {[ Form::input('password','dloadkey',NULL,['class'=>'form-control', 'maxlength'=>'12', 'id'=>'dloadkey', 'placeholder'=>ucfirst(Lang::get('content.dloadX'))]) ]}
                        <span class="input-group-btn">
                            <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["guardkey","dloadkey"]}' class="btn changeToText" ><span id="changeSpan" class="fa fa-eye"></span></a>
                        </span>
                    </div>
                </div>
				@if ($errors->first('guardkey')||$errors->first('dloadkey'))
					<br/>
                    <span id="helpBlock-keys" class="help-block">
                    {[ $errors->first('guardkey') ]}
                    {[ $errors->first('dloadkey') ]}
                    </span>
				@endif            
            </div>
        </div>
        <div class="form-group row {[ ($errors->first('number'))?'has-error':'' ]}">
            {[ Form::label('numberMac', ucfirst(Lang::get('content.evidenceNumber')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                {[ Form::text('number',NULL,['class'=>'form-control', 'id'=>'numberMac']) ]}
                <span id="helpBlock-number" class="help-block{[ ($errors->first('number'))?'':' hidden' ]}">{[ $errors->first('number') ]}</span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10 form-inline col-sm-offset-2">
                {[ Form::submit( Lang::get('content.next'),['class'=>'btn btn-warning btn-block']) ]}
            </div>
        </div>
    </fieldset>
    {[ Form::close() ]}
</div>
