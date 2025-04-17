<?php

class VersionController extends \BaseController
{

    public function index($force = 0)
    {
        $access = Permission::accessList();
		$hierarchy = new HierarchyController();
		$currRegion = HierarchyController::getSessionData();
        $data   = View::make('version.index')
				->with('sideRegionVars', $hierarchy->getSideRegionData())
				->with('navbarVars', $this->navbarVarsAdmin())
				->with('permLicenseManage', UserPermissions::contains('LICMANAGE'))
                ->with('webver', $this->versionInternal(0))
				->with('currentHierarchy', $currRegion)
                ->with('force', $force)
                ->with('version', Config::get('version.number'))
                ->with('licensescount', $this->licensescount())
                ->with('helpcnt', 'ekran-status.html');
		return $this->message($data);
    }
	
    function versionInternal($package = 0)
    {
        $v = new Version();
        return $v->find($package)->toArray();
    }

    function version($package = 0)
    {
        return Response::json($this->versionInternal($package));
    }

    function getLicenseRequest()
    {
        $param                          = array();
        $param["hierarchytreeid"]       = "1";
        $param["notAssigned"]           = "false";
        $param["withHierarchyChildren"] = "true";
        $param["version"]               = "false";
        $param["mac"]                   = "false";
        //$param["license"]               = "false";
        $param["offset"]                = 0;
        $e                              = new EthmData();
        $list                           = $e->filtered($param, HierarchyController::getSessionData()->getQueryIdx());
        $fileText                       = "";
        if ($list != null) {
            foreach ($list as $et) {
                $fileText .= $et["macORimei"] . ";" . $et["integra"] . " " . $et["ip"] . ":" . $et["guardPort"] . "\n";
            }
        }
        $myName  = "integrum.slr";
        $headers = ['Content-type'        => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"',
                    $myName),
            'Content-Length'      => strlen($fileText)];
        return Response::make($fileText, 200, $headers);
    }

    function licensescount()
    {
        $v = new Version();
        return $v->getLicenseCount();
    }

    function store()
    {
        $file      = array('licfile' => Input::file('licfile'));
        $force     = Input::get('force');
        // setting up rules
        $rules     = array('licfile' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return Redirect::to('/status')->withInput()->withErrors($validator);
        } else {
            // checking file is valid.
            if (Input::file('licfile')->isValid()) {
                $rr     = new RestClient();
                $result = $rr->curlUpload('license/upload/' . (isset($force) ? $force : 0),
                        file_get_contents(Input::file('licfile')->getRealPath()));
                $j      = json_decode($result);
				if (is_object($j) && property_exists($j,"message")) {
                Session::flash("message", $j->message);
                Session::flash("alert", $j->result == 1 ? "info" : "danger");
                Session::flash("extraMessage", $j->extraInfo);
				} else {
                Session::flash("message", BaseController::getMessageText('errorAll'));
                Session::flash("alert", "danger");
                Session::flash("messageDetail", $j);
				}
                return Redirect::to("/status");
            }
        }
    }

}
