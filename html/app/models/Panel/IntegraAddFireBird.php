<?php

class IntegraAddFireBird extends \Eloquent
{
    protected $connection = 'cabase';
    protected $table      = 'ca_data';
    protected $fillable   = ['id', 'typ', 'plus', 'name', 'data1', 'grupa',];
    public $timestamps    = false;

    public static function add($data)
    {
        $raw = 'INSERT INTO '.$this->table.'(id, typ, plus, name, data1, grupa) '
            .'VALUES('.$data['id'].', '.$data['typ'].', '.$data['plus'].', '
            .''.$data['name'].', '.$data['data1'].', '.$data['grupa'].')';
        DB::connection($this->connection)->raw($raw);
    }
}