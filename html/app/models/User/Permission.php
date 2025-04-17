<?php

/**
 * Description of Permission
 *
 * @author karolsz
 */
class Permission
{

    /**
     *
     * @param type $id In: {"userid":(int), integraid:int, objectid:int} }
     * @return array
     */
    static public function userGet($integraIdUser, $integraId = null, $objectId = null)
    {
        $response    = new RestClient;
        $tableMaster = 'integra/'.$integraId.'/users/'.$integraIdUser;
        $response->get($tableMaster, FALSE);
        $json        = $response->getContent();
        $result      = json_decode($json, TRUE);
        if (1 == $result['result'] && isset($result['permissionUserGet'])) {
            return $result['permissionUserGet'];
        }
        return array("userType" => null, "partitionList" => array(), "accessList" => array());
    }

    /**
     * Zwraca Listę central do których
     * użytkownik ma jakie kolwiek uprawnienia
     *
     * @param int $userId
     * @return array
     */
    static public function userPanels($userId)
    {
        $response   = new RestClient();
        $methodName = 'appuser/'.$userId.'/panels';
        $ids        = array();
        $response->get($methodName, FALSE);
        $result     = json_decode($response->getContent(), TRUE);
        if (1 == $result['result'] && isset($result['panels'])) {
            foreach ($result['panels'] as $panel) {
                $ids[$panel["id"]] = $panel;
            }
        }
        return $ids;
    }

    /**
     * Typ użytkownika
     * permissionusertypelist
     */
    static public function userTypeList()
    {
        $response    = new RestClient;
        $type        = array();
        $tableMaster = 'permissionusertypelist';
        $curlPostDat = array();
        $response->get($tableMaster, $tableMaster, 10);
        $data        = json_decode($response->getContent(), TRUE);
        return $data['typeList'];
    }

    /**
     * Uprawnienia / Dostępy
     * permissionaccesslist
     */
    static public function accessList()
    {
        $response    = new RestClient;
        $tableMaster = 'permissionaccesslist';
        $curlPostDat = array();
        $response->get($tableMaster, $tableMaster, 10);
        $data        = json_decode($response->getContent());
        return $data->accessList;
    }

    /**
     * Profile
     * permissionprofile list
     * {"profileList":[{"id":(id),"name":"String"},{"id":(id),"name":"String"}]}
     */
    static public function profileList($firstText)
    {
        $response    = new RestClient;
        if (NULL!=$firstText) {
        $profile[0]  = array('name'=>$firstText, 'id'=>'0', 't'=>'');
        } else {
            $profile=[];
        }
        $tableMaster = 'permissionprofile';
        $response->get($tableMaster, $tableMaster, 10);
        $data        = json_decode($response->getContent(), TRUE);
        foreach ($data['list'] as $profileData) {
            $profile[$profileData['id']] = array('name'=>$profileData['name'], 'id'=>$profileData['id'], 't'=>$profileData['type']);
        }
        return $profile;
    }

    /**
     * Użytkownicy/Edycja/Aplikacja
     * @return role: {"role":[{"id":1,"name":"ComboBox"},{"id":2,"name":"ComboBox 2"}]}
     */
    static public function appUserRoleList()
    {
        $response    = new RestClient;
        $tableMaster = 'permissionroles';
        $response->get($tableMaster, $tableMaster, 10);
        $data        = json_decode($response->getContent(), TRUE);
        foreach ($data['list'] as $profileData) {
            $profile[$profileData['id']] = array('name'=>$profileData['name'], 'id'=>$profileData['id']);
        }
        return $profile;
    }

}
