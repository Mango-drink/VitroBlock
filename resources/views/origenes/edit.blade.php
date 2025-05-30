@extends('layouts.app')

@section('content')
<h1>Editar origen</h1>
<form action="{{ route('origenes.update', $origen->origen_id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="{{ $origen->nombre }}">
    <!-- Agrega más campos aquí -->
    <button type="submit">Actualizar</button>
</form>
@endsection
