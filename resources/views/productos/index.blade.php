@extends('layouts.app')

@section('content')
<h1>Listado de Productos</h1>
<a href="{{ route('productos.create') }}">Crear nuevo producto</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
        <tr>
            <td>{{ $producto->producto_id }}</td>
            <td>{{ $producto->nombre }}</td>
           >
                <a href="{{ route('productos.edit', $producto->producto_id) }}">Editar</a>
                <form action="{{ route('productos.destroy', $producto->producto_id) }}" method="POST">
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
<h1>Crear Producto</h1>
<form action="{{ route('productos.store') }}" method="POST">
    @csrf
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">
    <!-- Agrega más campos aquí -->
    <button type="submit">Guardar</button>
</form>
@endsection
