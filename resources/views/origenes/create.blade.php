<h1>Ingresa Nuevo País</h1>

<form action="{{ route('origenes.store') }}" method="POST">
    @csrf

    <label for="pais">País de Origen:</label>
    <input type="text" name="pais" id="pais" placeholder="Ej. México, España, Italia">

    <button type="submit">Guardar Origen</button>
</form>

