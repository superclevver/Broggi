<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Rols;

class HomeController extends Controller
{
    public function comprovarRol()
    {
        // Recurs Mobil -> menu1
        // CECOS, Admin -> menu2

        if (Auth::user()) {
            $id_rol = Auth::user()->rols_id;
            
            $user = new Usuario();
            $user->id = Auth::user()->id;
            $user->nom = Auth::user()->nom;
            $user->contrasenya = Auth::user()->contrasenya;
            $user->rols_id = Auth::user()->rols_id;
            setcookie('user_id', Auth::id(), null ,'/');
            // $id_rol = $user->rols_id;
            $rol = Rols::where('id', $id_rol)->first();

            $rol_nom = $rol->nom;

            if ($rol_nom == 'Recurs Mòbil') {
                return redirect('/recurs-mobil');
            }
            else if ($rol_nom == 'CECOS') {
                return redirect('/cecos');
            }
            else if ($rol_nom = 'Admin') {
                return redirect('/admin');
            }
            else {
                return redirect('login')->withInput();
            }
        }
        else {
            return redirect('login')->withInput();
        }

    }
}
