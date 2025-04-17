<?php

class ControlStructureReport extends \Eloquent
{
    protected $connection = 'cabase';
    protected $table      = 'ca_reports';
    protected $fillable   = ['name', 'rep_date', 'rd_date', 'prev_date', 'rep_code',
        'report', 'usr_report', 'sent'];
    public $timestamps    = false;

    public function getRepDateAttribute($value)
    {
        return dateFormatChange($value);
    }

    public function getRdDateAttribute($value)
    {
        return dateFormatChange($value);
    }

    public function getPrevDateAttribute($value)
    {
        return dateFormatChange($value);
    }

    public function getRepCodeAttribute($value)
    {
        return $this->codeToName($value);
    }

    public function getReportAttribute($value)
    {
        $data = explode("\xd\xa", $value);
        foreach ($data as $key => $dataVal) {
            if (!empty($dataVal) && 'LoadDate' != $dataVal) {
                $data[$key] = $this->nameToName($dataVal);
            } else {
                unset($data[$key]);
            }
        }
        return $data;
    }

    public function getUsrReportAttribute($value)
    {
        return iconv("WINDOWS-1250", "UTF-8", $value);
    }

    public function findID($id)
    {
        return $this->where('id', '=', $id)->orderBy('rep_date', 'desc')->limit(30)->get();
    }

    public function findByAutoinc($id)
    {
        return $this->where('autoinc', '=', $id)->get();
    }

    public function getListEmail()
    {
        return $this->where('sent')->where('rep_code', '<>', '0')->orderBy('rep_date',
                'desc')->limit(1)->get();
    }

    public function upSent($id)
    {
        return $this->where('autoinc', '=', $id)->update(array('sent' => 1));
    }

    private function codeToName($code)
    {
        $content = Lang::get('repCodes.'.$code);
        if (strpos($content, 'repCodes') !== false) {
            $content = '';
        }
        return $content;
    }

    private function nameToName($name)
    {
        $content = Lang::get('repNames.'.$name);
        if (strpos($content, 'repNames') !== false) {
            $content = '';
        }
        return $content;
    }
}