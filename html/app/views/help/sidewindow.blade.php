<div class="row" id="help-content-div" style="display:none;height: 90vh;width:30%;min-width:300px;right: 30px; background: rgb(255, 255, 255); border: 4px rgb(3,3,3);  box-shadow: 5px 5px 5px #888; position: fixed; top: {[ (Request::is('dashboard*') ? '20px' : '70px') ]};z-index:1070;" >
    <iframe id="help-content-frame" style="height:calc(100% - 40px);width:100%;border: 0;" src="about:blank"></iframe>
    <div class="mt-0" style="width:100%;height:40px;text-align:right;">
        <span class="pull-left">
            <div class="checkbox" style="float:left;">
            <label class="ml-10"><input type="checkbox" value="" id="help-lock"> <i class="fa fa-thumb-tack"></i> {[Lang::get('content.pin-lock') ]}</label>
            <label class="ml-10"><input type="checkbox" value="" id="help-nomore"> <i class="fa fa-list-alt"></i> {[Lang::get('content.help-nowelcome') ]}</label>
            </div>
        </span>
        <div id="help-home" class="btn btn-xs"><i style="color:#a5a5a5;" class="fa fa-lg fa-home"></i></div>
    </div>
</div>
