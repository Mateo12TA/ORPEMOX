@extends('layouts/app')
@section('content')
<script>
    function eliminarFoto() { return confirm("¿Estás seguro de eliminar la foto?"); }
</script>

<h5 class="text-center text-secondary">LISTA DE USUARIOS</h5>
<div class="mb-3">
    <a href="{{ route('usuario.create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Registrar nuevo usuario</a>
</div>

<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Tipo Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item)
                    <tr>
                        <td>{{ $item->id_usuario }}</td>
                        <td>{{ $item->tipo }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->apellido }}</td>
                        <td>{{ $item->usuario }}</td>
                        <td>{{ $item->telefono }}</td>
                        <td>{{ $item->direccion }}</td>
                        <td>{{ $item->correo }}</td>
                        <td>
                            @if ($item->foto != null)
                                <a href="#" data-toggle="modal" data-target="#verFoto{{ $item->id_usuario }}" class="btn btn-outline-info btn-sm"><i class="fas fa-image"></i> Ver foto</a>
                            @else
                                <a href="#" data-toggle="modal" data-target="#subirFoto{{ $item->id_usuario }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-camera"></i> Agregar foto</a>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('usuario.destroy', $item->id_usuario) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar usuario?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="verFoto{{ $item->id_usuario }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Foto de {{ $item->nombre }}</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/FOTO-USUARIOS/' . $item->foto) }}" class="img-fluid rounded mb-3">
                                    <form action="{{ route('usuario.eliminarFotoUsuario') }}" method="POST">
                                        @csrf @method('DELETE')
                                        <input type="hidden" name="txtid" value="{{ $item->id_usuario }}">
                                        <button onclick="return eliminarFoto()" type="submit" class="btn btn-danger btn-block">Eliminar Foto</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="subirFoto{{ $item->id_usuario }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('usuario.registrarFotoUsuario') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="txtid" value="{{ $item->id_usuario }}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Seleccione imagen</label>
                                            <input type="file" name="txtfoto" class="form-control" accept="image/*" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Subir Imagen</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection