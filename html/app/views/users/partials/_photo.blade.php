    <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new thumbnail" style="width: 120px; height: 150px;">
            <img src="{[ $userPhoto ]}" alt="zdjęcie">
        </div>
        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 120px; max-height: 150px;">
            <img id="img" src="#" alt="Photo" />
        </div>
	@if ($permUserEdit)
        <div>
            <span class="btn btn-default btn-file">
                <span class="fileinput-new">{[ Lang::get('content.user-add-photo') ]}</span>
                <span class="fileinput-exists">{[ Lang::get('content.user-change-photo') ]}</span>
                <input type='file' id="asd" />
            </span>
            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{[ Lang::get('content.user-remove-photo') ]}</a>
        </div>
	@endif	
        <input id="photo" name="photo" value="{[ $userPhoto ]}" hidden="hidden"/>
    </div>
