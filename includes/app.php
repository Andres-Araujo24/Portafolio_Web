<?php
//De aqui llamaremos todas las funciones y clases
require 'funciones.php';
//Incluyendo la conexion
require 'config/database.php';
//Incluyendo el autoload creado con composer
require __DIR__ . '/../vendor/autoload.php';

//Conectarnos a DB
$db = conectarDB(); //Como lo modificamos y ahora funciona como POO, y en la funcion va a crear una nueva instancia y retorna una instancia de la conexion a DB

use Model\ActiveRecord;

ActiveRecord::setDB($db); //Al ser estatico no requiere instanciarse. Le entramos la instancia retornada en la conexion a DB



