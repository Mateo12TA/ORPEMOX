<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    /**
     * Show empresa data.
     */
    public function index()
    {
        try {
            $sql = DB::select('select * from empresa');
        } catch (\Throwable $th) {
            // if query fails return empty array so view does not break
            $sql = [];
        }

        return view('vistas.empresa.empresa', compact('sql'));
    }
    /**
     * Update basic empresa information.
     */
    public function update(Request $request, $id)
    {
        try {
            $sql = DB::update(
                'update empresa set nombre=?, telefono=?, ubicacion=?, ruc=?, correo=? where id_empresa=?',
                [
                    $request->nombre,
                    $request->telefono,
                    $request->ubicacion,
                    $request->ruc,
                    $request->correo,
                    $id,
                ]
            );
            if ($sql === 0) {
                // treat 0 rows affected as success to match previous behaviour
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql === 1) {
            return back()->with('CORRECTO', 'Datos modificados correctamente');
        }

        return back()->with('INCORRECTO', 'Error al modificar');
    }
    /**
     * Replace the empresa logo image.
     */
    public function actualizarLogo(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $file = $request->file('foto');
        $nombrearchivo = 'logo.' . strtolower($file->getClientOriginalExtension());
        $diskPath = 'public/empresa/' . $nombrearchivo;

        // delete existing logo if present
        $existing = DB::table('empresa')->value('foto');
        if ($existing) {
            Storage::delete('public/empresa/' . $existing);
        }

        // store new file using Storage facade
        $stored = Storage::putFileAs('public/empresa', $file, $nombrearchivo);

        try {
            $actualizarcampo = DB::update('update empresa set foto=?', [$nombrearchivo]);
            if ($actualizarcampo === 0) {
                $actualizarcampo = 1;
            }
        } catch (\Throwable $th) {
            $actualizarcampo = 0;
        }

        if ($stored && $actualizarcampo) {
            return back()->with('CORRECTO', 'Logo actualizado correctamente');
        }

        return back()->with('INCORRECTO', 'Error al actualizar el logo');
    }
/**
     * Delete the current empresa logo.
     */
    public function eliminarLogo()
    {
        $nombrelogo = DB::table('empresa')->value('foto');

        $deleted = true;
        if ($nombrelogo) {
            $deleted = Storage::delete('public/empresa/' . $nombrelogo);
        }

        try {
            $actualizarcampo = DB::update("update empresa set foto='' ");
        } catch (\Throwable $th) {
            $actualizarcampo = false;
        }

        if ($deleted && $actualizarcampo) {
            return back()->with('CORRECTO', 'Logo eliminado correctamente');
        }

        return back()->with('INCORRECTO', 'Error al eliminar el logo');
    }

    
}   
  