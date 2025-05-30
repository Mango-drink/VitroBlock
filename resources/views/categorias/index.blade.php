@extends('layouts.app')

@section('content')
<h1>Listado de Categorías</h1>
<a href="{{ route('categorias.create') }}">Crear nueva categoría</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
        <tr>
            <td>{{ $categoria->categoria_id }}</td>
            <td>{{ $categoria->nombre }}</td>
            <td>
                <a href="{{ route('categorias.edit', $categoria->categoria_id) }}">Editar</a>
                <form action="{{ route('categorias.destroy', $categoria->categoria_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
``.blade.php`

Ambos formularios son similares. Aquí tienes el de **crear**:

```blade
@extends('layouts.app')

@section('content')
<h1>Crear Categoría</h1>
<form action="{{ route('categorias.store') }}" method="POST">
    @csrf
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">
    <!-- Agrega más campos aquí -->
    <button type="submit">Guardar</button>
</form>
@endsection
