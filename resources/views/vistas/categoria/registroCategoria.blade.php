@extends('layouts/app')

@section("titulo", "Registro de Categorías")

<style>
    .mensaje {
        color: red;
        font-size: 13px;
        padding: 5px;
    }
</style>

@section('content')

    {{-- Notificaciones --}}
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

    <h4 class="text-center text-secondary">Registro de categorías</h4>

    {{-- Cambiamos la ruta a categoria.store y quitamos el enctype porque no subimos fotos --}}
    <form action="{{ route('categoria.store') }}" method="POST">
        @csrf

        <div class="row col-12 justify-content-center">
            
            {{-- Campo Nombre de la Categoría --}}
            <div class="fl-flex-label col-12 col-md-10 mb-3 px-2">
                <input type="text"
                       class="input input__text"
                       placeholder="Nombre de la categoría *"
                       name="txtnombre"
                       value="{{ old('txtnombre') }}">

                @error('txtnombre')
                    <small class="mensaje">{{ $message }}</small>
                @enderror
            </div>

            {{-- Botón Guardar al lado del input --}}
            <div class="col-12 col-md-2 mb-3">
                <button type="submit" class="btn btn-primary btn-block" style="height: 50px;">
                    Guardar
                </button>
            </div>

        </div>

        {{-- Botón para volver a la lista --}}
        <div class="text-center mt-3">
            <a href="{{ route('categoria.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>

    </form>

@endsection