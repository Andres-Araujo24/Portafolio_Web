<?php

//require 'app.php'; //Para utilizar la constante que hemos creado. No lo usaremos mas porque estamos incluyendo funciones en el app.php

//Definiendo donde estan las rutas de los templates y usando DIR para que nos traiga la ubicacion  y sepa donde encontrar los archivos. Estaban en app.php pero la movimos aqui.
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] .'/imagenes/');

//Le ponemos que tendra otro parametro que si no se encuentra definido lo pondra false por default
function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/$nombre.php";
}

function autenticado() {
    session_start();
     
    if(!$_SESSION['login']) { //Traemos esta informacion que si es true, pues el usuario esta autenticado. Aqui lo negamos
        header('LOCATION: /');
    }
    return true;
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escapa/sanitizar el HTML para seguridad
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido para eliminar ya sea propiedad o vendedor
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad']; //Solo lo que esta en el array es que se puede eliminar
    return in_array($tipo, $tipos); //Para que busque lo que le pasamos en el arreglo de tipos.
}

//Muestra mensajes
function mostrarNotificacion($codigo) {
    $mesaje = '';

    switch($codigo) {
        case 1: $mensaje = 'Creado Correctamente'; break;
        case 2: $mensaje = 'Actualizado Correctamente'; break;
        case 3: $mensaje = 'Eliminado Correctamente'; break;
        default: $mensaje = false; break;
    }

    return $mensaje;
}

function validarRedireccionar(string $url) {
    //Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT); //Validando que el parametro sea un int.
    if(!$id) { //Si ponen otra cosa que sea diferente a un id, lo retornara a la pagina admin.
        header("Location: $url");
    }
    return $id;
}