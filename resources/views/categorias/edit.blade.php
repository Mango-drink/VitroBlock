@extends('layouts.app')

@section('content')
<h1>Editar Categoria</h1>
<form action="{{ route('categorias.update', $categoria->categoria_id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="{{ $categoria->nombre }}">
    <!-- Agrega más campos aquí -->
    <button type="submit">Actualizar</button>
</form>
@endsection
