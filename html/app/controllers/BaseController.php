<?php

class BaseController extends Controller
{

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
	
	public static function getMessage($messageId) {
		$message = Config::get('messages.' . $messageId);
		if (!is_array($message)) {
			return $messageId;
		} else  {
			$message["message"] = Lang::get('messages.' . $message["message"]);
			return $message;
		}
	}
	
	public static function getMessageText($messageId) {
		$message = Config::get('messages.' . $messageId);
		if (!is_array($message)) {
			return $messageId;
		} else  {
		return Lang::get('messages.' . $message["message"]);
		}
	}
	
    protected function message($view)
    {
        if (Session::has('message')) {
             return $view->with('message', BaseController::getMessage(Session::get('message')))
                         ->with('messageDetail',Session::get('messageDetail',NULL));
        }
        return $view;
    }

	protected function navbarVars($showUsers, $showPanels, $showEvents, $showDashboard, $admProfile, $admRegions, $admRoles, $admEvents, $showRegions=true, $showDropDownArrow=false){
		return ['showDropDownArrow'=>$showDropDownArrow,'showUsers'=>$showUsers,'showPanels'=>$showPanels,'showEvents'=>$showEvents, 'showDashboard'=>$showDashboard, 'showRegions'=>$showRegions, 'admProfile'=>$admProfile, 'admRegions' => $admRegions, 'admRoles'=>$admRoles, 'admEvents'=>$admEvents];
	}
	protected function navbarVarsDefault($showRegions=true, $showDropDownArrow=false){
		return $this->navbarVars(UserPermissions::contains('SELUSER'),UserPermissions::contains('SELINTEGRA'),UserPermissions::contains('SELEVENTS'),UserPermissions::contains('SELDASHBOARD'),UserPermissions::contains('MANPROFILE'), UserPermissions::contains('MANREGION'), UserPermissions::contains('MANROLES'), 1, $showRegions, $showDropDownArrow);
	}
	protected function navbarVarsAdmin($showRegions=false, $showDropDownArrow=false){
		return $this->navbarVars(UserPermissions::contains('SELUSER'),UserPermissions::contains('SELINTEGRA'),UserPermissions::contains('SELEVENTS'),UserPermissions::contains('SELDASHBOARD'),UserPermissions::contains('MANPROFILE'), UserPermissions::contains('MANREGION'), UserPermissions::contains('MANROLES'), 1, $showRegions, $showDropDownArrow);
	}
}