<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Hash, Auth;
use App\User;

class ConnectController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except(['getLogout']); //cualquier metodo que se ejecute requiere que el usuario sea visitante
    }

    public function getLogin(){ //acción de logiar

        return view('connect.login');
    }


     public function postLogin(Request $request){ //acción de logiar
        $rules =[
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];

        $menssage =[
            'email.required' => 'Su correo electrónico es requerido.',
            'email.email' => 'El formato de su correo electrónico es invalido',
            'password.required' => 'Por favor escriba una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres'
        ];

        $validator = Validator::make($request->all(), $rules, $menssage); //para que se comporte como uno desee- rules regla de validacion 
        if($validator->fails()):
            return back()->withErrors($validator) -> with('message', 'Se ha producido un error.')->with(
                'typealert', 'danger');
        else:
            //validar la informacion que el usuario ingrese sea correcta
            if(Auth::attempt(['email'=> $request-> input('email'), 'password' => $request->input('password')], true)):
                return redirect('/');
            else:
                return back()->withErrors($validator) -> with('message', 'Correo electrónico o contraseña erronea.')->with(
                'typealert', 'danger');
            endif;
        endif;
    }


    public function getRegister(){ //acción de registrar 

        return view('connect.register');
    }

    public function postRegister(Request $request){ //acción de 
        $rules =[
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password'
        ];

        $menssage =[
            'name.required' => 'Su nombre es requerido.',
            'lastname.required' => 'Su apellido es requerido.',
            'email.required' => 'Su correo electrónico es requerido.',
            'email.email' => 'El formato de su correo electrónico es invalido',
            'email.unique' => 'Ya existe un usuario con este correo electrónico',
            'password.required' => 'Por favor escriba una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'cpassword.required' => 'Es necesario confirmar la contraseña',
            'cpassword.min' => 'La confirmación de la contraseña debe tener al menos 8 caracteres',
            'cpassword.same' => 'Las contraseña no coinciden'
        ];

        $validator = Validator::make($request->all(), $rules, $menssage); //para que se comporte como uno desee- rules regla de validacion 
        if($validator->fails()):
            return back()->withErrors($validator) -> with('message', 'Se ha producido un error.')->with(
                'typealert', 'danger');
        else:
            $user = new User;
            $user->name = e($request->input('name'));
            $user->lastname = e($request->input('lastname'));
            $user->email = e($request->input('email'));
            $user->password = Hash::make($request->input('password')); 

            if($user->save()):
                return redirect('/login')->with('message', 'Su usuario se creo con éxito, ahora
                    puede iniciar sesión')->with( 'typealert', 'success');
            endif;

        endif;
    }

    public function getLogout(){
        Auth::logout();
        return redirect('/');
    }
}
