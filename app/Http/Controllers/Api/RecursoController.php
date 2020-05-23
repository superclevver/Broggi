<?php

namespace App\Http\Controllers\Api;

use App\Models\Recurs;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clases\Utilitat;

use  App\Http\Resources\recursoResource;

class recursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Recurs = Recurs::all();
        return new recursoResource($Recurs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recurs = new Recurs();

        $recurs->codi = $request->input("codi");
        $recurs->tipus_recurs_id = $request->input("tipus_recurs_id");
        $recurs->id_usuario = $request->input("id_usuario");

        try {
            $recurs->save();
            $respuesta = (new recursoResource($recurs))->
                          response()->
                          setStatusCode(201);
        } catch (QueryException $e) {
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
    public function show($id)
    {
        $Recurs = Recurs::with('tipus_recurs')->find($id);
        return new recursoResource($Recurs);
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
        $recurs = Recurs::find($id);

        if ($recurs == null) {
            $respuesta = response()->
                         json(["error" => "Registro no encontrado"], 404);
        } else {
            try {
                if (!$request->input("codi")) {
                    $recurs->codi = $recurs->codi;
                } else {
                    $recurs->codi = $request->input("codi");
                }

                if (!$request->input("tipus_recurs_id")) {
                    $recurs->tipus_recurs_id = $recurs->tipus_recurs_id;
                } else {
                    $recurs->tipus_recurs_id = $request->input("tipus_recurs_id");
                }
                $recurs->id_usuario = $request->input("id_usuario");
                
                $recurs->update();
                $respuesta = (new recursoResource($recurs))->
                            response()->
                            setStatusCode(200);
            } catch (QueryException $e) {
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
        $recurs = Recurs::find($id);

        if ($recurs == null) {
            $respuesta = response()->
                         json(["error" => "Registro no encontrado"], 404);
        } else {
            try {
                $recurs->delete();
                $respuesta = (new recursoResource($recurs))->
                            response()->
                            setStatusCode(201);
            } catch (QueryException $e) {
                $mensaje = Utilidad::ErrorMessage($e);
                $respuesta = response()->
                            json(["error" => $mensaje], 400);
            }
        }

        return $respuesta;
    }
}
