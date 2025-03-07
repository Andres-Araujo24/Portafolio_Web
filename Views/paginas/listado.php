<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad): ?><!--Para que recorra y muestre todas las propiedades-->
        <div class="anuncio">
                <img src="imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio" loading="lazy">

            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo;?></h3>

                <!--Para que solo muestre 50 caracteres y no se desborde el contenido de anuncios-->
                <?php 
                    $cantidad = 50;
                    $descripciones = $propiedad->descripcion;
                    $descripcion = (strlen($descripciones) > $cantidad) ? substr($descripciones, 0, $cantidad) . "..." : $descripciones;
                ?>
                <p><?php echo $descripcion; ?></p>
                <p class="precio">$<?php echo $propiedad->precio; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" src="build/img/icono_wc.svg" alt="Icono WC" loading="lazy">
                            <p><?php echo $propiedad->wc;?></p>
                    </li>
                    <li>
                        <img class="icono" src="build/img/icono_estacionamiento.svg" alt="Icono Estac." loading="lazy">
                            <p><?php echo $propiedad->estacionamiento;?></p>
                    </li>
                    <li>
                        <img class="icono" src="build/img/icono_dormitorio.svg" alt="Icono Habitaciones" loading="lazy">
                            <p><?php echo $propiedad->habitaciones;?></p>
                    </li>
                </ul>

                <a class="boton-amarillo-block" href="/propiedad?id=<?php echo $propiedad->id;?>">Ver Propiedad</a>
            </div><!--Contenido-Anuncio-->
        </div><!--Anuncio-->
    <?php endforeach; ?>
</div><!--Contenedor-Anuncios-->
