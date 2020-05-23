<?php

namespace App\Http\Controllers\Auth;

// use App\User;
use App\Models\Rols;
use App\Models\Usuario;
use App\Clases\Utilitat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use App\Providers\RouteServiceProvider;
use Illuminate\Database\QueryException;
use  App\Http\Resources\RegisterResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegister()
    {
        $rols = $this->getRoles();

        return view('auth.register')->with('rols', $rols);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nom' => ['required', 'string', 'max:45'],
            'codi' => ['required', 'string', 'max:45', 'unique:users'],
            'rol' => ['required', 'string', 'min:7', 'max:256', 'confirmed'],
            'contrasenya' => ['required', 'string', 'min:7', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Usuario
     */
    // @return \App\User

    public function create(Request $request)
    {
        $nom = $request->input('nom');
        $codi = $request->input('codi');
        $contrasenya = $request->input('contrasenya');
        $rols_id = $request->input('cbRol');

        Usuario::create([
            'nom' => $nom,
            'codi' => $codi,
            'contrasenya' => $contrasenya,
            'rols_id' => $rols_id,
        ]);

        return redirect('login')->withInput();
    }

    public function store(Request $request)
    {
        $usuario = new Usuario();

        $usuario->codi = $request->input('codi');
        $usuario->nom = $request->input('nom');
        $usuario->contrasenya = $request->input('contrasenya');
        $usuario->rols_id = $request->input('cbRol');

        try
        {
            $usuario->save();
            $respuesta = (new RegisterResource($usuario))->response()->setStatusCode(201);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitat::errorMessage($e);
            $respuesta = response()->json(["error" => $mensaje], 400);
        }
        return $respuesta;
    }

    public function index()
    {
        $usuario = Usuario::all();
        return new RegisterResource($usuario);
    }

    public function getRoles() {
        $rols = Rols::all()->sortByDesc('id');

        return $rols;
    }

}


