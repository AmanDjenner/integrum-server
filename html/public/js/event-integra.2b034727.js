jQuery(document).ready(function($){function inArray(a,b){for(var c=b.length,d=0;c>d;d++)if(b[d]===a)return!0;return!1}function setSource(a){var b="btn-warning",c=jQuery.parseJSON($("#sourceJSON").attr("value"));if(inArray(a,c)){var d=c.indexOf(a);d>-1&&c.splice(d,1),$('.btn.event-list[data-idx="'+a+'"]').removeClass(b)}else c.push(a),$('.btn.event-list[data-idx="'+a+'"]').addClass(b);var e=JSON.stringify(c);$("#source").attr("value",e.substring(1,e.length-1)),$("#sourceJSON").attr("value",e),onChangeSource()}function cancelDelayedSubmit(){null!=window.timeoutId&&(window.clearTimeout(window.timeoutId),window.timeoutId=null)}function delayedSubmit(){null!=window.timeoutId&&window.clearTimeout(window.timeoutId),window.timeoutId=window.setTimeout(doSubmit,1200)}function doSubmit(){$("#btnFilter").click(),window.timeoutId=null}function onChangeSource(){$.post("/event/eventdscrlist",{_token:$("input[name=_token]").val(),eventClasses:jQuery.parseJSON($("#sourceJSON").attr("value"))},function(a){var b=$("#type").val();$("#type").empty(),$.each(a,function(a,b){$("#type").append('<option class="event-list event-list'+b.evtClass+'" value="'+b.id+'">'+b.name+"</option>")}),null!==b&&$('#type option[value="'+b+'"]').length>0&&$("#type").val(b)},"json").fail(function(a){0!==a.readyState&&(window.location.href="/logout")})}function getHierarchy(){withChildren=getToggleChildrenBool();var a=getCurrentRegionHierarchy(),b=a.id,c=a.name;null!=b&&($("#idOffset").val(""),con(b,c))}function con(a,b){$("#input-tree").text(b),$("#idTree").text(a),$("#idTree").val(a),$("#eventsTable").empty(),$("#idOffset").val(0),$("#idQueryStartIdx").val(""),$("#form-add-setting").submit()}function setEventListGetCSV(a){$("#event-list-getcsv").attr("value",JSON.stringify(a))}function refreshControlDetails(a,b){a?($("#integraPartition").attr("disabled",!1),$("#integraZone").attr("disabled",!1),$("#integraLine").attr("disabled",!1),$.get("/control/"+a+"/jstructurefull",function(a){integraObjects=a,$("#integraPartition").empty(),$("#integraPartition").val(""),$("#integraPartition").append($("<option></option>").attr("value","").text($('input[name="trans-part"]').val())),$.each(a,function(a,b){$("#integraPartition").append('<option value="'+b.id+'">'+b.text+" </option>")})},"json")):($("#integraPartition").empty(),$("#integraPartition").append($("<option></option>").attr("value","").text($('input[name="trans-part"]').val())),$("#integraZone").empty(),$("#integraZone").append($("<option></option>").attr("value","").attr("selected","selected").text($('input[name="trans-zone"]').val())),$("#integraLine").append('<option value="0">'+$('input[name="trans-line"]').val()+"</option>"),$("#integraPartition").attr("disabled",!0),$("#integraZone").attr("disabled",!0),$("#integraLine").attr("disabled",!0));var c=$("#eventUsers");c.attr("disabled","disabled"),c.empty(),$.get("/event/"+b+"_"+a+"/eventuserlistintegra/"+withChildren,function(a){var b=$("#eventUsers");$.each(a,function(a,c){b.append('<option value="'+c.id+'">'+c.name+"</option>")}),b.val(null).trigger("change"),b.removeAttr("disabled")},"json")}function getSourceList(){sourcelist=[],$("#source option").each(function(a,b){sourcelist[$(b).val()]=$(b).text()})}function eventCommentClick(a){$.get("/event/"+$(a.currentTarget).data("eventId"),function(a){commentDialog.showCommentEventDialog(a)},"json").fail(function(a){0!==a.readyState&&(window.location.href="/logout")})}function getCommentIcon(a,b){return parseInt(b)>0?'<span class="editEvent label label-default" data-event-id="'+a+'" ><i class="far fa-lg fa-comment"></i> <span class="commentCount">'+b+"</span></span>":'<span class="addEvent label label-default-light" data-event-id="'+a+'"><i class="far fa-comment"></i> <i class="fa fa-plus"></i></span> '}function getCommentCount(a){var b=$('span[data-event-id="'+a+'"] > span.commentCount').html();return b?parseInt(b):0}function setCommentCount(a,b){b>1?$('span[data-event-id="'+a+'"] > span.commentCount').html(b):($('span[data-event-id="'+a+'"]').html('<i class="far fa-lg fa-comment"></i> <span class="commentCount">'+b+"</span></span>"),$('span[data-event-id="'+a+'"]').removeClass("label-default-light addEvent").addClass("editEvent label-default"))}function setLocalStorageColor(a){window.localStorage.setItem("event-colors",a)}function setLocalStorageCondensed(a){window.localStorage.setItem("event-condensed",a)}function removeLocalStorageColor(){window.localStorage&&window.localStorage.getItem("event-colors")&&window.localStorage.removeItem("event-colors")}function removeLocalStorageCondensed(){window.localStorage&&window.localStorage.getItem("event-condensed")&&window.localStorage.removeItem("event-condensed")}function getLocalStorageState(){var a;a=window.localStorage&&window.localStorage.getItem("event-colors")?window.localStorage.getItem("event-colors"):"false",setColors(a);var b;b=window.localStorage&&window.localStorage.getItem("event-condensed")?window.localStorage.getItem("event-condensed"):"false",setCondensed(b)}function setColors(a){var b="btn-create",c="btn-warning",d=a||$("#currEventColor").attr("value");$("#event-colors").removeClass(b),$("#event-colors").removeClass(c),$("#currEventColor").attr("value",a),"true"===d?($("#event-colors").addClass(c),$("#stateToggle").bootstrapToggle("on"),$(".btn.event-list").removeClass("event-list-mono"),$("#eventsTable tr").removeClass("event-mono"),setLocalStorageColor("true")):($("#event-colors").addClass(b),$(".btn.event-list").addClass("event-list-mono"),$("#eventsTable tr").addClass("event-mono"),removeLocalStorageColor())}function setCondensed(a){var b="btn-create",c="btn-warning",d=a||$("#currEventCondensed").attr("value");$("#event-condensed").removeClass(b),$("#event-condensed").removeClass(c),$("#currEventCondensed").attr("value",a),"true"===d?($("#event-condensed").addClass(c),$("#eventsTable").addClass("condensed"),setLocalStorageCondensed("true")):($("#event-condensed").addClass(b),$("#eventsTable").removeClass("condensed"),removeLocalStorageCondensed())}var withChildren=!1,transdatepickerFormat=$('input[name="trans-date-picker-Format"]').val(),transdatepickerLocale=$('input[name="trans-date-picker-Locale"]').val(),transdatepickerToday=$('input[name="trans-date-picker-Today"]').val(),transdatepickerClear=$('input[name="trans-date-picker-Clear"]').val(),transdatepickerClose=$('input[name="trans-date-picker-Close"]').val(),transdatepickerSelectMonth=$('input[name="trans-date-picker-SelectMonth"]').val(),transdatepickerPrevMonth=$('input[name="trans-date-picker-PrevMonth"]').val(),transdatepickerNextMonth=$('input[name="trans-date-picker-NextMonth"]').val(),transdatepickerSelectYear=$('input[name="trans-date-picker-SelectYear"]').val(),transdatepickerPrevYear=$('input[name="trans-date-picker-PrevYear"]').val(),transdatepickerNextYear=$('input[name="trans-date-picker-NextYear"]').val(),transdatepickerSelectDecade=$('input[name="trans-date-picker-SelectDecade"]').val(),transdatepickerPrevDecade=$('input[name="trans-date-picker-PrevDecade"]').val(),transdatepickerNextDecade=$('input[name="trans-date-picker-NextDecade"]').val(),transdatepickerPrevCentury=$('input[name="trans-date-picker-PrevCentury"]').val(),transdatepickerNextCentury=$('input[name="trans-date-picker-NextCentury"]').val(),transdatepickerPickHour=$('input[name="trans-date-picker-PickHour"]').val(),transdatepickerIncrementHour=$('input[name="trans-date-picker-IncrementHour"]').val(),transdatepickerDecrementHour=$('input[name="trans-date-picker-DecrementHour"]').val(),transdatepickerPickMinute=$('input[name="trans-date-picker-PickMinute"]').val(),transdatepickerIncrementMinute=$('input[name="trans-date-picker-IncrementMinute"]').val(),transdatepickerDecrementMinute=$('input[name="trans-date-picker-DecrementMinute"]').val(),transdatepickerPickSecond=$('input[name="trans-date-picker-PickSecond"]').val(),transdatepickerIncrementSecond=$('input[name="trans-date-picker-IncrementSecond"]').val(),transdatepickerDecrementSecond=$('input[name="trans-date-picker-DecrementSecond"]').val(),transdatepickerTogglePeriod=$('input[name="trans-date-picker-TogglePeriod"]').val(),transdatepickerSelectTime=$('input[name="trans-date-picker-SelectTime"]').val(),commentDialog=new EventDialog({name:"commentEvDialog",hideSleepOption:!0,closable:!0});$("#btn-filter-date").prop("disabled",!1),$("#idQueryStartIdx").val(""),$('[data-toggle="tooltip"]').tooltip(),$("#type, #eventUsers").change(function(){delayedSubmit()}),$("#comment-text").on("keyup",function(){""!==$("#comment-text").val()&&$("#comment-on").prop("checked",!0),delayedSubmit()}),$(document).on("tree-toggle-recvd",function(a,b){withChildren=1==b,getHierarchy()});var integraObjects,$loading=$("#idSpinner").hide(),$btnNext=$("#btnNext").hide(),sourcelist;getSourceList(),$(document).on("tree-selected",function(){var a=$("#controlList").val(),b=$("#eventUsers");b.attr("disabled","disabled"),b.empty(),$url="/event/"+getCurrentRegionHierarchy().id+(a?"_"+a+"/eventuserlistintegra/":"/eventuserlist/")+withChildren,$.get($url,function(a){var b=$("#eventUsers");$.each(a,function(a,c){b.append('<option value="'+c.id+'">'+c.name+"</option>")}),b.val(null).trigger("change"),b.removeAttr("disabled"),getHierarchy()},"json")}),$("#date1").datetimepicker({format:transdatepickerFormat,showTodayButton:!0,locale:transdatepickerLocale,tooltips:{today:transdatepickerToday,clear:transdatepickerClear,close:transdatepickerClose,selectMonth:transdatepickerSelectMonth,prevMonth:transdatepickerPrevMonth,nextMonth:transdatepickerNextMonth,selectYear:transdatepickerSelectYear,prevYear:transdatepickerPrevYear,nextYear:transdatepickerNextYear,selectDecade:transdatepickerSelectDecade,prevDecade:transdatepickerPrevDecade,nextDecade:transdatepickerNextDecade,prevCentury:transdatepickerPrevCentury,nextCentury:transdatepickerNextCentury,pickHour:transdatepickerPickHour,incrementHour:transdatepickerIncrementHour,decrementHour:transdatepickerDecrementHour,pickMinute:transdatepickerPickMinute,incrementMinute:transdatepickerIncrementMinute,decrementMinute:transdatepickerDecrementMinute,pickSecond:transdatepickerPickSecond,incrementSecond:transdatepickerIncrementSecond,decrementSecond:transdatepickerDecrementSecond,togglePeriod:transdatepickerTogglePeriod,selectTime:transdatepickerSelectTime}}).on("dp.show",function(){cancelDelayedSubmit()}).on("dp.change",function(a){$("#btn-filter-date").prop("disabled",a.date!==!1),$("#date2").data("DateTimePicker").minDate(a.date),delayedSubmit()}),window.timeoutId=null,$(".btn.event-list").on("click",function(a){setSource($(a.target).closest(".btn").data("idx")),delayedSubmit()}),$("#date2").datetimepicker({format:transdatepickerFormat,showTodayButton:!0,locale:transdatepickerLocale,tooltips:{today:transdatepickerToday,clear:transdatepickerClear,close:transdatepickerClose,selectMonth:transdatepickerSelectMonth,prevMonth:transdatepickerPrevMonth,nextMonth:transdatepickerNextMonth,selectYear:transdatepickerSelectYear,prevYear:transdatepickerPrevYear,nextYear:transdatepickerNextYear,selectDecade:transdatepickerSelectDecade,prevDecade:transdatepickerPrevDecade,nextDecade:transdatepickerNextDecade,prevCentury:transdatepickerPrevCentury,nextCentury:transdatepickerNextCentury,pickHour:transdatepickerPickHour,incrementHour:transdatepickerIncrementHour,decrementHour:transdatepickerDecrementHour,pickMinute:transdatepickerPickMinute,incrementMinute:transdatepickerIncrementMinute,decrementMinute:transdatepickerDecrementMinute,pickSecond:transdatepickerPickSecond,incrementSecond:transdatepickerIncrementSecond,decrementSecond:transdatepickerDecrementSecond,togglePeriod:transdatepickerTogglePeriod,selectTime:transdatepickerSelectTime},useCurrent:!1}).on("dp.show",function(){cancelDelayedSubmit()}).on("dp.change",function(a){$("#btn-filter-date").prop("disabled",a.date!==!1),$("#date1").data("DateTimePicker").maxDate(a.date),delayedSubmit()}),$("#eventUsers").select2({allowClear:!0,placeholder:"",closeOnSelect:!0}),refreshControlDetails($("#controlList").val(),getCurrentRegionHierarchy().id),$("#integraPartition").on("change",function(a){for(var b=a.target.value,c=0;c<integraObjects.length;c++){var d=integraObjects[c];d.id==b&&($("#integraZone").empty(),$("#integraZone").val(""),$("#integraZone").append('<option value="0">'+$('input[name="trans-zone"]').val()+"</option>"),$.each(d.partitionList,function(a,b){$("#integraZone").append('<option value="'+b.id+'">'+b.text+" </option>")}))}delayedSubmit()}),$("#integraZone").on("change",function(a){for(var b=$("#integraPartition").val(),c=a.target.value,d=0;d<integraObjects.length;d++){var e=integraObjects[d];if(e.id==b)for(var f=e.partitionList,g=0;g<f.length;g++){var h=f[g];h.id==c&&($("#integraLine").empty(),$("#integraLine").val(""),$("#integraLine").append('<option value="0">'+$('input[name="trans-line"]').val()+"</option>"),$.each(h.zoneList,function(a,b){$("#integraLine").append('<option value="'+b.id+'">'+b.text+" </option>")}))}}delayedSubmit()}),$("#integraLine").on("change",function(){delayedSubmit()}),$("#btnFilter").click(function(){$("#eventsTable").empty(),$("#idOffset").val(0),$("#idQueryStartIdx").val("")}),$("#btn-filter-clear").click(function(){cancelDelayedSubmit(),$("#eventUsers").val(0),$("#type").val(0),$("#source").val([]),$("#date1").data("DateTimePicker").clear(),$("#date2").data("DateTimePicker").clear(),$("#source").trigger("change"),$("#btn-filter-date").focus(),$("#comment-na").prop("checked",!0),$("#comment-text").val(""),cancelDelayedSubmit(),$("#btnFilter").click()}),$("#event-export").click(function(){$("#form-csv").submit()}),$("#form-add-setting").on("submit",function(){var panel=$("#controlList").val(),source=jQuery.parseJSON($("#sourceJSON").attr("value"));$loading.show(),$btnNext.hide();var dateFrom;$("#date1").data("DateTimePicker").date()&&(dateFrom=$("#date1").data("DateTimePicker").date().format("YYYY-MM-DD HH:mm:ss"));var date;$("#date2").data("DateTimePicker").date()&&(date=$("#date2").data("DateTimePicker").date().format("YYYY-MM-DD HH:mm:ss"));var withComments=eval($('[name="withcomments"]:checked').val()),data={_token:$(this).find("input[name=_token]").val(),hierarchytree:$("#idTree").val(),integraId:panel,objectId:$("#integraPartition").val(),partitionId:$("#integraZone").val(),zoneId:$("#integraLine").val(),userId:$("#eventUsers").val(),source:source,typeEvent:$("#type").val(),dateFrom:dateFrom,dateTo:date,offset:$("#idOffset").val(),queryStartIdx:$("#idQueryStartIdx").val(),withChildren:withChildren,withComments:withComments,commentContains:withComments?$("#comment-text").val():null,btnNext:$("#btnNext").val()};return setEventListGetCSV(data),$.post($(this).prop("action"),data,function(a){var b=a.eventList;if(a.eventList){if(a.archiverState){var c=parseInt(a.archiverState);$(".panel-event").removeClass("ev-archive").addClass(c?"ev-archive":""),$(".panel-event .ev-spinner").removeClass("hidden").addClass(c?"":"hidden")}var d=$("#currEventColor").attr("value");$(b).each(function(a,b){var c=b.source,e="true"===d?"":"event-mono",f=document.integrumEventShowComments?getCommentIcon(b.id,b.commentCount):"",g=b.userId?'<td><a href="../users/'+b.userId+'">'+b.user+"</a></td>":"<td>"+b.user+" </td>";$("#eventsTable").append('<tr class="event-color'+c+" "+e+'"><td> '+b.date+' </td><td align="center"> <div class="event-type event-type-body event-type'+c+'"></div></td><td> '+b.type+" "+f+"</td>"+g+"<td> &nbsp; </td></tr>")})}else $("#eventsTable").empty(),$("#eventsTable").append("<tr><td> brak danych  </td> <td> &nbsp; </td><td> &nbsp; </td><td> &nbsp; </td><td> &nbsp; </td><td> &nbsp; </td></tr>");$("#idOffset").val(a.offset),$("#idQueryStartIdx").val(a.queryStartIdx),$loading.hide(),"hide"!=a.offset&&$btnNext.show()},"json").fail(function(a){0!==a.readyState&&(window.location.href="/logout")}),!1}),getHierarchy(),$("#btnCollapse").click(function(){var a=$("#btnCollapse>i"),b=a.hasClass("fa-caret-down");a.toggleClass("fa-caret-down fa-caret-right"),$("#eventdata").collapse(b?"hide":"show"),$("#eventtype").collapse(b?"hide":"show"),$("#eventpanel").collapse(b?"hide":"show"),$("#eventcomment").collapse(b?"hide":"show")}),$(document).on("click",".editEvent, .addEvent",function(a){$(a.currentTarget).data("eventId")&&eventCommentClick(a)}),$(document).on("ev-comment-added",function(a,b){setCommentCount(b,getCommentCount(b)+1)}),$("#event-colors").click(function(){setColors("true"===$("#currEventColor").val()?"false":"true")}),$("#event-condensed").click(function(){setCondensed("true"===$("#currEventCondensed").val()?"false":"true")}),$("#eventUsers").val(null).trigger("change"),getLocalStorageState(),$('[name="withcomments"]').click(function(){delayedSubmit()})});