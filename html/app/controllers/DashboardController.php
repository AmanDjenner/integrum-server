<?php

class DashboardController extends \BaseController
{

    public function __construct()
    {
        Session::flash('currentRouteName', 'dashboard');
    }

    public function index()
    {
        $settings = Config::get('parameters.overallDashBoard');
        foreach ($settings['initData'] as $key => $val) {
            $settings['initData'][$key]['label'] = Lang::get($val['label']);
        }
		$hierarchy = new HierarchyController();
		$currRegion = HierarchyController::getSessionData();
        return View::make('dashboard.index')
                ->with('token', Session::token())
                ->with('sideRegionVars', $hierarchy->getSideRegionData())
                ->with('navbarVars', $this->navbarVarsDefault(true, true))
                ->with('permMapEdit', UserPermissions::containsForRegion('EDTMAP', $currRegion->getQueryIdx()))
                ->with('permExtraAuth', Config::get('parameters.authBeforeAction', false))
                ->with('currentHierarchy', $currRegion)
                ->with('buttons', $settings['buttons'])
                ->with('dashboardEvent', $settings['eventTitles'])
                ->with('eventComments', UserPermissions::containsForRegion('COMLATEREVENTS', $currRegion->getQueryIdx()))
                ->with('showEventDialog', UserPermissions::containsForRegion('COMEVENTS', $currRegion->getQueryIdx()) && Config::get('parameters.showEventDialog', 'false'))
                ->with('initData', json_encode($settings['initData']))
                ->with('helpcnt', 'ekran-tablica-informacyjna.html');
    }

    public function index2()
    {
        $settings = Config::get('parameters.overallDashBoard');
        foreach ($settings['initData'] as $key => $val) {
            $settings['initData'][$key]['label'] = Lang::get($val['label']);
        }
		$hierarchy = new HierarchyController();
		$currRegion = HierarchyController::getSessionData();
        return View::make('dashboard.index2')
                        ->with('sideRegionVars', $hierarchy->getSideRegionData())
                        ->with('navbarVars', $this->navbarVarsDefault(true))
                        ->with('permMapEdit', UserPermissions::containsForRegion('EDTMAP', $currRegion->getQueryIdx()))
                        ->with('permExtraAuth', Config::get('parameters.authBeforeAction', false))
                        ->with('currentHierarchy', $currRegion)
                        ->with('token', Session::token())
                        ->with('initData', json_encode($settings['initData']))
                        ->with('helpcnt', 'ekran-tablica-informacyjna.html');
    }
    public function eventsqueueadded($id) {
        $queue = $this->myqueue();
        if (!in_array($id, $queue)) {
            Session::push('myqueue', $id);
        }
    }
    public function eventsqueueremoved($id) {
        $queue = $this->myqueue();
        Session::put('myqueue', array_diff($queue,[$id]));
    }
    function myqueue() {
        $x = [];
        foreach(Session::get('myqueue', []) as $v) {
            array_push($x,(int)$v);
        }
        return $x;
    }
    public function unhandledEvents(){
        $event = new EventData();
        
        $unh = array('my'=>$this->myqueue(), 'evnt'=>$event->getUnhandled());
        return Response::json($unh);
    }
    private function setupIdAccessGroupUser($idAccessGroupUser){
        $defAccessGroupUser = UserContext::getUserRegions();
        if (empty($idAccessGroupUser)) {
            if (!empty($defAccessGroupUser)) {
                return $defAccessGroupUser;
            } else {
                return 1;
            }
        }
		return $idAccessGroupUser;
    }
    public function overallstate($withChildren, $idAccessGroupUser)
    {
        $mode = Config::get('parameters.dashboardMode', 'integra');
        $idAccessGroupUserX = self::setupIdAccessGroupUser($idAccessGroupUser);
        $dashboard = new DashboardData();
        return $dashboard->overallstate($mode, $idAccessGroupUserX);
    }

    public function events($id, $idAccessGroupUser)
    {
        $json              = Config::get('parameters.eventDashBoard.' . $id);
        $eventDashBoard    = json_decode($json, true);
        $idAccessGroupUserX = self::setupIdAccessGroupUser($idAccessGroupUser);
        $e = new DashboardData();
        return $e->events($idAccessGroupUserX, $eventDashBoard);
    }

    public function filter($system, $id, $idAccessGroupUser)
    {
        $json              = Config::get('parameters.detailDashBoard.' . $system . $id);
        $eventDashBoard    = json_decode($json, true);
        $idAccessGroupUserX = self::setupIdAccessGroupUser($idAccessGroupUser);
        
        $e = new DashboardData();
        return $e->filter($idAccessGroupUserX, $system, $eventDashBoard);
    }

    public function detail($system, $id)
    {
        $e = new DashboardData();
        return Response::json($e->detail($system, $id));
    }

}
