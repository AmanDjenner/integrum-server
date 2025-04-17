<?php

/**
 * Description of UserPermissions
 *
 * @author mkiedrowski
 */
class UserPermissions
{
    public static function clear() {
            Session::forget('userPermissions');
    }

    public static function setPermissions($permissions, $allRights, $regions) {
            Session::put('userPermissions', $permissions);
            Session::put('userPermissionsRegions', $regions);
            Session::put('userPermissionsAll', $allRights);
    }

    public static function getPermissions(){
            return Session::get('userPermissions', []);
    }

    public static function getPermissionsAll(){
            return Session::get('userPermissionsAll', []);
    }
    
    static public function contains($permCode)
    {
        return in_array($permCode,UserPermissions::getPermissions(), TRUE);
    }

    static public function containsAny(...$permCodes)
    {
        return containsAnyFromArray($permCodes);
    }

    static public function containsAnyFromArray(array $permCodes)
    {
        foreach ($permCodes as $permCode) {
            if (self::contains($permCode)) {
                return TRUE;
            }
        }
        return FALSE;
    }
    static public function getPermissionsForRegion($region) {
        $rights = UserPermissions::getPermissionsAll();
        $perm = null;
        $permlen = null;
        foreach($rights as $k => $v) {
            if (strlen($region) >= strlen($k) && 
                substr($region, 0, strlen($k))==$k &&
                $permlen<strlen($k)) {
                //return $v;
                $perm = $v;
                $permlen = strlen($k);
            }
        }
        return $perm;
    }
    static public function containsForRegion($permCode, $queryIdx) {
        $h = new HierarchyData();
        $region = $h->getByQry($queryIdx)['id'];
        if ($region == 0) {
            return in_array($permCode, self::getPermissions(), TRUE);
        } else {
            $permission = self::getPermissionsForRegion($queryIdx);
            if (!isset($permission)){
                return FALSE;
            }
        }
        return in_array($permCode, $permission, TRUE);
    }
}
