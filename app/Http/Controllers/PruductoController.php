<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PruductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // retrieve products joined with category name
        $datos = DB::table('producto')
            ->join('categoria', 'producto.id_categoria', '=', 'categoria.id_categoria')
            ->select('producto.*', 'categoria.nombre as categoria')
            ->get();

        return view('vistas/productos/indexproducto', compact('datos'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all categories for the select box
        try {
            $categorias = DB::table('categoria')->get();
        } catch (\Throwable $th) {
            $categorias = collect();
        }

        return view('vistas/productos/registroPruductos', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'txtcategoria' => 'required',
            'txtcodigoproducto' => 'required',
            'txtnombreproducto' => 'required',
            'txtprecioproducto' => 'required|numeric',
            'txtstock' => 'required|numeric', 
            'txtfoto' => "mimes:png,jpg,jpeg"
            
        ]);

        //validar la foto del producto
        $foto = $request->file('txtfoto');
        

        //validar productos duplicados
        $producto = DB::select("select count(*) as total from producto where codigo = ?", [$request->txtcodigoproducto]);
        if ($producto[0]->total > 0) {
            return back()->with(['INCORRECTO' => 'El producto ya se encuentra registrado'])->withInput();
        }
        
   
        $registro = DB::table('producto')->insertGetId([
            'id_categoria' => $request->txtcategoria,
            'codigo' => $request->txtcodigoproducto,
            'nombre' => $request->txtnombreproducto,
            'precio' => $request->txtprecioproducto,
            'stock' => $request->txtstock,
            'descripcion' => $request->txtdescripcion,
            'estado' => "1"
        ]);


        try {
            $foto = $request->file('txtfoto');
            $nombreFoto = $registro . "." . $foto->getClientOriginalName();
            $ruta=storage_path('app/public/FOTO-PRODUCTOS/'.$nombreFoto);
            copy($foto, $ruta);
        } catch (\Throwable $th) {
             $nombreFoto ="";
        }

        //actualizar la tabla prodcuto con el campo foto
        try {
            $actualizad=DB::update("update producto set foto=? where id_producto=?",[
                $nombreFoto,
                $registro

            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        
        if ($registro>=1 and $actualizad ==1) {
            return back()->with(['CORRECTO' => 'Producto registrado correctamente']);
        } else {
            return back()->with(['INCORRECTO' => 'Error al registrar el producto']);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
