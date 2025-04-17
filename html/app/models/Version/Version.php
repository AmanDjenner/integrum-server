<?php

class Version extends EloquentJ
{

    private $response;
    protected $fillable = ['result', 'name', 'version', 'date', 'message'];

    public function __construct()
    {
        $this->response = new RestClient;
    }

    /**
     *
     * @param int $id
     * @return boolean
     */
    public function find($id)
    {
        switch ($id) {
            case 0:
                return $this->fill($this->getWeb(), TRUE)->fillMissing();
            default:
                return $this->fill($this->getServer($id))->fillMissing();
        }
    }

    public function fillVersion($inputNow)
    {
        return $this->fill($inputNow, TRUE);
    }


    public function errors()
    {
        return $this->errors;
    }


    public function statusName()
    {
        return $this->statusList[$this->status];
    }

    public function getServer($id)
    {
        $table = 'version/' . $id;
        $this->response->get($table, FALSE);
        return $this->response->getContent();
    }

    public static function getWeb()
    {
        return array("result" => 1, "name" => "INTEGRUM Web", "version" => Config::get("version.number"), "date" => Config::get("version.date"));
    }

    public function getLicenseCount() {
        $table = 'version/0/count';
        $this->response->get($table, FALSE);
        $resp = json_decode($this->response->getContent());
        $param = new stdClass(); 
        $param->licensed = $resp->ok;
        $param->ready =$resp->offlineCount;
        $param->notready =$resp->alarmCount;
        return $param;
    }
}
