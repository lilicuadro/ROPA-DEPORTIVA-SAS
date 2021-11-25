<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __Construct(){
       $this->middleware('auth'); //verificar que el usuario este conectado
       $this->middleware('isadmin');

    }

    public function getUsers(){ //logica de la base de dato y la lista
        $users = User::orderBy( 'id', 'Desc')->get();
        $data = ['users'=> $users]; //pasamos los usuarios que estan en la base de datos
        return view('admin.users.home', $data);
    }
}
