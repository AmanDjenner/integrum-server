<?php

class UserProperties
{

    /**
     * Sprawdza czy użytkownik już istnieje w bazie
     * isusernameexists
     * In {conditionText:"String", userId:(int) } Out {"exist" : boolean, "result" : int}
     */
    static public function isUserNameExists($name, $id)
    {
        $response    = new RestClient;
        $tableMaster = 'appuser/' . (isset($id)?$id:0) . '/login/' . urlencode($name);
        $response->get($tableMaster, $tableMaster, 0);
        $data        = json_decode($response->getContent(), TRUE);
        return $data['exist'];
    }

    /**
     * Sprawdza czy kod już istnieje w bazie
     * /isusercodeexists
     * {conditionText : String} Out {exist : boolean, result : int}
     */
    static public function isUserCodeExists($code, $id)
    {
        $response    = new RestClient;
        $tableMaster = 'appuser/'. (isset($id)?$id:0) .'/existscode';
        $curlPostDat = array('conditionText' => $code);
        $response->post($curlPostDat, $tableMaster, $tableMaster, 0);
        $data        = json_decode($response->getContent(), TRUE);
        return $data['exist'];
    }

    /**
     * Sprawdza czy login już istnieje w bazie
     * /appuser/{id}/login/exists/{newlogin}
     * {conditionText : String} Out {exist : boolean, result : int}
     */
    static public function isLoginExists($login, $id)
    {
        $response    = new RestClient;
        $tableMaster = 'appuser/'.$id .'/login/exists/'. urlencode( $login);
        $response->get($tableMaster, $tableMaster, 0);
        $data        = json_decode($response->getContent(), TRUE);
        return $data['exist'];
    }
}