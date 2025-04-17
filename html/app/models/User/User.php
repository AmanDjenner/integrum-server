<?php

class User extends EloquentJ
{
    private $response;
    private $cacheTime;
    private $errors;
    protected $fillable  = ['id', 'name', 'surname', 'userName', 'userCnt', 'userSchema', 'forename', 'email',
        'telephone', 'login', 'password', 'photo', 'hierarchyId',
        'accessRights', 'rootRegions', 'active', 'description', 'accountingNumber', 'integraDefName', 'code',
        'status', 'integraIdList', 'type', 'permissionProfileId', "password", "result",
        "message", 'queryIdx','isDeleted','hasPanels','hasLogin','panelName','hasCode'];
    private $statusList  = array(1 => '', 2 => /* ????? */'nieaktywny', 3 => 'usunięty');
    public static $rules = [
        'create' => [
            'name' => 'required|ExistsName',
            'email' => 'email',
            'hierarchyId' => 'required',
            'integraDefName' => 'required_with:code',
            'code' => 'required_with:integraDefName|numeric|digits_between:4,8|ExistsCode',
            'login' => 'required_with:password',
            'password' => 'required_with:login',
            'integraIdList' => 'required_with:permissionProfileId',
            'permissionProfileId' => 'required_with:integraIdList'
        ],
        'update' => [
            'name' => 'required|ExistsNameID:id',
            'email' => 'email',
            'hierarchyId' => 'required',
            'integraDefName' => 'required_with:code',
            'code' => 'required_with:integraDefName|numeric|digits_between:4,8|ExistsCodeID:id',
            'login' => 'required_with:password',
            'password' => 'required_with:login'
        ]
    ];

    public function rules($action, $id = false)
    {
        $rules = self::$rules[$action];
        if ($id) {
            foreach ($rules as &$rule) {
                $rule = str_replace('id', $id, $rule);
            }
        }
        return $rules;
    }

    public function __construct()
    {
        $this->response  = new RestClient;
        $this->cacheTime = 25;
    }

    /**
     *
     * @param int $id
     * @return boolean
     */
    public function find($id, $short = FALSE)
    {
        $table        = 'appuser/' . $id ;
        $this->response->get($table. ($short?'/short':''), $table, $this->cacheTime);
        if (!$this->response->result()) {
            return FALSE;
        }
        $this->fill($this->response->getContent());
        $this->photoCheckIfBase64();
        return TRUE;
    }

    /**
     * Zapisanie do bazy
     */
    public function save()
    {
        $table = 'appuser';
        $this->response->put($this->data, $table, $table, '0');
        return $this->response->getContent();
    }

    /**
     * Tworzymy obiekt User z Formularza
     */
    public function fillUser($inputNow)
    {
        unset($inputNow['integraIdListOld']);
        unset($inputNow['create']);
        if (isset($inputNow['permissionProfileId']) &&
            $inputNow['permissionProfileId'] == "0") {
            unset($inputNow['permissionProfileId']);
        }
        if (!isset($inputNow['code'])) {
            $inputNow['code'] = '';
        }
        if (!$inputNow['photo']) {
            unset($inputNow['photo']); // tak aby nie kasował poprzedniego zdjecia
        }

        $this->fill($inputNow, TRUE);
    }

    public function updateappuser()
    {
        $table  = 'appuser';
        $this->response->upPost($this->data, $table,
            'appuser'.$this->data['id'], '0');
        $result = json_decode($this->response->getContent());
        if (isset($result) && 1 == $result->result) {
            return TRUE;
        }
        return false;
    }

    public function isValid($action, $id = NULL)
    {
        if ($id && (!$this->data['code']||"*****"==$this->data['code'])) {
            unset(static::$rules['update']['code']);
            unset($this->data['code']);
        }
        $validation = Validator::make($this->data, $this->rules($action, $id));

        if ($validation->passes()) {
            return true;
        }
        $this->errors = $validation->messages();
        return false;
    }

    public function errors()
    {
        return $this->errors;
    }

    /**
     *
     * @param tint $id
     * @return type
     */
    public function setDelete($id, $dodelete, $withPanels)
    {
        if (!is_int($id)) {
            throw new Exception('Invalid argument id.');
        }
        if (!is_bool($dodelete)) {
            throw new Exception('Invalid argument dodelete.');
        }
        if (!is_bool($withPanels)) {
            throw new Exception('Invalid argument withPanels.');
        }

        $tableMaster = 'appuser/' . $id . '/archive';
        $curlPostDat = array("id" => $id, "deleted" => $dodelete, "withPanels" => $withPanels);
        $this->response->post($curlPostDat, $tableMaster, $tableMaster, 0);
        $data        = json_decode($this->response->getContent());
        return $data;
    }

    public function statusName()
    {
        return $this->statusList[$this->status];
    }

    public function photoCheckIfBase64()
    {
        if (base64_decode($this->photo, true) || empty(base64_decode($this->photo))) {
            $this->photo = '';
        }
    }
}