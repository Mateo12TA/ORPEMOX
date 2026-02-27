@extends('layouts/app')

<style>
    .contenedor {
        background: white;
        padding: 15px;
        display: flex;
        justify-content: space-around;
        gap: 20px;
        align-items: center;
    }

    .img {
        width: 250px;
        height: 250px;
        border-radius: 250px;
        object-fit: cover;
    }

    @media screen and (max-width: 600px) {
        .contenedor {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
    }
</style>

@section('titulo', 'empresa')

@section('content')

{{-- NOTIFICACIONES --}}

@if (session('CORRECTO'))
<script>
    $(function () {
        new PNotify({
            title: "CORRECTO",
            type: "success",
            text: "{{ session('CORRECTO') }}",
            styling: "bootstrap3"
        });
    });
</script>
@endif

@if (session('INCORRECTO'))
<script>
    $(function () {
        new PNotify({
            title: "INCORRECTO",
            type: "error",
            text: "{{ session('INCORRECTO') }}",
            styling: "bootstrap3"
        });
    });
</script>
@endif

<h4 class="text-center text-secondary">DATOS DE LA EMPRESA</h4>

<div class="mb-0 col-12 bg-white p-5">

@foreach ($sql as $item)

    {{-- SECCIÓN IMAGEN --}}
    <div class="contenedor">

        <div>
            @if ($item->foto != null)
                <img class="img" src="{{ asset('storage/empresa/'.$item->foto) }}" alt="">
            @else
                <img class="img" src="{{ asset('images/company.jpg') }}" alt="">
            @endif
        </div>

        <div>
            <b>Modificar imagen</b>

            {{-- FORM ACTUALIZAR --}}
            <form action="{{ route('empresa.actualizarLogo') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="alert alert-secondary">
                    Selecciona una imagen no muy pesada y en formato válido (.jpg, .jpeg, .png)
                </div>

                <div>
                    <input type="file"
                           class="input form-control-file mb-3"
                           name="foto"
                           accept=".jpg,.jpeg,.png">

                    @error('foto')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-rounded">
                        Modificar
                    </button>

                    <button type="button"
                            onclick="confirmarEliminacion()"
                            class="btn btn-danger btn-rounded">
                        Eliminar foto
                    </button>
                </div>
            </form>

            {{-- FORM ELIMINAR --}}
            <form action="{{ route('empresa.eliminarLogo') }}"
                  class="formulario-eliminar"
                  method="post"
                  id="formEliminarFoto">
                @csrf
                @method('DELETE')
            </form>

        </div>

    </div>

    {{-- FORM DATOS EMPRESA --}}
    <form action="{{ route('empresa.update', $item->id_empresa) }}" method="POST">
        @csrf

        <div class="row">

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text"
                       name="nombre"
                       class="input input__text"
                       id="nombre"
                       placeholder="Nombre"
                       value="{{ $item->nombre }}">
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text"
                       name="telefono"
                       class="input input__text"
                       id="telefono"
                       placeholder="telefono"
                       value="{{ $item->telefono }}">
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text"
                       name="ubicacion"
                       class="input input__text"
                       placeholder="ubicacion *"
                       value="{{ old('ubicacion', $item->ubicacion) }}">
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text"
                       name="ruc"
                       class="input input__text"
                       placeholder="ruc *"
                       value="{{ old('ruc', $item->ruc) }}">
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text"
                       name="correo"
                       class="input input__text"
                       placeholder="correo *"
                       value="{{ old('correo', $item->correo) }}">
            </div>

        </div>

        <div class="text-right mt-0">
            <button type="submit" class="btn btn-rounded btn-primary">
                Guardar
            </button>
        </div>

    </form>

@endforeach

</div>

@endsection

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmarEliminacion() {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¡No podrá recuperar esta imagen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Salir'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formEliminarFoto').submit();
        }
    });
}
</script>