<?php

function conectarDB() {
    $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');

    if(!$db) {
        echo 'Error no se pudo conectar a la DB';
        exit;
    } 
    return $db; //Para que la retorne a la variable
}