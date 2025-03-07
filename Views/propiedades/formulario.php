<fieldset>
    <legend>Información General</legend>
<!--Le ponemos en el name, propiedad[] para que lo cree en un arreglo y cuando tengamos que sincronizar sea mas facil y no tengamos que escribir cada atributo-->
     <label for="titulo">Titulo</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

     <label for="precio">Precio</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

     <label for="imagen">Imagen</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">
    <?php if($propiedad->imagen): ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" alt="" class="imagen-small">
    <?php endif; ?>

     <label for="descripcion">Descripción</label>
    <textarea name="propiedad[descripcion]" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

 <fieldset>
    <legend>Información Propiedad</legend>

     <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

     <label for="wc">Baños</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

     <label for="estacionamiento">Estacionamientos</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 2" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
</fieldset>

 <fieldset>
    <legend>Vendedor</legend>
    
        <label for="vendedor">Vendedor</label>
        <select name="propiedad[vendedorId]" id="vendedor">
            <option selected value="">-- Seleccione --</option>
            <?php foreach($vendedores as $vendedor): ?> 
            <!--Guardando el id del vendedor y mostrando los vendedores a seleccionar y luego guarda el id del seleccionado-->
                <option 
                <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?>
                value="<?php echo s($vendedor->id); ?>"> <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?> </option>
            <?php endforeach; ?>
        </select>
</fieldset>