var UE={};window.Pace.options.ajax=$.extend(window.Pace.options.ajax,{trackMethods:["GET","POST"]}),jQuery(document).ready(function(a){function b(b,c){window.location.hash=b,a(UE).trigger("ue-activate-tab",{hash:b,target:c})}if(a(".tree-menu li a")&&a(".tree-menu li a").click(function(){a("#message-tree").text(a(this).text()),a("#message-tree").val(a(this).text());var b=a(this).data("value");a("#hierarchyId").text(b),a("#hierarchyId").val(b)}),a(".tabs a").click(function(c){a("#message").empty(),b(c.target.hash,c.target)}),""===window.location.hash){var c=a("#activeTab").val();b("#"+c,a('a[role="tab"][aria-controls="'+c+'"]')[0])}}),jQuery(document).ready(function(a){a("#locationOpen").click(function(){a("#tree-toggle").click()}),a(UE).on("ue-activate-tab",function(b,c){"#user-1"!==c.hash||a(c.target).hasClass("loaded")||setHelpLink("ekran-z-danymi-uzytkownika.html#ogolne")})}),jQuery(document).ready(function(a){function b(b){if(!window.FileReader)return void alert("The file API isn't supported on this browser yet.");if(b.files&&b.files[0]){var c=b.files[0],d=new FileReader;d.onload=function(b){a("#img").attr("src",b.target.result),a("#photo").attr("value",b.target.result)},c.size<=1048576?d.readAsDataURL(c):(b.value="",BootstrapDialog.show({type:BootstrapDialog.TYPE_DANGER,message:a("#trans-file-too-big").val(),buttons:[{label:"OK",action:function(a){a.close()}}]}))}else b.files||alert("This browser doesn't seem to support the `files` property of file inputs.")}a("#asd").change(function(){b(this)})});var saveAppUserViaDialog;jQuery(document).ready(function(a){var b=document.location.toString();if(b.match("#")){var c=b.split("#")[1];""!==c&&a('.tabs a[href="#'+b.split("#")[1]+'"]').tab("show")}for(var d=a("#rights-group-count").val(),e=0;d>=e;e++)a("#input-role"+e).select2({containerCssClass:"form-control required"}),a("#input-role-select"+e).select2({containerCssClass:"form-control required"}),a("#input-region"+e).select2({containerCssClass:"form-control required"}),a("#input-region-select"+e).select2({containerCssClass:"form-control required"});a(UE).on("ue-activate-tab",function(b,c){"#user-2"!==c.hash||a(c.target).hasClass("loaded")||(setHelpLink("ekran-z-danymi-uzytkownika.html#dostep-do-aplikacji"),a(c.target).addClass("loaded"))}),a("#appUserSubmit").click(function(){saveAppUserViaDialog=!1}),a("#appUserSubmitDialog").click(function(){saveAppUserViaDialog=!0}),a("#user-2>form").on("submit",function(){var b=a(this).find("#input-login").val();return""===a("#input-haslo").attr("placeholder")||""!==b||saveAppUserViaDialog?void 0:(a("#remove-login").val(a("#input-login").val()),a("#remove-password").val(a("#input-haslo").val()),a("#remove-roles").val(a('[name="roles[]"]').val()),a("#remove-idAccessGroup").val(a("#input-idAccessGroup").val()),a("#confirm-deleteAppUser").modal("show"),!1)})});