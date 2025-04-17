<?php

/**
 * Własny system "Authentication"
 *
 * @author karolsz
 */
class AuthRest
{
    const LOGIN = 'login';
    const PASS = 'password';
    const IPADDR = 'ipAddress';
    protected $user;
    protected $session;
    protected $content;
    protected $response;
    protected $methodName;

    public function __construct()
    {
        $this->response = new RestClient;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @param bool $remember
     */
    public function attempt(array $credentials = array())
    {
        try {
            if ($this->checkUser($credentials)) {
                $userId = $this->content->userId;
                $user = $this->user($userId, true);
                $this->addSessionData($user);
                Session::put('idUser', $this->content->userId);
                return true;
            }
            return FALSE;
        } catch (\Throwable $e) {
            return $this->sendFailedLoginResponse($credentials, $e);
        }
    }

    public function addSessionData(User $user)
    {
            $array = [];
            $regions = [];
            $allRights = [];
            foreach($user->accessRights as $val) {
                $regions = array_merge($regions, $val->regions);
                foreach($val->regionQryIdxs as $region) {
                    $allRights[$region]=$val->permissions; //$allRights[$val->regionQueryIdx]=$val->permissions;
                }
                foreach($val->permissions as $perm){
                    array_push($array, $perm);
                }
            }
            //TODO fix here iterate for accessRights
$array = array_diff($array, ["RAPINTEGRA"]);
            UserPermissions::setPermissions($array, $allRights, $regions);
            UserContext::init($user);
            return TRUE;
    }

    public function check()
    {
        if (Session::get('idUser')) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    public function logout()
    {
        Session::flush();
        UserPermissions::clear();
    }

    /**
     * Sprawdza poprzez RESTa czy login i hasło jest poprawne
     * @param array $credentials
     * @return boolean
     */
    private function checkUser(array $credentials = array())
    {
        $methodName                = 'login';
        $credentials["servicekey"] = Config::get('parameters.key');
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($credentials)) {
//            $this->fireLockoutEvent($credentials);
            return $this->sendLockoutResponse($credentials);
        }


        $this->response->post($credentials, $methodName, $methodName, 0);

        $this->content = json_decode($this->response->getContent());

        if (1 == $this->content->result) {
            Session::put("mapToken", $this->content->message);
            $this->clearLoginAttempts($credentials);
            return TRUE;
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($credentials);
        return $this->sendFailedLoginResponse($credentials);
    }
    protected function sendFailedLoginResponse(array $credentials, Throwable $e = NULL)
    {
        throw new Exception(Lang::get('content.infoError',[$credentials[AuthRest::LOGIN]]) . ((null == $e)?"":"<br>".$e->getMessage()) );
    }
    /**
     * Sprawdzamy czy ma być zmienione hasło
     * @return boolean
     */
    public function checkPasswordChange()
    {
        return $this->content->passwordchange;
    }

    public function user($id = NULL, $short = FALSE)
    {
        $this->user = new User();
        $this->user->find($id==NULL?Session::get('idUser'):$id, $short);
        return $this->user;
    }


    
        /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(array $credentials)
    {
        return $this->tooManyAttempts(
            $this->throttleKey($credentials), $this->maxAttempts(), $this->decayMinutes()
        );
    }
    /**
     * Determine if the given key has been "accessed" too many times.
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @param  float|int  $decayMinutes
     * @return bool
     */
    function tooManyAttempts($key, $maxAttempts, $decayMinutes = 1)
    {
        if ($this->attempts($key) >= $maxAttempts) {
            if (Cache::has($key.':timer')) {
                return true;
            }
            $this->resetAttempts($key);
        }
        return false;
    }
    
    public function attempts($key)
    {
        return Cache::get($key, 0);
    }
    /**
     * Increment the login attempts for the user.
     *
     * @param  array $credentials
     * @return void
     */
    protected function incrementLoginAttempts(array $credentials)
    {
        $this->hit(
            $this->throttleKey($credentials), $this->decayMinutes()
        );
    }

    function hit($key, $decayMinutes = 1)
    {
        Cache::add(
            $key.':timer', $this->availableAt($decayMinutes * 60), $decayMinutes
        );
        $added = Cache::add($key, 0, $decayMinutes);
        $hits = (int) Cache::increment($key);
        if (! $added && $hits == 1) {
            Cache::put($key, 1, $decayMinutes);
        }
        return $hits;
    }
    protected function availableAt($delay = 0)
    {
        $delay = $this->parseDateInterval($delay);
        return $delay instanceof DateTimeInterface
                            ? $delay->getTimestamp()
                            : (new DateTime("now"))->add(new DateInterval('PT'.$delay.'S'))->getTimestamp();
    }

    /**
     * If the given value is an interval, convert it to a DateTime instance.
     *
     * @param  \DateTimeInterface|\DateInterval|int  $delay
     * @return \DateTimeInterface|int
     */
    protected function parseDateInterval($delay)
    {
        if ($delay instanceof DateInterval) {
            $delay = (new DateTime("now"))->add($delay);
        }
        return $delay;
    }    
    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(array $credentials)
    {
        $seconds = $this->availableIn(
            $this->throttleKey($credentials)
        );
        throw new Exception(Lang::get('content.throttle', ['seconds' => $seconds, 'username'=>$credentials[AuthRest::LOGIN]]));
    }
    public function availableIn($key)
    {
        return Cache::get($key.':timer') - (new DateTime("now"))->getTimestamp();
    }
    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(array $credentials)
    {
        //$this->limiter()->clear($this->throttleKey($credentials));
        $key = $this->throttleKey($credentials);
        $this->resetAttempts($key);
        Cache::forget($key.':timer');
    }
        /**
     * Reset the number of attempts for the given key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function resetAttempts($key)
    {
        return Cache::forget($key);
    }
    /**
     * Fire an event when a lockout occurs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function fireLockoutEvent(array $credentials)
    {
        event(new Lockout($credentials));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(array $credentials)
    {
        return Str::lower($credentials[AuthRest::LOGIN]).'|'.$credentials[AuthRest::IPADDR];
    }

    /**
     * Get the rate limiter instance.
     *
     * @return \Illuminate\Cache\RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return int
     */
    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }

}