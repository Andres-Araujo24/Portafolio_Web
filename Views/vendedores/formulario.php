<fieldset>
    <legend>Información General</legend>
<!--Le ponemos en el name, vendedor[] para que lo cree en un arreglo y cuando tengamos que sincronizar sea mas facil y no tengamos que escribir cada atributo-->
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor(a)" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor(a)" value="<?php echo s($vendedor->apellido); ?>">
</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="telefono">Telefono</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Telefono Vendedor(a)" value="<?php echo s($vendedor->telefono); ?>">
</fieldset>