@extends('layouts/app')
@section('titulo', 'Lista de productos')
@section('content')

<h4 class="text-center text-secondary">LISTA DE PRODUCTOS</h4>

    <section class="card">
        <div class="card-block">
            <table id="example" class="display table table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>codigo</th>
                        <th>nombre</th>
                        <th>descripcion</th>
                        <th>precio</th>
                        <th>categoria</th>
                        <th>stock</th>
                        <th>foto</th>
                        <th></th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->precio }}</td>
                            <td>{{ $item->categoria }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>
                                @if($item->foto=="" or $item->foto==null)
                                    <a href="">Agregar foto</a>
                                @else
                                    <img style="width: 120px" src="{{ asset("storage/FOTO-PRODUCTOS/$item->foto") }}" 
                                    alt="Foto del producto">
                                @endif
                            </td>
                            <td> 
                                <a href="" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td> 

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </section>

@endsection