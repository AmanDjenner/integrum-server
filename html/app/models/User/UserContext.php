<?php

/**
 * Description of UserContext
 *
 * @author mkiedrowski
 */
class UserContext extends UserPermissions
{
	public static function clear() {
            Session::forget('loginUser');
            Session::forget('nameUser');
            Session::forget('surnameUser');
            Session::forget('allUserData');
	}
	
	public static function init($user){
            Session::put('loginUser', $user->login);
            Session::put('nameUser', $user->name);
            Session::put('surnameUser', $user->surname);
            Session::put('allUserData', $user);
            Session::put('idAccessGroupUser', UserContext::extractUserRegions($user));
	}
	
	public static function getUserRegions(){
		$user = Session::get('allUserData');
		if ($user == null) {
			return NULL;
		}
		$regs = [];
		foreach($user->accessRights as $regRights) {
			$regs = array_merge($regs, $regRights->regionQryIdxs);
		}
		return $regs;
	}
	static function extractUserRegions($user){
            $regs = [];
            foreach($user->accessRights as $regRights) {
                $regs = array_merge($regs, $regRights->regions);
            }
            return $regs;
	}
	
		
	public static function getAllRegions($default = ['1#']){
            //TODO fix here only one
            return Session::has('idAccessGroupUser') ? Session::get('idAccessGroupUser')
            : $default;
	}
	
	public static function getDefaultRegion($default = '1#'){
            //TODO fix here only one
            return Session::has('idAccessGroupUser') ? Session::get('idAccessGroupUser')[0]
            : $default;
	}
}
