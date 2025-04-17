<?php

class CustomValidator extends \Illuminate\Validation\Validator
{

    public function validateHex($attribute, $value, $parameters)
    {
        if (ctype_xdigit($value)) {
            return true;
        }
        return false;
    }

    /**
     * Dla Edycji
     */
    public function validateExistsNameID($attribute, $value, $parameters)
    {
        return !UserProperties::isUserNameExists($value, $parameters[0]);
    }

    public function validateExistsCodeID($attribute, $value, $parameters)
    {
        return !UserProperties::isUserCodeExists($value, $parameters[0]);
    }

    /**
     * Dla Nowego użytkownika
     */
    public function validateExistsName($attribute, $value, $parameters)
    {
        return !UserProperties::isUserNameExists($value, NULL);
    }

    public function validateExistsCode($attribute, $value, $parameters)
    {
        return !UserProperties::isUserCodeExists($value, NULL);
    }

    public function validateExistsIPandPort($attribute, $value, $parameters, $validator)
    {
		$data = $validator->getData();
		$ip = $data[$parameters[0]];
		$port = $data[$parameters[1]];
		if (count($parameters)>2) {
		$thisid = $data[$parameters[2]];
		}
		else {
		$thisid = 0;
		}
		$ethm = new EthmData();
		return !$ethm->existIPandPort($ip, $port, $thisid);
    }

}