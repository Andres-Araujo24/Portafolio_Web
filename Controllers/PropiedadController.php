<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class PropiedadController {

    //Static para no crear nuevas instancias
    public static function index(Router $router) { //Para utilizar el Router con la referencia que se encuentra en index

        $propiedades = Propiedad::all(); //Traer todas las propiedades, llamado hacia la DB
        $vendedores = Vendedor::all();

        //Mensaje condicional
        $resultado = $_GET['resultado'] ?? null; //Muestre un mensaje de que se registro la propiedad

        //Le pasamos todo a la vista para que lo muestre
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades, //El resultado de la consulta se la pasamos a la vista en el campo de propiedades
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router) {
        
        $propiedad = new Propiedad(); //Creando nueva instancia/objeto vacio
        $vendedores = Vendedor::all(); //Listar todos los vendedores
        $errores = Propiedad::getErrores(); //Arreglo con mensajes de errores

        //Ejecutar el codigo luego del usuario enviar el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Propiedad es un arreglo y POST es un arreglo asi que le pasamos POST, estan las informaciones contenidas al enviar el form y todas estan contenidas en un arreglo que es propiedad
            $propiedad = new Propiedad($_POST['propiedad']); //Instanciando Propiedad

            //Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['propiedad']['tmp_name']['imagen']) { //Si tenemos una imagen
                $manager = new ImageManager(Driver::class); //Para usar ImageManager y el Driver de Intervention 
                $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600); //Permite leer una imagen y cover para eliminar los excendentes
                $propiedad->setImagen($nombreImagen);
            }

            $errores = $propiedad->validar();
            
            //Revisar que el arreglo de errores este vacio
            if(empty($errores)) {
                

                //Subida de archivos
                //CARPETA_IMAGENES, es una GLOBAL, tiene la ruta, la definimos en funciones
                if(!is_dir(CARPETA_IMAGENES)){ //Si no existe la crea. is_dir, para saber si existe.
                    mkdir(CARPETA_IMAGENES);
                }

                //Guarda la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);


            $propiedad->guardar(); //Si no hay errores lo guarda.
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad, //Pasando la instancia a la vista
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarRedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all(); //Listar todos los vendedores
        $errores = Propiedad::getErrores(); //Arreglo con mensajes de errores

        //Ejecutar el codigo luego del usuario enviar el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Asignar los atributos, gracias a que en el formulario lo modificamos para que todo lo cree dentro de un arreglo.
        $args = $_POST['propiedad']; 
       
        $propiedad->sincronizar($args); //Esto tomara un arreglo

        $errores = $propiedad->validar(); //Validacion

        //Subida de archivos
        //Generar un nombre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        if($_FILES['propiedad']['tmp_name']['imagen']) { //Si tenemos una imagen
            $manager = new ImageManager(Driver::class); //Para usar ImageManager y el Driver de Intervention 
            $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600); //Permite leer una imagen y cover para eliminar los excendentes
            $propiedad->setImagen($nombreImagen);
        }
        
        //Revisar que el arreglo de errores este vacio y lo actualiza
        if(empty($errores)) {
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            }

            $propiedad->guardar();
        }
    }

        
        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        //Eliminando propiedad
        //Cuando se mande ese request de tipo post (cuando le damos a eliminar junto al otro input oculto), esas variables ya van a existir
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id']; //El POST no va a existir hasta que se llame el Request_Method
            //Validando que sea un numero
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) { //Si tenemos el id, ejecuta
                $tipo = $_POST['tipo'];
                
                if(validarTipoContenido($tipo)) {
                    //Obtener los datos de la propiedad por ID
                    $propiedad = Propiedad::find($id);
                    //Eliminar Propiedad
                    $propiedad->eliminar(); 
                }
            }
        }
    }
}