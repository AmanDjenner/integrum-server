<?php

/*
 * Klasa zastepująca Eloquent
 */

abstract class EloquentJ
{

    protected $fillable   = array();
    protected $data       = array();
    protected $attributes = array();

    public function __set($name, $value)
    {
        if (in_array($name, $this->fillable)) {
            $this->data[$name] = $value;
        } else {
            throw new Exception('Undefined property via __set(): ' . $name . ' ');
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        throw new Exception('Undefined property via __get(): ' . $name . ' ');
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function toArray()
    {
        return $this->attributes;
    }

    abstract public function find($id);

    /**
     * Wypełnienie obiektu danymi
     * @param json $input
     */
    public function fill($input, $arrayNow = FALSE)
    {
        try {
            if (!$arrayNow) {
                $array = json_decode($input);
            } else {
                $array = $input;
            }

            foreach ($array as $key => $value) {
                //if('_token'!=$key){
                if (!preg_match('/^\_/', $key)) {
                    $this->attributes[$key] = $value;
                    $this->$key             = $value;
                }
            }
            return $this;
        } catch (\Throwable $e) {
                throw $e;
        }
    }

    public function fillMissing()
    {
        foreach ($this->fillable as $dummy => $key) {
            if (!array_key_exists($key, $this->attributes)) {
                $this->attributes[$key] = NULL;
                $this->$key             = NULL;
            }
        }
        return $this;
    }

    public function attributes()
    {
        return $this->attributes;
    }

}
