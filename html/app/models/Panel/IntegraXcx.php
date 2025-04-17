<?php

class IntegraXcx extends EloquentJ
{
    protected $fillable  = ['xcx', 'name', 'idGroup', 'xcxCode', 'online'];
    private $table       = 'integra/xcx';
    private $errors;
    public static $rules = [
        'xcx' => 'required',
        'name' => 'required',
        'xcxCode' => 'required|integer|digits_between:1,8',
        'idGroup' => 'required|integer|min:1'
    ];

    public function isValid()
    {
        $validation = Validator::make($this->attributes, static::$rules);

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

    public function getXcx()
    {
        return base64_decode($this->xcx);
    }

    /**
     * Zapisuje Centrale
     * addintegra
     */
    public function save()
    {
        $restClient = new RestClient();
        $restClient->upPost($this->attributes, $this->table, 'integralist', 0);
        return json_decode($restClient->getContent());
    }

    public function find($id)
    {

    }
}