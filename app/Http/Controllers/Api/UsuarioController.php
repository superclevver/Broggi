<?php

namespace App\Http\Controllers\Api;

use App\Models\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clases\Utilitat;

use  App\Http\Resources\usuarioResource;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Usuario = Usuario::all();
        return new usuarioResource($Usuario);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new Usuario();

        $usuario->codi = $request->input("codi");
        $usuario->nom = $request->input("nom");
        $usuario->contrasenya = $request->input("contrasenya");
        $usuario->rols_id = $request->input("rols_id");

        try {
            $usuario->save();
            $respuesta = (new usuarioResource($usuario))->
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
        //
        $Usuario = Usuario::with('rol')->find($id);
        return new usuarioResource($Usuario);
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
        $usuario = Usuario::find($id);

        if ($usuario == null) {
            $respuesta = response()->
                         json(["error" => "Registro no encontrado"], 404);
        } else {
            try {
                $usuario->codi = $request->input("codi");
                $usuario->nom = $request->input("nom");
                $usuario->contrasenya = $request->input("contrasenya");
                $usuario->rols_id = $request->input("rols_id");
                
                $usuario->update();
                $respuesta = (new usuarioResource($usuario))->
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
        $usuario = Usuario::find($id);

        if ($usuario == null) {
            $respuesta = response()->
                         json(["error" => "Registro no encontrado"], 404);
        } else {
            try {
                $usuario->delete();
                $respuesta = (new usuarioResource($usuario))->
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
