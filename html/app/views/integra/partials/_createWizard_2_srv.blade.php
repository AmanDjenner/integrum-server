
<div class="ethm-content div-wizard">
    {[ Form::open(array('route' => 'ethm.store' , 'files' => true , 'method' => 'post')) ]}
    <input type="hidden" name="type" id="type-c" value="c"/>
    <input type="hidden" name="idGroup" id="idGroup-c"/>
    <fieldset>
        <div class="form-group">
            <div class="col-sm-12">
            </div>
        </div>
        <div class="form-group {[ ($errors->first('name'))?'has-error':'' ]}">
            {[ Form::label('nameEthm', ucfirst(Lang::get('content.nameEthm')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                {[ Form::text('nameEthm',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'name']) ]}
                {[ $errors->first('name') ]}
            </div>
        </div>
        <div class="form-group {[ ($errors->first('address'))?'has-error':'' ]}">
            {[ Form::label('address-id', 'ETHM-1 ID:',['class'=>'col-sm-2 control-label'])]}
            <div class="col-sm-10">
                {[ Form::text('address',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'address-id']) ]}
                {[ $errors->first('address') ]}
            </div>
        </div>
        <div class="form-group {[ ($errors->first('address'))?'has-error':'' ]}">
            {[ Form::label('address-mac', 'ETHM-1 MAC:',['class'=>'col-sm-2 control-label'])]}
            <div class="col-sm-10">
                {[ Form::text('address',NULL,['class'=>'form-control', 'id'=>'address-mac']) ]}
                {[ $errors->first('address') ]}
            </div>
        </div>
        <div class="form-group">
            {[ Form::label('guardkey-srv', ucfirst(Lang::get('content.key')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10 form-inline">
                <?php
                $pGuardKey = ($errors->first('guardkey')) ? 'has-error' : '';
                $pDloadKey = ($errors->first('dloadkey')) ? 'has-error' : '';
                ?>
                <div class="form-group {[$pGuardKey]}">
                    {[ Form::input('password','guardkey',NULL,['class'=>'form-control', 'maxlength'=>'12', 'id'=>'guardkey-srv', 'placeholder'=>ucfirst(Lang::get('content.guardX'))]) ]}
                    {[ $errors->first('guardkey') ]}
                </div>
                <div class="form-group {[$pDloadKey]}">
                    <div class="input-group">
                        {[ Form::input('password','dloadkey',NULL,['class'=>'form-control', 'maxlength'=>'12', 'id'=>'dloadkey-srv', 'placeholder'=>ucfirst(Lang::get('content.dloadX'))]) ]}
                        {[ $errors->first('dloadkey') ]}
                        <span class="input-group-btn">
                            <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["guardkey-srv","dloadkey-srv"]}' class="btn changeToText" ><span id="changeSpan" class="fa fa-eye"></span></a>
                        </span>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-group {[ ($errors->first('number'))?'has-error':'' ]}">
            {[ Form::label('number', ucfirst(Lang::get('content.evidenceNumber')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                {[ Form::text('number',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'number']) ]}
                {[ $errors->first('number') ]}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10 form-inline">
                {[ Form::submit( Lang::get('content.next'),['class'=>'btn btn-warning btn-block']) ]}
            </div>
        </div>
    </fieldset>
    {[ Form::close() ]}
</div>
