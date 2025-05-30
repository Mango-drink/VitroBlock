<h1>Crear Nuevo Producto</h1>
<br/>
 
    <form method="POST" action="{{ route('VitroBlocks.store') }}" enctype="multipart/form-data">
    {{csrf_field()}}
            <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" value="">
                <br/>

            <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="">
                <br/>
 
            <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" value="">
                <br/>

            <label for="diseno">Diseño:</label>
                <input type="text" id="diseno" name="diseno" value="">
                <br/>

            <label for="color">Color:</label>
                <input type="text" id="color" name="color" value="">
                <br/>

            <label for="dimensiones">Dimensiones:</label>
                <input type="text" id="dimensiones" name="dimensiones"value="">
                <br/>

          <label for="piezas_por_caja">Piezas por caja:</label>
                <input type="number" id="piezas_por_caja" name="piezas_por_caja" min="1" value="">
                <br/>

            <label for="m2_por_caja">m² por caja:</label>
                <input type="number" step="0.01" id="m2_por_caja" name="m2_por_caja" value="">
                <br/>

            <label for="stock_actual">Stock actual:</label>
                <input type="number" id="stock_actual" name="stock_actual" min="0">
                <br/>

            <label for="precio">Precio:</label>
                <input type="number" step="0.01" id="precio" name="precio" min="0" value="">
                <br/>

            <label for="imagen_url">Imagen:</label>
                <input type="file" id="imagen_url" name="imagen_url" value="">
                <br/>

            <input type="submit" value="Agregar">
    </form>