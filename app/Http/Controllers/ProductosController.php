<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Image;
use PDF;

class ProductosController extends Controller
{
    public function index()
    {
        return view('productos');
    }

    public function imprimir()
    {
        $productos = \DB::table('productos')
        ->select('productos.*')
        ->orderBy('stock','ASC')
        ->take(10)
        ->get();
        $fecha = date('Y-m-d');
        $data = compact('productos', 'fecha');
        $pdf = PDF::loadView('pdf.reporteproductos',$data);
        return $pdf->download('reporte'.time().'.pdf');
        //return $pdf->stream();
    }

    public function all(Request $request)
    {
        $productos = \DB::table('productos')
        ->select('productos.*')
        ->orderBy('stock','ASC')
        ->take(10)
        ->get();
        return response(json_encode($productos),200)->header('Content-type','text/plain');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required|min:3|max:20',
            'img' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'stock' => 'required',
            'codigo' => 'required'
        ]);
        if($validator ->fails()){
            return back()
            ->withInput()
            ->with('ErrorInsert', 'Favor de llenar todos los campos')
            ->withErrors($validator);
        }else{
            $imagen = $request->file('img');
            $nombre = time().'.'.$imagen->getClientOriginalExtension();//01/12/2022
            $destino = public_path('img/productos');
            $request->img->move($destino,$nombre);
            $red = Image::make($destino.'/'.$nombre);
            $red->resize(200, null, function($constraint){
                $constraint->aspectRatio();
            });
            $red->save($destino.'/thumbs/'.$nombre);
            $marca_agua = Image::make($destino.'/'.$nombre);
            $code = Image::make(public_path('img/code.jpg'));
            $marca_agua->insert($code, 'bottom-right',10,10);
            $marca_agua->save();
            $producto = Producto::create([
                'nombre'=>$request->nombre,
                'img'=>$nombre,
                'stock'=>$request->stock,
                'codigo'=>$request->codigo,
            ]);

            return back()->with('Listo', 'Se ha insertado correctamente');
        }
    }

}
