function getToggleChildrenValue(){return $("#togglechildren i").hasClass("fa-toggle-on")?"1":"0"}function getToggleChildrenBool(){return $("#togglechildren i").hasClass("fa-toggle-on")}function getCurrentRegionHierarchy(){return $("#currentRegionHierarchy").data("currenthierarchy")}jQuery(document).ready(function(a){function b(){a("#wrapper").toggleClass("active"),a("#wrapper-backdrop").toggleClass("active"),c()}function c(){a("#wrapper").attr("class")?setTimeout(function(){a("#sidebar-wrapper .btn-group").show()},500):a("#sidebar-wrapper .btn-group").hide()}function d(){a(document).trigger("tree-toggle-recvd",getToggleChildrenValue())}a(".sidebar-nav li:has(ul)").addClass("parent_li").find(" > span > i ").attr("title","zwiń gałąź"),a(".sidebar-nav li > span > i").on("click",function(b){if(a(this).parents("li").first().is(".parent_li")){var c=a(this).closest("li.parent_li").find(" > ul > li");c.is(":visible")?(a(this).addClass("fa-caret-right"),a(this).removeClass("fa-caret-down"),c.hide("fast")):(a(this).addClass("fa-caret-down"),a(this).removeClass("fa-caret-right"),c.show("fast")),b.stopPropagation()}}),a("#wrapper-backdrop").click(function(b){b.preventDefault(),a("#wrapper").toggleClass("active"),a("#wrapper-backdrop").toggleClass("active"),c()}),a(window).on("integrum-showHierarchy",function(){b()}),a("#tree-toggle, .breadcrumb>li").click(function(c){c.preventDefault(),b(),setTimeout(function(){a("#navbar-backdrop").trigger("click")},250)}),a("#tree-togglemenu").click(function(c){c.preventDefault(),a("#integrumNavbar").removeClass("in"),b()}),a(".sidebar-nav li:has(ul) a").click(function(){a("#wrapper").toggleClass("active"),a("#wrapper-backdrop").toggleClass("active"),c()}),a("#sidebar-wrapper").perfectScrollbar({suppressScrollX:!0}),a("#sidebar-wrapper .btn-group").hide(),d(),a("#togglechildren").click(function(){a("#togglechildren i").toggleClass("fa-toggle-off fa-toggle-on"),a.get("/hierarchy/"+getToggleChildrenValue()+"/putchildren",function(){a(document).trigger("tree-toggle-recvd",getToggleChildrenValue())})})});