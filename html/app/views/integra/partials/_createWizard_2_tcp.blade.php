<div class="ethm-content div-wizard panel-body">
    {[ Form::open(array('route' => 'ethm.store' , 'files' => true , 'method' => 'post')) ]}
    <input type="hidden" name="type" id="type-b" value="b"/>
    <input type="hidden" name="idGroup" id="idGroup-b"/>
    <fieldset>
        <div class="form-group row{[ ($errors->first('name'))?' has-error':'' ]}">
            {[ Form::label('nameEthm', ucfirst(Lang::get('content.nameEthm')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                {[ Form::text('nameEthm','ETHM ' . Session::get('integra_1')->getData()->getName(),['class'=>'form-control', 'id'=>'nameEthm']) ]}
                <span id="helpBlock-nameE" class="help-block{[($errors->first('name'))?'':' hidden' ]}">{[ $errors->first('name') ]}</span>
            </div>
        </div>
        <div class="form-group row{[ ($errors->first('address'))?' has-error':'' ]}">
            {[ Form::label('address', ucfirst(Lang::get('content.addressip')),['class'=>'col-sm-2 control-label'])]}
            <div class="col-sm-10">
                {[ Form::text('address',NULL,['class'=>'form-control', 'id'=>'address']) ]}
                <span id="helpBlock-addr" class="help-block{[($errors->first('address'))?'':' hidden' ]}">{[ $errors->first('address') ]}</span>
            </div>
        </div>
        <div class="form-group row">
            <label forname="guardPort" class="col-sm-2 control-label{[($errors->first('guardPort')||$errors->first('dloadPort'))?' has-error':'' ]}">{[ucfirst(Lang::get('content.port'))]}</label>
            <div class="col-sm-10 form-inline">
                <div class="form-group col-sm-6{[($errors->first('guardPort'))?' has-error':'' ]}">
                    {[ Form::number('guardPort',NULL,['class'=>'form-control', 'id'=>'guardPort', 'min'=>'1', 'max'=>'65535', 'step'=>'1', 'placeholder'=>ucfirst(Lang::get('content.guardX'))]) ]}
                    <span id="helpBlock-gports" class="help-block{[($errors->first('guardPort'))?'':' hidden' ]}">{[ $errors->first('guardPort') ]}</span>
                </div>
                <div class="form-group col-sm-6{[($errors->first('dloadPort'))?' has-error':'' ]}">
                    {[ Form::number('dloadPort',NULL,['class'=>'form-control', 'id'=>'dloadPort', 'min'=>'1', 'max'=>'65535', 'step'=>'1', 'placeholder'=>ucfirst(Lang::get('content.dloadX'))]) ]}
                    <span id="helpBlock-dports" class="help-block{[($errors->first('dloadPort'))?'':' hidden' ]}">{[ $errors->first('dloadPort') ]}</span>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label forname="guardkey" class="col-sm-2 control-label{[($errors->first('guardkey')||$errors->first('dloadkey')) ? ' has-error' : '']}">{[ucfirst(Lang::get('content.key'))]}</label>
            <div class="col-sm-10 form-inline">
                <div class="form-group col-sm-6{[($errors->first('guardkey')) ? ' has-error' : '']}">
                    {[ Form::input('password','guardkey',NULL,['class'=>'form-control', 'maxlength'=>'12', 'id'=>'guardkey_tcp', 'placeholder'=>ucfirst(Lang::get('content.guardX'))]) ]}
                    <span id="helpBlock-gkeys" class="help-block{[($errors->first('guardkey'))?'':' hidden' ]}">{[ $errors->first('guardkey') ]}</span>
                </div>
                <div class="form-group col-sm-6{[($errors->first('dloadkey')) ? ' has-error' : '']}">
                    <div class="input-group" style="vertical-align:top;">
                        {[ Form::input('password','dloadkey',NULL,['class'=>'form-control', 'maxlength'=>'12', 'id'=>'dloadkey_tcp', 'placeholder'=>ucfirst(Lang::get('content.dloadX'))]) ]}
                        <span class="input-group-btn">
                            <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["guardkey_tcp","dloadkey_tcp"]}' class="btn changeToText" ><span id="changeSpan" class="fa fa-eye"></span></a>
                        </span>
                    </div>
                    <span id="helpBlock-dkeys" class="help-block{[($errors->first('dloadkey'))?'':' hidden' ]}">{[ $errors->first('dloadkey') ]}</span>
                </div>
            </div>
        </div>
        <div class="form-group row{[ ($errors->first('number'))?' has-error':'' ]}">
            {[ Form::label('numberTcp', ucfirst(Lang::get('content.evidenceNumber')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                {[ Form::text('number',NULL,['class'=>'form-control', 'id'=>'numberTcp']) ]}
                <span id="helpBlock-numbers" class="help-block{[($errors->first('number'))?'':' hidden' ]}">
                {[ $errors->first('number') ]}
                </span>
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
