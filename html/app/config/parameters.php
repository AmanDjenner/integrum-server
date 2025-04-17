<?php
return array(
    'hostRest' => 'http://127.0.0.1:28080/integrumservices/', //localhost:28080
    'cookiesRest' => '/tmp/cookies.tmp',
    'pathLogs' => '/opt/integrum-server/html/app/storage/logs/integrum_error.log',
    'useCache' => false,
    'verboseLog' => '/opt/integrum-server/html/app/storage/logs/integrum.log',
    'key' => 'klucz',
    'dashRest' =>'http://127.0.0.1:28080/integrum-dashboard/',
    'eventDashBoard' => array(
        1 => '{"system":"integra", "parameters":[{"key":"source", "value":"5"},{"key":"hierarchytree", "value":"1"},{"key":"limit", "value":"16"},{"key":"queryStartIdx", "value":"null"},{"key":"offset", "value":"0"},{"key":"withChildren", "value":"true"}]}',
        2 => '{"system":"integra", "parameters":[{"key":"source", "value":"0,1"},{"key":"hierarchytree", "value":"1"},{"key":"limit", "value":"16"},{"key":"queryStartIdx", "value":"null"},{"key":"offset", "value":"0"},{"key":"withChildren", "value":"true"}]}',
        3 => '{"system":"integra", "parameters":[{"key":"source", "value":"2"},{"key":"hierarchytree", "value":"1"},{"key":"limit", "value":"16"},{"key":"queryStartIdx", "value":"null"},{"key":"offset", "value":"0"},{"key":"withChildren", "value":"true"}]}'
    ),
	'detailDashBoard' => array(
		'integra1' => '{"system":"integra", "parameters":[{"key":"hierarchytree", "value": "1"}, {"key":"statusCode", "value": "1"}, {"key":"withChildren", "value":"true"}]}',
		'integra2' => '{"system":"integra", "parameters":[{"key":"hierarchytree", "value": "1"}, {"key":"statusCode", "value": "2"}, {"key":"withChildren", "value":"true"}]}',
		'integra3' => '{"system":"integra", "parameters":[{"key":"hierarchytree", "value": "1"}, {"key":"statusCode", "value": "4"}, {"key":"withChildren", "value":"true"}]}',
		'integra4' => '{"system":"integra", "parameters":[{"key":"hierarchytree", "value": "1"}, {"key":"statusCode", "value": "5"},{"key":"withChildren", "value":"true"}]}',
	),
	'overallDashBoard' => array(
		'initData' => array(
		array('key' => 'alarm', 'label' => 'content.alarm', 'color' => '#d9534f'),
		array('key' => 'trouble', 'label' => 'content.trouble', 'color' => '#f0ad4e'),
		array('key' => 'service', 'label' => 'content.service', 'color' => '#5cb85c'),
		array('key' => 'offline', 'label' => 'content.noConnection', 'color' => '#5bc0de'),
		),
		'buttons'=> array(
		array('system' => 'integra', 'type' => '1', 'class' => 'btn-danger', 'id' => 'alarm', 'title' => 'content.alarm', 'icon' => 'fa-bell', 'level' => '1') ,
		array('system' => 'integra', 'type' => '2', 'class' => 'btn-warning', 'id' => 'trouble', 'title' => 'content.trouble', 'icon' => 'fa-exclamation-triangle', 'level' => '3') ,
		array('system' => 'integra', 'type' => '3', 'class' => 'btn-success', 'id' => 'service', 'title' => 'content.service', 'icon' => 'fa-wrench', 'level' => '4') ,
		array('system' => 'integra', 'type' => '4', 'class' => 'btn-info', 'id' => 'offline', 'title' => 'content.noConnection', 'icon' => 'fa-globe', 'level' => '2')
		),
		'eventTitles' => array(
		1 => Lang::get('content.dashEventTitle1'),
		2 => Lang::get('content.dashEventTitle2'),
		3 => Lang::get('content.dashEventTitle3'),
		),
	),
    'websocket' => array(
        'mapoptions' => array('uri' => '127.0.0.1:28080', 'urlPrefix' => 'https://127.0.0.1:28080'),
    ),
    'dashboardMode' => 'integra',
    'RESULT_OK' => 1,
    'RESULT_WARNING' => 2,
    'RESULT_ERROR' => 3,
    'eventLimit' => 15,
    'soundOnMap' => false,
    'allowEditToManageUsers' => false,
    'dashboardDefault' => false,
);
