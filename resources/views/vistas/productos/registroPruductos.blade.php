@extends('layouts/app');
@section("titulo", "Registro de Productos")
<style>
    textarea {
        field-sizing:content;
    }
</style>
@section('content')
  
      <h4 class="text-center text-secondary">Registro de Productos</h4>

 <form action="">
     <div class="row col-12">
         <div class="fl-flex-label col-12 col-md-6 mb-3 px-2">
              <select name="categoria_id" id="categoria_id" class="input input__select">
                <option value=""> seleccionar categoría...</option>
                @foreach ($categorias ?? [] as $item)
                    <option value="{{ $item->id_categoria }}">{{ $item->nombre }}</option>
                @endforeach
             </select>
         </div>

           <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
               <input type="text" class="input input__text" placeholder="codigo del producto">
           </div>
     </div>
     <div class="row col-12 mb-3">
         <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
               <input type="text" class="input input__text" placeholder="Nombre del producto">
           </div>
              <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
                <input type="text" class="input input__text" placeholder="Precio del producto">
</div>
</div>
     <div class="row col-12 mb-3">
         <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
               <input type="number" class="input input__text" placeholder="stock del producto">
           </div>
              <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
                <textarea name="" id="" cols="30" rows="10" placeholder="Descripción del producto" class="input input__text"></textarea>
            </div>        
     </div>

    <div class="text-right px-4">
          <button type="submit" class="btn btn-primary">Guardar</button>
     </div>
 </form>

@endsection