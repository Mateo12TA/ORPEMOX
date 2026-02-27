<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PruductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "hola desde el controlador de productos";
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
        //
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
