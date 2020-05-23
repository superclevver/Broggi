<?php

namespace App\Http\Controllers\Api;

use App\Models\Afectats;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clases\Utilitat;

use  App\Http\Resources\afectantResource;

class afectatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Afectats = Afectats::all();
        return new afectantResource($Afectats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            //
        ;
        $Afectats = Afectats::with('Municipi')->find($id);
        return new afectantResource($Afectats);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Afectats $alertant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Afectats $alertant)
    {
        //
    }
}
