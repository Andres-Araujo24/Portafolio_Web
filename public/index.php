<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorController;
use Controllers\PaginasController;
use Controllers\LoginController;


$router = new Router();


//Visitamos admin, luego []-> 1. Para identificar en que clase se encuentra el metodo. 2. Le pasamos el metodo
$router->get("/admin", [PropiedadController::class, 'index']);
$router->get("/propiedades/crear", [PropiedadController::class, 'crear']);
$router->post("/propiedades/crear", [PropiedadController::class, 'crear']); //Para enviar formulario y crear la propiedad 
$router->get("/propiedades/actualizar", [PropiedadController::class, 'actualizar']);
$router->post("/propiedades/actualizar", [PropiedadController::class, 'actualizar']);//Para enviar formulario y actualizar
$router->post("/propiedades/eliminar", [PropiedadController::class, 'eliminar']);//Para eliminar

//Vendedores
$router->get("/vendedores/crear", [VendedorController::class, 'crear']);
$router->post("/vendedores/crear", [VendedorController::class, 'crear']);
$router->get("/vendedores/actualizar", [VendedorController::class, 'actualizar']);
$router->post("/vendedores/actualizar", [VendedorController::class, 'actualizar']);
$router->post("/vendedores/eliminar", [VendedorController::class, 'eliminar']);


//Paginas que puede acceder los usuarios sin credenciales
$router->get('/', [PaginasController::class, 'index']); //Pagina principal
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/propiedades', [PaginasController::class, 'propiedades']);
$router->get('/propiedad', [PaginasController::class, 'propiedad']);
$router->get('/blog', [PaginasController::class, 'blog']);
$router->get('/entrada', [PaginasController::class, 'entrada']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);


//Login y autenticacion
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);


$router->comprobarRutas();