@extends('layouts.app')

@section('content')
<h1>Listado de Orígenes</h1>
<a href="{{ route('origenes.create') }}">Crear nuevo origen</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($origenes as $origen)
        <tr>
            <td>{{ $origen->origen_id }}</td>
            <td>{{ $origen->nombre }}</td>
           >
                <a href="{{ route('origenes.edit', $origen->origen_id) }}">Editar</a>
                <form action="{{ route('origenes.destroy', $origen->origen_id) }}" method="POST">
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
<h1>Crear Origen</h1>
<form action="{{ route('origenes.store') }}" method="POST">
    @csrf
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">
    <!-- Agrega más campos aquí -->
    <button type="submit">Guardar</button>
</form>
@endsection


```blade
@extends('layouts.app')

@section('content')
<h1>Crear Origen</h1>
<form action="{{ route('origenes.store') }}" method="POST">
    @csrf
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">
    <!-- Agrega más campos aquí -->
    <button type="submit">Guardar</button>
</form>
@endsection
