<?php

//{"userApplication":{"id":(int),"login":"String","password":"String" ,"roles":[(int)],"idAccesGroup":(int)}}
class UserApp extends EloquentJ
{

    private $response;
    private $tableMaster;
    private $cacheTime;
    private $errors;
    protected $fillable  = ['id', 'login', 'password', 'roles', 'regions'];
    public static $rulesCustomMessages = [];
    public static $rules = [
        'weak'=>[
            'create'   => [
                'login'         => 'required|required_with:password|min:4|max:45',
                'password'      => 'required_with:login|min:8|max:255',
                'roles'        => 'array|required',
                'regions'      => 'array|required'
            ],
            'update'   => [
                'login'         => 'min:4|max:45',
                'password'      => 'min:8|max:255',
                'roles'        => 'array|required',
                'regions'      => 'array|required'
            ],
            'password' => [
                'password' => 'min:8|max:255'
            ]
        ],
        'strong'=>[
            'create'   => [
                'login'         => 'required|required_with:password|min:4|max:45',
                'password'      => 'required_with:login|min:8|max:255|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%\.@^&\*\(\)=+-]).*$/',
                'roles'        => 'array|required',
                'regions'      => 'array|required'
            ],
            'update'   => [
                'login'         => 'min:4|max:45',
                'password'      => 'min:8|max:255|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%\.@^&\*\(\)=+-]).*$/',
                'roles'        => 'array|required',
                'regions'      => 'array|required'
            ],
            'password' => [
                'password' => 'min:8|max:255'
            ]
        ]
    ];
    
    public function __construct()
    {
        $this->response    = new RestClient();
        $this->tableMaster = 'appuser/';
        $this->cacheTime   = 10;
        if (Config::get('parameters.password_type','weak')=='strong') {
            static::$rulesCustomMessages['password.min']=Lang::get("validation.password_strong");
        }
    }

    /**
     *
     * @param int $id
     * @return boolean
     */
    public function find($id)
    {
        $this->response->get($this->tableMaster . $id,
                $this->tableMaster . $id, $this->cacheTime);
        if (!$this->response->result()) {
            return FALSE;
        }
        $user = json_decode($this->response->getContent(), TRUE);
        try {
            $this->fill($user['userApplication'], TRUE);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return TRUE;
    }

    public function isValid($action)
    {
        $messages          = array();
        $messages['login'] = $this->loginExists($this->data['login'], $this->data['id']);
        $validation = Validator::make($this->data
                , static::$rules[Config::get('parameters.password_type','weak')][$action]
                , static::$rulesCustomMessages);
        if ($validation->passes()) {
            return true;
        }
        $this->errors = $validation->messages();
        foreach ($messages as $key => $value) {
            if ($value) {
                $this->errors->add($key, $value);
            }
        }
        return false;
    }

    private function loginExists($loginNow, $idNow)
    {
        $isLoginExists = UserProperties::isLoginExists($loginNow, $idNow);
        if ($isLoginExists) {
            static::$rules[Config::get('parameters.password_type','weak')]['error'] = 'required';
            return Lang::get('content.login-exists');
        }
        return NULL;
    }

    public function isPasswordValid()
    {
        return $this->isValid('password');
    }

    public function errors()
    {
        return $this->errors;
    }

    public function update()
    {
        $table = 'appuser/' . $this->data['id'] .'/login';

        $userApplication['userApplication'] = $this->data;
        $this->response->upPost($userApplication, $table,
                'appuser' . $userApplication['userApplication']['id']);
        $result = json_decode($this->response->getContent());
        if (isset($result) && 1 == $result->result) {
            return TRUE;
        }
        return false;
    }

    public function fillApp($inputNow)
    {
        unset($inputNow['message-tree']);
        if (isset($inputNow['password']) && empty($inputNow['password'])) {
            unset($inputNow['password']);
        }
        $this->fill($inputNow, TRUE);
    }

    /**
     * Zmiana hasła
     * @param int $id
     * @param string $password
     * @return boolean
     */
    public function passwordchange($id)
    {
        $table    = 'passwordchange';
        $this->id = $id;
        //$this->password=Hash::make($this->password);
        $userApp  = array("userApplication" => $this->data);
        $this->response->post($userApp, $table, $table, '0');
        //ToDo dodać obsługę błędów
        //If udana zmiana
        //return TRUE;
        //Else
        //return FALSE;
    }

}
