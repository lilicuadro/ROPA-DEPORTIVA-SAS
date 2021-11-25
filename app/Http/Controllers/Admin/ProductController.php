<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\ Models\Category, App\Http\ Models\Product;

use Validator, Str, Config, Image;

class ProductController extends Controller
{
    public function __Construct(){
       $this->middleware('auth'); //verificar que el usuario este conectado
       $this->middleware('isadmin');

    }

    public function getHome(){
        $products = Product::orderBy('id', 'desc')->paginate(25);
        $data = ['products' => $products];
        return view('admin.products.home', $data);
    }

    public function getProductAdd(){
        $cats = Category::where('module', '0')->pluck('name', 'id');
        $data = ['cats' => $cats];
        return view('admin.products.add', $data);
    }

    public function postProductAdd(Request $request){
        $rules=[
            'name' => 'required',
            'img' => 'required',
            'price' => 'required',
            'content' => 'required',
        ];

        $message = [
            'name.required' => 'El nombre del producto requerido',
            'img.required' => 'Seleccione una imagen destacada',
            'img.img' => 'El archivo no es una imagen',
            'price.required' => 'Ingrese el precio del producto',
            'content.required' => 'Ingrese una descripción del producto',
        ]; 
        $validator = Validator::make($request->all(),$rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator) -> with('message', 'Se ha producido un error.')->with('typealert', 'danger')->withInput();
        else:
            
            $path ='/'.date('Y-m-d');
            $fileExt = trim($request->file('img')->getClientOriginalExtension());
            $uploas_path = Config::get('filesystems.disks.uploads.root');
            $name= Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
            $filename = rand(1,999).'-'.$name.'.'.$fileExt;
            $file_file = $uploas_path.'/'.$path.'/'.$filename;
            
          

//guardar la informacion
            $product = new Product;
            $product->status = '0';
            $product->name = e($request->input('name'));
            $product->slug = Str::slug($request->input('name'));
            $product->category_id = $request->input('category');
            $product->file_path = date('Y-m-d');
            $product->image = $filename;
            $product->price = $request->input('price');
            $product->in_discout = $request->input('indiscount');
            $product->discout = $request->input('discount');
            $product->content = e($request->input('content'));

            if($product->save()):
                if($request->hasFile('img')):
                $fl= $request->img->storeAs($path, $filename, 'uploads');
                $img = Image::make($file_file);
                $img->fit(256,256, function($constraint){
                    $constraint->upsize();
                });
                $img->save($uploas_path.'/'.$path.'/t_'.$filename);
                endif;
                return redirect('admin/products')-> with('message', 'Guardado con éxito.')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getProductEdit($id){
        $p =Product::find($id);
        $cats = Category::where('module', '0')->pluck('name', 'id');
        $data = ['cats' => $cats, 'p' => $p];
        return view('admin.products.edit', $data);
    }

    public function postProductEdit($id, Request $request){
         $rules=[
            'name' => 'required',
            'price' => 'required',
            'content' => 'required',
        ];

        $message = [
            'name.required' => 'El nombre del producto requerido',
            'img.img' => 'El archivo no es una imagen',
            'price.required' => 'Ingrese el precio del producto',
            'content.required' => 'Ingrese una descripción del producto',
        ]; 
        $validator = Validator::make($request->all(),$rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator) -> with('message', 'Se ha producido un error.')->with('typealert', 'danger')->withInput();
        else:

//guardar la informacion
            $product = Product::find($id);
            $product->status = $request->input('status');
            $product->name = e($request->input('name'));
            $product->category_id = $request->input('category');
            if($request->hasFile('img')):
            $path ='/'.date('Y-m-d');
            $fileExt = trim($request->file('img')->getClientOriginalExtension());
            $uploas_path = Config::get('filesystems.disks.uploads.root');
            $name= Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
            $filename = rand(1,999).'-'.$name.'.'.$fileExt;
            $file_file = $uploas_path.'/'.$path.'/'.$filename;
                $product->file_path = date('Y-m-d');
                $product->image = $filename;
            endif;
            $product->price = $request->input('price');
            $product->in_discout = $request->input('indiscount');
            $product->discout = $request->input('discount');
            $product->content = e($request->input('content'));

            if($product->save()):
                if($request->hasFile('img')):
                $fl= $request->img->storeAs($path, $filename, 'uploads');
                $img = Image::make($file_file);
                $img->fit(256,256, function($constraint){
                    $constraint->upsize();
                });
                $img->save($uploas_path.'/'.$path.'/t_'.$filename);
                endif;
                return back()-> with('message', 'Actualizado con éxito.')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getProductDelete($id){
         $product = Product::find($id);
        if($product->delete()):
            return back()-> with('message', 'Borrado con éxito.')->with('typealert', 'success');
        endif;
    }
}
