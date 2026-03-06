@extends('layouts/app')
@section('titulo', 'Registro de Usuario')

@section('content')
<h5 class="text-center text-secondary">REGISTRO DE NUEVO USUARIO</h5>

<div class="card">
    <div class="card-body">
        <form action="{{ route('usuario.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                {{-- Columna Izquierda --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de Usuario <span class="text-danger">*</span></label>
                        <select name="txttipo" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach ($tipos as $item)
                                <option value="{{ $item->id_tipo }}">{{ $item->tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="txtnombre" class="form-control" required value="{{ old('txtnombre') }}">
                    </div>

                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="txtapellido" class="form-control" value="{{ old('txtapellido') }}">
                    </div>

                    <div class="form-group">
                        <label>Nombre de Usuario (Login) <span class="text-danger">*</span></label>
                        <input type="text" name="txtusuario" class="form-control" required value="{{ old('txtusuario') }}">
                    </div>

                    <div class="form-group">
                        <label>Foto de perfil</label>
                        <input type="file" name="txtfoto" class="form-control-file" accept="image/*">
                    </div>
                </div>

                {{-- Columna Derecha --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="txtpassword" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="txttelefono" class="form-control" value="{{ old('txttelefono') }}">
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="txtdireccion" class="form-control" value="{{ old('txtdireccion') }}">
                    </div>

                    <div class="form-group">
                        <label>Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" name="txtcorreo" class="form-control" required value="{{ old('txtcorreo') }}">
                    </div>
                </div>
            </div>
            
            <div class="mt-3 text-right">
                <a href="{{ route('usuario.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection