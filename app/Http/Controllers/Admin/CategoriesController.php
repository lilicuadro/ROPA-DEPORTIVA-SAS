<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Http\ Models\Category;
use Validator,Str;

class CategoriesController extends Controller
{
    //
    public function __Construct(){
       $this->middleware('auth'); //verificar que el usuario este conectado
       $this->middleware('isadmin');

    }

    public function getHome($module){
        $cats =Category::where('module',$module)->orderBy('name','Asc')->get();
        $data = ['cats' => $cats];
        return view('admin.categories.home', $data);
    }

    public function postCategoryAdd(Request $request){ //validar que se llene la informacion de la tabla

         $rules =[
            'name' => 'required',
            'ico' => 'required',
        ];
        $messages = [
            'name.required' => 'Se requiere de un nombre para la categoria',
            'ico.required' => 'Se requiere de un icono para la categoria',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()):
            return back()->withErrors($validator) -> with('message', 'Se ha producido un error.')->with('typealert', 'danger');
        else:
            $c= new Category;
            $c->module =$request->input('module');
            $c->name = e($request->input('name'));
            $c->slug = Str::slug($request->input('name'));
            $c->icono = e($request->input('ico'));
            if($c->save()):
                return back()-> with('message', 'Guardado con éxito.')->with('typealert', 'success');
            endif;
        endif;
       
    }
}
