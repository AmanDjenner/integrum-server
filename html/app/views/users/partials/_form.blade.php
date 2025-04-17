<input type="text" style="display:none">
<input type="password" style="display:none">
<div class="form-group">
    {[ Form::label('input-forename', Lang::get('content.user-forename'),['class'=>'col-sm-4 col-md-5 control-label']) ]}
    <div class="col-sm-8 col-md-7">
        {[ Form::text('forename',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'input-forename']) ]}
        {[ $errors->first('forename') ]}
    </div>
</div>
<div class="form-group">
    {[ Form::label('input-surname', Lang::get('content.user-surname'),['class'=>'col-sm-4 col-md-5 control-label']) ]}
    <div class="col-sm-8 col-md-7">
        {[ Form::text('surname',NULL ,['class'=>'form-control frm-mr-ln', 'id'=>'input-surname']) ]}
        {[ $errors->first('surname') ]}
    </div>
</div>
<div class="form-group">
    <label for="input-name" class="col-sm-4 col-md-5 control-label">{[Lang::get('content.user-name')]}</label>
    <div class="col-sm-8 col-md-7">
        {[ Form::text('name',NULL,['class'=>'form-control frm-mr-ln required', 'id'=>'input-name']) ]}
        @if($errors->first('name'))
        <div class="alert alert-warning" role="alert">{[ $errors->first('name') ]}</div>
        @endif
    </div>
</div>
<div class="form-group">
    <label for="input-email" class="col-sm-4 col-md-5 control-label">{[Lang::get('content.user-email')]}</label>
    <div class="col-sm-8 col-md-7">
        {[ Form::email('email',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'input-email']) ]}
        @if($errors->first('email'))
        <div class="alert alert-warning" role="alert">{[ $errors->first('email') ]}</div>
        @endif
    </div>
</div>
<div class="form-group">
    {[ Form::label('input-telephone', Lang::get('content.user-phone'),['class'=>'col-sm-4 col-md-5 control-label']) ]}
    <div class="col-sm-8 col-md-7">
        {[ Form::text('telephone',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'input-telephone']) ]}
        {[ $errors->first('telephone') ]}
    </div>
</div>