@extends('layouts/app')
@section('titulo', 'Lista de productos')

@section('content')

<h5 class="text-center text-secondary">PRODUCTOS</h5>

{{-- BOTÓN REGISTRAR NUEVO PRODUCTO --}}
<div class="mb-3">
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Registrar nuevo producto
    </a>
</div>

{{-- TABLA PRINCIPAL --}}
<div id="tablaPrincipal">
    <section class="card">
        <div class="card-block">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead class="table-primary">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoria</th>
                        <th>Foto</th>
                        <th width="120px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $item)
                    <tr>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->precio }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->categoria }}</td>
                        <td>
                            @if ($item->foto == "" || $item->foto == null)
                                <a data-toggle="modal" data-target="#subirFoto{{ $item->id_producto }}" class="btn btn-outline-success btn-sm">Agregar foto</a>
                            @else
                                <a data-toggle="modal" data-target="#verFoto{{ $item->id_producto }}" class="btn btn-outline-info btn-sm">Ver foto</a>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                <a href="{{ route('productos.show',$item->id_producto) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" data-toggle="modal" data-target="#editProducto{{ $item->id_producto }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('productos.destroy',$item->id_producto) }}" method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL VER FOTO --}}
                    <div class="modal fade" id="verFoto{{ $item->id_producto }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Foto del producto</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body text-center">
                                    <img width="80%" src="{{ asset('storage/FOTO-PRODUCTOS/'.$item->foto) }}">
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <a href="{{ route('producto.eliminarFoto',$item->id_producto) }}" class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL SUBIR FOTO --}}
                    <div class="modal fade" id="subirFoto{{ $item->id_producto }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Subir foto</h5>
                                    <button class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="formFoto{{ $item->id_producto }}" action="{{ route('producto.registrarFotoProducto') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="txtid" value="{{ $item->id_producto }}">
                                        <input class="form-control" type="file" name="txtfoto" accept=".jpg,.png,.jpeg">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" form="formFoto{{ $item->id_producto }}" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL EDITAR PRODUCTO --}}
                    <div class="modal fade" id="editProducto{{ $item->id_producto }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar producto</h5>
                                    <button class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('productos.update',$item->id_producto) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group mb-2">
                                            <label>Categoría</label>
                                            <select name="txtcategoria" class="form-control">
                                                @foreach ($categoria as $cat)
                                                <option value="{{ $cat->id_categoria }}" @selected($cat->id_categoria == $item->id_categoria)>
                                                    {{ $cat->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Código</label>
                                            <input class="form-control" name="txtcodigoproducto" value="{{ $item->codigo }}">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Nombre</label>
                                            <input class="form-control" name="txtnombreproducto" value="{{ $item->nombre }}">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Precio</label>
                                            <input class="form-control" name="txtprecioproducto" value="{{ $item->precio }}">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Stock</label>
                                            <input type="number" class="form-control" name="txtstock" value="{{ $item->stock }}">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Descripción</label>
                                            <textarea class="form-control" name="txtdescripcion">{{ $item->descripcion }}</textarea>
                                        </div>
                                        <div class="modal-footer px-0 pb-0">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>

@endsection

{{-- SECCIÓN DE SCRIPTS --}}
@push('scripts')
<script>
$(document).ready(function() {
    // Destruir instancia previa para evitar errores de reinicialización
    if ($.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy();
    }

    // Inicialización de DataTable con traducción al español
    $('#example').DataTable({
        "destroy": true,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sSearch":         "Buscar:",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });
});

// CONFIRMACIÓN DE ELIMINACIÓN CON SWEETALERT2
$(document).on('submit', '.formulario-eliminar', function(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Este producto se eliminará permanentemente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endpush