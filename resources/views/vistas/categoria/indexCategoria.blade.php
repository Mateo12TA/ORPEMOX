@extends('layouts/app')
@section('titulo', 'Lista de categorías')

@section('content')
<h5 class="text-center text-secondary">CATEGORÍAS</h5>

<div class="mb-3">
    <a href="{{ route('categoria.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Registrar nueva categoría
    </a>
</div>

<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th width="10%">ID</th>
                    <th>Nombre de la Categoría</th>
                    <th width="15%">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $item)
                    <tr>
                        <td>{{ $item->id_categoria }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                <button type="button" data-toggle="modal" data-target="#editCategoria{{ $item->id_categoria }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('categoria.destroy', $item->id_categoria) }}" method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL DENTRO DEL FOREACH PARA CADA ITEM --}}
                    <div class="modal fade" id="editCategoria{{ $item->id_categoria }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modificar Categoría</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form action="{{ route('categoria.update', $item->id_categoria) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nombre de la Categoría</label>
                                            <input type="text" name="txtnombre" class="form-control" value="{{ $item->nombre }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach {{-- AQUÍ SE CIERRA EL BUCLE CORRECTAMENTE --}}
            </tbody>
        </table>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        if (!$.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                }
            });
        }

        // Confirmación de eliminación
        $(document).on('submit', '.formulario-eliminar', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la categoría.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) { this.submit(); }
            });
        });
    });
</script>
@endpush