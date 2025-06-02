@extends('layouts.app')

@section('content')
<h1>Listado de Orígenes</h1>
<a href="{{ route('origenes.create') }}">Crear nuevo origen</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>País</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($origenes as $origen)
        <tr>
            <td>{{ $origen->id }}</td>
            <td>{{ $origen->pais }}</td>
            <td>
                <a href="{{ route('origenes.edit', $origen->id) }}">Editar</a>
                <form action="{{ route('origenes.destroy', $origen->id) }}" method="POST" style="display:inline;">
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
