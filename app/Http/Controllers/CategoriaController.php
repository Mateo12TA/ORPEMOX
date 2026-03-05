<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = DB::select("select * from categoria");        
        return view("vistas/categoria/indexCategoria", compact("categorias"));
    }

    public function create()
    {
        return view("vistas/categoria/registroCategoria");
    }

    public function store(Request $request)
    {
        $request->validate(['txtnombre' => 'required']);

        // Validar si existe por nombre
        $existe = DB::select("select count(*) as total from categoria where nombre=?", [$request->txtnombre]);

        if ($existe[0]->total > 0) {
            return back()->with("INCORRECTO", "La categoría ya existe");
        }

        try {
            DB::insert("insert into categoria(nombre) values(?)", [$request->txtnombre]);
            return redirect()->route('categoria.index')->with("CORRECTO", "Categoría registrada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate(['txtnombre' => 'required']);

        // LÓGICA DEL VIDEO: Validar duplicados ignorando el ID actual
        $existe = DB::select("select count(*) as total from categoria where nombre=? and id_categoria != ?", [
            $request->txtnombre,
            $id
        ]);

        if ($existe[0]->total > 0) {
            return back()->with("INCORRECTO", "El nombre de la categoría ya existe");
        }

        try {
            DB::update("update categoria set nombre=? where id_categoria=?", [
                $request->txtnombre,
                $id
            ]);
            // Forzamos éxito aunque no haya cambios físicos en la DB
            return redirect()->route('categoria.index')->with("CORRECTO", "Categoría actualizada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::delete("delete from categoria where id_categoria=?", [$id]);
            return back()->with("CORRECTO", "Categoría eliminada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "No se puede eliminar (está siendo usada por productos)");
        }
    }
}   