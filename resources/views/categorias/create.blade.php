<h1>Ingresa Nueva Categoría</h1>


<form action="{{ route('categorias.store') }}" method="POST">
    @csrf

    <label for="nombre">Nombre de la Categoría:</label>
    <input type="text" name="nombre" id="nombre" placeholder="Ej. Cerámica, Porcelanato">

    <button type="submit">Guardar Categoría</button>
</form>
