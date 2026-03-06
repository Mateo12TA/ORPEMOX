<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        $sql = "SELECT usuario.*, tipo_usuario.tipo 
                FROM usuario 
                INNER JOIN tipo_usuario ON usuario.tipo_usuario = tipo_usuario.id_tipo
                WHERE estado = 1"; 
        $datos = DB::select($sql);
        return view("vistas/usuario/indexUsuario", compact("datos"));
    }

    public function create()
    {
        $tipos = DB::select("SELECT * FROM tipo_usuario");
        return view("vistas/usuario/registroUsuario", compact("tipos"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "txttipo" => "required",
            "txtnombre" => "required",
            "txtusuario" => "required",
            "txtcorreo" => "required|email",
            "txtpassword" => "required",
            "txtfoto" => "nullable|image|max:2048"
        ]);

        $existe = DB::table("usuario")
            ->where("usuario", $request->txtusuario)
            ->orWhere("correo", $request->txtcorreo)
            ->exists();

        if ($existe) {
            return back()->with("INCORRECTO", "El usuario o correo ya existe");
        }

        try {
            $id = DB::table("usuario")->insertGetId([
                "tipo_usuario" => $request->txttipo,
                "nombre" => $request->txtnombre,
                "apellido" => $request->txtapellido,
                "usuario" => $request->txtusuario,
                "password" => bcrypt($request->txtpassword),
                "telefono" => $request->txttelefono,
                "direccion" => $request->txtdireccion,
                "correo" => $request->txtcorreo,
                "foto" => null,
                "estado" => 1 
            ]);

            if ($request->hasFile("txtfoto")) {
                $foto = $request->file("txtfoto");
                $nombreFoto = $id . "_" . time() . "." . $foto->getClientOriginalExtension();
                $foto->move(public_path("storage/FOTO-USUARIOS"), $nombreFoto);
                DB::table("usuario")->where("id_usuario", $id)->update(["foto" => $nombreFoto]);
            }

            return redirect()->route("usuario.index")->with("CORRECTO", "Usuario registrado correctamente");

        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error: " . $th->getMessage());
        }
    }

    // --- ELIMINAR USUARIO (CORRIGE TU ERROR DE LA IMAGEN) ---
    public function destroy($id)
    {
        try {
            // Eliminación lógica: cambiamos estado a 0
            DB::update("update usuario set estado = 0 where id_usuario = ?", [$id]);
            return back()->with("CORRECTO", "Usuario eliminado correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al eliminar: " . $th->getMessage());
        }
    }

    // --- GESTIÓN DE FOTOS (VIDEO 60 Y 61) ---
    public function registrarFotoUsuario(Request $request)
    {
        $request->validate([
            "txtid" => "required|numeric",
            "txtfoto" => "required|image|mimes:jpg,png,jpeg,gif|max:2048"
        ]);

        $id_usuario = $request->txtid;
        $foto = $request->file("txtfoto");
        $nombreFoto = "usuario_" . $id_usuario . "." . $foto->getClientOriginalExtension();
        
        try {
            $foto->move(public_path("storage/FOTO-USUARIOS"), $nombreFoto);
            DB::update("update usuario set foto = ? where id_usuario = ?", [$nombreFoto, $id_usuario]);
            return back()->with("CORRECTO", "Foto actualizada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error: " . $th->getMessage());
        }
    }

    public function eliminarFotoUsuario(Request $request)
    {
        $id = $request->txtid;
        try {
            $usuario = DB::table("usuario")->where("id_usuario", $id)->first();
            if ($usuario->foto) {
                $ruta = public_path("storage/FOTO-USUARIOS/" . $usuario->foto);
                if (file_exists($ruta)) { unlink($ruta); }
            }
            DB::update("update usuario set foto = null where id_usuario = ?", [$id]);
            return back()->with("CORRECTO", "Foto eliminada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error: " . $th->getMessage());
        }
    }
}