<?php

class SessionsController extends \BaseController
{

    protected $auth;

    public function __construct()
    {
        $this->auth = new AuthRest();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ($this->auth->check()) {
            return Redirect::to('/');
        }
        Session::flash('currentRouteName', Session::get('currentRouteName'));
        $lic = $this->getLicense();
        return View::make('sessions.create')
                        ->with('message', (NULL!=$lic)?$this->messageWithHttpStatus() . $lic->errInfo : $this->messageWithHttpStatus())
                        ->with('messageLogin', $this->messageLogin())
                        ->with('licenseOwner', $lic);
    }
    
    function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }
    
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 || 
        (substr($haystack, -$length) === $needle);
    }
    
    public function getLicense()
    {
        $v = new Version();
        try {

            $lic        = json_decode($v->getServer(4));
            $w          = $v->getWeb();
            $licmessage = new stdClass();
            $licmessage->errInfo = null;
            switch ($lic->result) {
                case 1:
                    $licmessage->alert = 'alert-integrum';
                    break;
                case 3:
                    $licmessage->alert = 'alert-info';
                    break;
                case 4:
                    $licmessage->alert = 'alert-warning';
                    break;
                default:
                    $licmessage->alert = 'alert-danger';
                    break;
            }
            if ($lic->version&&$lic->result==1) {
                $srvInfo= explode("||",$lic->version);
                if (!$this->startsWith($w["version"],$srvInfo[0].'.')){
                    $licmessage->err = 1;
                    $licmessage->errInfo = $srvInfo[0]. " vs " . $w["version"] ;
                    $licmessage->alert = 'alert-danger';
                }
                if (!($this->endsWith($w["version"],$srvInfo[1])||$this->endsWith($w["version"],hex2bin("2d646576")))){
                    $licmessage->err = 2;
                    $licmessage->errInfo = $srvInfo[1]. " vs " . $w["version"] ;
                    $licmessage->alert = 'alert-danger';
                }
            }
            $licmessage->message = str_replace("\n", "<br/>", $lic->name);
            return $licmessage;
        } catch (RestException $e) {
            return "";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            if ($this->auth->attempt(Input::only('login', 'password', 'ipAddress'))) {
                //czy ma byc zmiana hasla
                if ($this->auth->checkPasswordChange()) {
                    return Redirect::to('/sessions/' . $this->auth->user()->id . '/edit');
                }
                if (Session::has('currentRouteName')) {
                    return Redirect::route(Session::get('currentRouteName'))->with('justloggedin','true');
                }
                return Redirect::to('/')->with('justloggedin','true');
            }
            return Redirect::to('/login')->with('message', '')->with('messageLogin',
                            Lang::get('content.infoError'));
        }catch(\Throwable $e) {
            return Redirect::to('/login')->with('message', $e->getMessage())->with('messageLogin',
                            Lang::get('content.infoError'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function check(){
        return json_encode((object) ['ret' => $this->auth->attempt(["login"=>Session::get('loginUser'),"password"=>Input::get("pwd"), "ipAddress"=>"check"])]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
		$hierarchy = new HierarchyController();
        //passwordchange
        return View::make('sessions.edit')
				->with('sideRegionVars', $hierarchy->getSideRegionData())
				->with('navbarVars', $this->navbarVarsDefault())
                        ->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if (Input::get('password') != Input::get('password2')) {
            return Redirect::to('/sessions/' . $id . '/edit');
        } else {
            $userApp = new UserApp();
            $input   = array('password' => Input::get('password'));
            $userApp->fill($input, TRUE);
            if (!$userApp->isPasswordValid()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($userApp->errors());
            }
            $userApp->passwordchange($id);
            return Redirect::route('users.index')
                            ->with('message', 'passwordchange');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
        $this->auth->logout();
        $message = Lang::get('content.disconnected');
        if (Session::get('message')) {
            $message = Session::get('message');
        }
        return Redirect::to('/login')->with('message', $message)->with('messageLogin',
                        '')->with('currentRouteName',
                        Session::get('currentRouteName'));
    }

    private function messageWithHttpStatus()
    {
        if (Session::has('message')) {
            $message         = Session::get('message');
            Session::remove('message');
            $httpStatusCodes = Lang::get('rest.http_status_codes');
            if (isset($httpStatusCodes[$message])) {
                $message = "Error: " . $httpStatusCodes[$message];
            }
            return $message;
        }
        return null;
    }

    private function messageLogin()
    {
        if (Session::has('messageLogin')) {
            $message = Session::get('messageLogin');
            Session::remove('messageLogin');
            return $message;
        }
        return null;
    }

    public function denied()
    {
        return View::make('sessions.denied')
                    ->with('navbarVars', $this->navbarVarsDefault(false, false));
    }

    public static function startPage($dashboard, $currRegion){
        if ($dashboard && UserPermissions::containsForRegion("SELDASHBOARD", $currRegion)) {
           return 'dashboard';
        } else if (UserPermissions::containsForRegion("SELUSER", $currRegion)) {
            return 'users';
        } else if (UserPermissions::containsForRegion("SELINTEGRA", $currRegion)) {
            return 'control';
        } else if (UserPermissions::containsForRegion("SELEVENTS", $currRegion)) {
            return 'event';
        } else if (UserPermissions::containsForRegion("SELDASHBOARD", $currRegion)) {
           return 'dashboard';
        } else { 
            return 'status';
        } 
    }
}
