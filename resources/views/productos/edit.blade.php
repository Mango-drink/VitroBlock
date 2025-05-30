@extends('layouts.app')

@section('content')
<h1>Editar Producto</h1>
<form action="{{ route('productos.update', $producto->producto_id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="{{ $producto->nombre }}">
    <!-- Agrega más campos aquí -->
    <button type="submit">Actualizar</button>
</form>
@endsection
