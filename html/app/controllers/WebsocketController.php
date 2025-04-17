<?php

class WebsocketController extends \BaseController
{

    public function options()
    {
        $settings          = Config::get('parameters.websocket');
        $settings["token"] = Session::get("mapToken");
        $settings["lang"]  = Config::get('app.locale');
        return Response::json($settings);
    }

}
