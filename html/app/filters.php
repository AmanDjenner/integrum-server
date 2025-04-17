<?php 
//use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
    Request::setTrustedProxies(['127.0.0.1']);
});


App::after(function($request, $response) {
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth',
    function() {
    $auth = new AuthRest();
    if ($auth->guest()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login')->with('currentRouteName',
                    Route::currentRouteName());
        }
    }
});


Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest',
    function() {
    if (Auth::check()) return Redirect::to('/');
});

	
Route::filter('checkPrivileges',function($route, $request)
{
	if (!is_null($route->getName()))
	$name = 'privileges.'. $route->getName();
	else 
	$name = 'privileges.'. $route->uri(). '.'.$request->method();
	$settings = Config::get($name);
	if (is_null($settings)) {
		//return null;
		throw new Exception($name); //debug
	}
	if (!array_key_exists('privs',$settings)) { //debug
		return null;
	}
	$privs = $settings['privs'];
	if (array_key_exists('route',$settings) ){
	$route = $settings['route'];
	} else {
	$route='session.denied';
	}
	if (array_key_exists('message',$settings) ){
	$message = $settings['message'];
	} else {
	$message='noAccess';
	}
	if (!UserPermissions::containsAnyFromArray($privs)) {
		return Redirect::route($route)->with('message', $message)->with('privs_required', $privs);
	} else {
		return null;
	}
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf',
    function() {
    if ((Request::isMethod('delete') || Request::isMethod('post')) && Session::token()
        !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
