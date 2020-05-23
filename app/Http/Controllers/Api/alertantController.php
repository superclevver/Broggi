<?php

namespace App\Http\Controllers\Api;

use App\Models\Alertant;
use App\Models\Municipi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clases\Utilitat;

use  App\Http\Resources\alertantResource;

class alertantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alertant = Alertant::all();
        return new alertantResource($alertant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alertant = new Alertant();

        $alertant->nom = $request->input("nom");
        $alertant->cognoms = $request->input("cognoms");
        $alertant->adreca = $request->input("adreca");
        $alertant->municipis_id = $request->input("municipis_id");
        $alertant->telefon = $request->input("telefon");
        $alertant->tipus_alertant_id = $request->input("tipus_alertant_id");

        try
        {
            $alertant->save();
            $respuesta = (new alertantResource($alertant))->
                          response()->
                          setStatusCode(201);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilidad::ErrorMessage($e);
            $respuesta = response()->
                         json(["error" => $mensaje], 400);
        }

        return $respuesta;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function show(Alertant $alertant)
    {
        $alertant = Alertant::with('municipi')->with('tipusAlertant')->find($alertant->id);

        return new alertantResource($alertant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $alertant = Alertant::find($id);

        if ($alertant == null) {
            $respuesta = response()->
                         json(["error" => "Registro no encontrado"], 404);
        }
        else {
            try
            {
                $alertant->nom = $request->input("nom");
                $alertant->cognoms = $request->input("cognoms");
                $alertant->adreca = $request->input("adreca");
                $alertant->municipis_id = $request->input("municipis_id");
                $alertant->telefon = $request->input("telefon");
                $alertant->tipus_alertant_id = $request->input("tipus_alertant_id");

                $alertant->update();
                $respuesta = (new alertantResource($alertant))->
                            response()->
                            setStatusCode(200);
            }
            catch (QueryException $e)
            {
                $mensaje = Utilidad::ErrorMessage($e);
                $respuesta = response()->
                            json(["error" => $mensaje], 400);
            }
        }

        return $respuesta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alertant = Alertant::find($id);

        if ($alertant == null)
        {
            $respuesta = response()->
                         json(["error" => "Registro no encontrado"], 404);
        }
        else {
            try
            {
                $alertant->delete();
                $respuesta = (new alertantResource($alertant))->
                            response()->
                            setStatusCode(201);
            }
            catch (QueryException $e)
            {
                $mensaje = Utilidad::ErrorMessage($e);
                $respuesta = response()->
                            json(["error" => $mensaje], 400);
            }
        }

        return $respuesta;
    }
}
