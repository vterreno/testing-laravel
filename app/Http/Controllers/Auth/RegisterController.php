<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z]{2,}$/i'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $service = app('JavaAuthService');
        $full_name = $data['name'];
        $name_parts = explode(' ', $full_name);
        $name = isset($name_parts[0]) ? $name_parts[0] : '';
        $lastname = isset($name_parts[1]) ? $name_parts[1] : '';

        $register_data = [
            'name' => $name,
            'lastname' => $lastname,
            'email' => $data['email'],
            'username' => $data['email'],
            'password' => $data['password'],
            'role' => 'user'
        ];
        
        $response = $service->register($register_data);
        Log::info($response);

        if ($response == 200) {
            return 200;
        } else {
            return 400;
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $response = $this->create($request->all());
        if ($response == 200) {
            Flash::success('Usuario registrado correctamente');
            return redirect()->route('login');
        } else {
            Flash::error('Error al registrar el usuario');
            return redirect()->route('register');
        }
    }
}
