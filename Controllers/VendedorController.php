<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear(Router $router) {
        $vendedor = new Vendedor();
        $errores = Vendedor::getErrores();  //Arreglo con mensajes de errores

        //Ejecutar el codigo luego del usuario enviar el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crear nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            //Validar que no haya campos vacios
            $errores = $vendedor->validar();

            //Si no hay errores
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarRedireccionar('/admin');
        $vendedor = Vendedor::find($id); //Obtener el arreglo de vendedor
        $errores = Vendedor::getErrores(); //Arreglo con mensajes de errores

        //Ejecutar el codigo luego del usuario enviar el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') { 
            //Asiganar los valores
            $args = $_POST['vendedor'];
            //Sincronizar objeto en memoria con lo que el usuario escribio
            $vendedor->sincronizar($args);
            
            //Validacion
            $errores = $vendedor->validar();

            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/actualizar', [ 
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        //Eliminando vendedor
        //Cuando se mande ese request de tipo post (cuando le damos a eliminar junto al otro input oculto), esas variables ya van a existir
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id']; //El POST no va a existir hasta que se llame el Request_Method
            //Validando que sea un numero
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) { //Si tenemos el id, ejecuta
                $tipo = $_POST['tipo'];
                
                if(validarTipoContenido($tipo)) {
                    //Obtener los datos del vendedor por ID
                    $vendedor = Vendedor::find($id);
                    //Eliminar vendedor
                    $vendedor->eliminar(); 
                }
            }
        }
    }
}