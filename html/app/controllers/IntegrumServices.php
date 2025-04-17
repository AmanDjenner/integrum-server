<?php

//Zamapowanie URL dla WildFly
class IntegrumServices extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /** Zamapowanie URL dla WildFly
     * http://localhost:8080/integrumservices/manageintegra
     * {"integra":{"id":"0"},"operation":0}
     */
    public static function manageIntegra($i, $o)
    {
        $table      = 'integra/'.$i.'/manage/'.$o;
        $restClient = new RestClient();

        print "Wyslane manageintegra: <br />";
        $restClient->post([], $table, $table);
        print $restClient->getContent();
    }

    public static function manageIntegrum($o)
    {
        return $this->manageIntegra(0, $o);
    }

    /** Zamapowanie URL czyszczącego cache WildFly */
    public function evictAll()
    {
        //integrumservices/evictAll
        $restClient = new RestClient();

        print "Wyslane evictall: <br />";
        $restClient->get("evictall", "evictall");
        if (!(App::environment(Config::get('parameters.localPort'))||!Config::get('parameters.useCache',true))) {
            Cache::flush();
        }
    }

}
