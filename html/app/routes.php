<?php
if (Config::get('parameters.forceSchemaHttps', true)) {
   URL::forceSchema('https');
}
if (Config::get('parameters.holdDown', false)) {
    header("Location: /wip.html");
    die();
} else {
    Route::get('login', array('uses'=>'SessionsController@create','as'=>'session.login'));
    Route::get('logout', array('uses'=>'SessionsController@destroy','as'=>'session.logout'));
    Route::get('denied', array('uses'=>'SessionsController@denied','as'=>'session.denied'));
    Route::resource('sessions', 'SessionsController');

    Blade::setContentTags('{[', ']}');        // for variables and all things Blade

    Route::group(array('before' => array('auth')),
            function() {
        Route::post('logincheck', array('uses'=>'SessionsController@check','as'=>'session.check'));
    //help
       Route::get('/help/{page}', function($page='index.html') { 
            $ext = pathinfo ($page,PATHINFO_EXTENSION);
            if ($ext == "php") {
                return View::make('/help/' . pathinfo ($page,PATHINFO_FILENAME));
            } else {
                $file="../app/help/". $page;
                if (file_exists($file)){
                    if ($ext == "htm") $ext .= "l";
                        return Response::make(file_get_contents($file,false ), 200, array('Content-Type'=> 'text/' . $ext));
                } else{
                    Response::make('Not found!', 404);
                }
            }
        });
    Route::group(array('before' => array('csrf')),
            function() {
        //Strona startowa
        Route::get('/', function() {
            return Redirect::to(SessionsController::startPage(Config::get('parameters.dashboardDefault', false), HierarchyController::getSessionData()->getQueryIdx()))->with('justloggedin',Session::get('justloggedin','false'));
        });
        Route::get('/ver/{package?}', 'VersionController@version');
    Route::group(array('before' => array('checkPrivileges')),
            function() {
        Route::post('/status/licenseupload',
                array('as' => 'licenseupload', 'uses' => 'VersionController@store'));
        Route::get('/status/licenserequest',
                array('as' => 'licenserequest', 'uses' => 'VersionController@getLicenseRequest'));
        Route::get('/status/{force?}', array('as' => 'status', 'uses' => 'VersionController@index'));
        Route::get('dashboard/overallstate/{withChildren}/{idAccessGroupUser}',
                array('as' => 'dashboard.overallstate', 'uses' => 'DashboardController@overallstate'));
        Route::get('dashboard',
            array('as' => 'dashboard', 'uses' => 'DashboardController@index'));
        Route::get('dashboardmap',
                array('as' => 'dashboardmap', 'uses' => 'DashboardController@index2'));
        Route::get('websocket/options', array('as' => 'websocket.options', 'uses' => 'WebsocketController@options'));
        Route::get('dashboard/filter/{system}/{id}/{idAccessGroupUser}', array('as' => 'dashboard.filter', 'uses' => 'DashboardController@filter'));
        Route::get('dashboard/events/unhandled', array('as' => 'dashboard.unhandledevents', 'uses' => 'DashboardController@unhandledEvents'));
        Route::get('dashboard/events/{id}/myqueue/added', array('as' => 'dashboard.eventsqueueadded', 'uses' => 'DashboardController@eventsqueueadded'));
        Route::get('dashboard/events/{id}/myqueue/removed', array('as' => 'dashboard.eventsqueueremoved', 'uses' => 'DashboardController@eventsqueueremoved'));
        Route::get('dashboard/events/{id}/{idAccessGroupUser}', array('as' => 'dashboard.events', 'uses' => 'DashboardController@events'));
        Route::get('dashboard/detail/{system}/{id}', array('as' => 'dashboard.detail', 'uses' => 'DashboardController@detail'));
        Route::get('event/createdashboard/{id}', 'DashboardController@events');

        Route::get('users/{id}/restore',
            array('as' => 'users.restore', 'uses' => 'UsersController@restore'));
        Route::get('users/{id}/destroy/{withPanels}/{CSRF}',
            array('as' => 'users.restore', 'uses' => 'UsersController@destroy'));
        Route::post('users/filter',
            array('as' => 'users.filter', 'uses' => 'UsersController@usersList'));
        Route::get('users/filter',
            array('as' => 'users.filter', 'uses' => 'UsersController@usersList'));
        Route::get('users/findbynamenew/{name}',
                array('as' => 'users.findbynamenew', 'uses' => 'UsersController@findByNameNew'));
        Route::get('users/findbyname/{name}',
            array('as' => 'users.findbyname', 'uses' => 'UsersController@findByName'));
        /** Formatka: Użytkownicy >> Centrale/Uprawnienia */
        Route::post('users/puserget', array('as' => 'users.puserget', 'uses' => 'UserIntegraController@permissionUserGet'));
        Route::get('users/{id}/puserpanels/',
            array('as' => 'users.permissionUserPanels', 'uses' => 'UserIntegraController@permissionUserPanels'));
        /** end: Użytkownicy >> Centrale/Uprawnienia */
        Route::resource('users', 'UsersController');
        Route::get('admin/roles/json', array('as' => 'admin.roles.json', 'uses' => 'RightsController@json'));
        Route::resource('admin/roles', 'RightsController');
        Route::post('admin/roles/destroy',
            array('as' => 'admin.roles.destroy', 'uses' => 'RightsController@destroy'));
        Route::get('admin/profile/json', array('as' => 'admin.profile.json', 'uses' => 'ProfileController@json'));
        Route::resource('admin/profile', 'ProfileController');
        Route::post('admin/profile/destroy',
            array('as' => 'admin.profile.destroy', 'uses' => 'ProfileController@destroy'));
        Route::get('admin/profilelist',
            array('as' => 'profile.profileList', 'uses' => 'ProfileController@profileList'));


        /** Formatka: Użytkownicy >> Aplikacja */
        Route::resource('userapp', 'UserApplicationController');

        /** Formatka: Użytkownicy >> Centrale/Uprawnienia */
        Route::resource('usercontrol', 'UserIntegraController');
                    });

        /** Formatka: Zdarzenia */
        Route::get('event/management', array('as' => 'event.management', 'uses' => 'EventController@management' ));
        Route::get('event/{id}/eventuserlist/{withChildren}', 'EventController@eventUserList');
        Route::post('event/doarchive', array('as' => 'event.doarchive', 'uses' => 'EventController@doarchive' ));
        Route::post('settings/properties/{key_}', array('as' => 'settings.update', 'uses' => 'EventController@storearchive' ));
        Route::post('settings/eventsgdpr', array('as' => 'settings.gdpr', 'uses' => 'EventController@removearchive' ));
        //eventUserListByIntegra
        Route::get('event/{id}/eventuserlistintegra/{withChildren}',
                'EventController@eventUserListByIntegra');
        //eventDescriptionList
        Route::post('event/eventdscrlist', 'EventController@eventDscrList');
        //event.filter
        Route::post('event/filtercsv',
                array('as' => 'event.filtercsv', 'uses' => 'EventController@filterCSV'));
        Route::post('event/create', 'EventController@create');
        Route::post('event/comments', 'EventController@addComment');

    Route::group(array('before' => array('checkPrivileges')),
            function() {
        Route::resource('event', 'EventController');

        /** Formatka: Centrale */
        Route::get('control/findbyname',
                array('as' => 'control.findbyname', 'uses' => 'IntegraController@findByName'));
        Route::post('control/storeXcx',
            array('as' => 'control.storeXcx', 'uses' => 'IntegraController@storeXcx'));
        Route::post('control/storeValid',
            array('as' => 'control.storeValid', 'uses' => 'IntegraController@storeValid'));
        Route::get('control/createstart', 'IntegraController@createStart');

        Route::get('control/store',
            ['as' => 'control.storeEthm', 'uses' => 'IntegraController@store']);
        Route::post('control/filter',
            array('as' => 'control.filter', 'uses' => 'IntegraController@filter'));
        Route::post('control/filtercsv',
                array('as' => 'control.filtercsv', 'uses' => 'IntegraController@filterCSV'));
        Route::post('control/arm',
            array('as' => 'control.arm', 'uses' => 'IntegraController@arm'));
        Route::post('control/trouble/clear',
            array('as' => 'control.clearTrouble', 'uses' => 'IntegraController@clearTrouble'));
        Route::post('control/clearalarm',
            array('as' => 'control.clearAlarm', 'uses' => 'IntegraController@clearAlarm'));
        Route::get('control/guardx',
            array('as' => 'control.guardx', 'uses' => 'IntegraController@startGuardX'));
        Route::post('control/disarm',
            array('as' => 'control.disarm', 'uses' => 'IntegraController@disarm'));
        Route::resource('control', 'IntegraController');
        Route::post('control/destroy',
            array('as' => 'control.destroy', 'uses' => 'IntegraController@destroy'));
    });

        Route::get('control/{id}/jcontrollist', 'IntegraController@jsonControlList');
        Route::get('control/{id}/jcontrollist/{withchilds}',
                'IntegraController@jsonControlList');
        //integraStructureTree
        Route::get('control/{id}/jstructure/{withCards?}',
            'IntegraController@integraStructureTree');
        Route::get('control/{id}/jstructurefull',
            'IntegraController@integraStructureTreeFull');

    //    Route::resource('control', 'IntegraController');

        /** Formatka: Centrale / Hierarchia. */
        Route::get('hierarchy/json',
            array('as' => 'hierarchy.json', 'uses' => 'HierarchyController@json'));
        Route::get('hierarchy/{id}/put', 'HierarchyController@putSession');
        Route::get('hierarchy/get', 'HierarchyController@getSession');
        Route::get('hierarchy/{id}/putchildren', 'HierarchyController@putChildren');
        Route::get('hierarchy/getchildren', 'HierarchyController@getChildren');
    Route::group(array('before' => array('checkPrivileges')),
            function() {
        Route::resource('hierarchy', 'HierarchyController');
        Route::post('hierarchy/destroy',
            array('as' => 'hierarchy.destroy', 'uses' => 'HierarchyController@destroy'));
        /** Formatka: Centrale / Edycja / Structure. */
        Route::get('/control/structure/{id}', array('as' => 'control.structure', 'uses' => 'IntegraStructureController@show'));
        Route::get('/control/outputs/{id}', array('as' => 'control.outputs', 'uses' => 'IntegraOutputsController@show'));
        Route::get('/control/locks/{id}', array('as' => 'control.locks', 'uses' => 'IntegraOutputsController@showLocks'));
        Route::get('/control/{id}/events', array('as' => 'control.events', 'uses' => 'IntegraEventsController@show'));
        //controlStructure
        //Route::get('/control/controlStructure/{id}',
        //    'ControlStructureController@show');
        Route::get('/control/controlStructureReport/{id}',array('as' => 'control.structureReport', 'uses' => 'ControlStructureReportController@show'));
        Route::get('/getstructurereportxcx/{id}',
            'ControlStructureReportController@getxcx');
        Route::post('control/integrauser/destroy',
            array('as' => 'control.integrauser.destroy', 'uses' => 'IntegraUserController@destroy'));
        /** Formatka: Centrale / Edycja / Użytkownicy. */
        Route::resource('control/integrauser', 'IntegraUserController',
            ['only' => ['show', 'destroy']]);
        Route::post('control/integrauser/correlate',
            array('as' => 'user.correlate', 'uses' => 'IntegraUserController@correlate'));
        Route::post('control/integrauser/createintegrum',
                array('as' => 'user.createIntegra', 'uses' => 'IntegraUserController@storeIntegraAsIntegrum'));

        /**
         * Uzbroj POST /armzone  (idIntegra&idzone)
         * Rozbroj POST /disarmzone  (idIntegra&idzone)
         * Strefa:  aktywna POST /unbypass (idIntegra&idzone)
         * Strefa: blokuj POST /bypass (idIntegra&idzone)
         * Strefa: blokuj czasowo POST /bypasstemp (idIntegra&idzone&time)
         */
        Route::post('control/action',
            array('as' => 'control.action', 'uses' => 'IntegraStructureController@action'));

        /** Formatka: Centrale / ETHM. */
        Route::resource('ethm', 'EthmController');
        Route::post('ethm/filter',
            array('as' => 'ethm.filter', 'uses' => 'EthmController@filter'));
        Route::post('ethm/destroy',
            array('as' => 'ethm.destroy', 'uses' => 'EthmController@destroy'));

        /** Zamapowanie URL WildFly */
        Route::get('/manageintegra/i/{i}/o/{o}', 'IntegrumServices@manageIntegra');
    });
    });
    });

    /** Zamapowanie URL czyszczącego cache WildFly */
    Route::get('evictAll', 'IntegrumServices@evictAll');
}