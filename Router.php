<?php
namespace MVC;

//Tendra todas las rutas del proyecto desde /admin hasta anuncios, blog, login, el admin/crear.php, etc...
class Router {
    public $rutasGET = [];
    public $rutasPOST = [];

    //Le pasaran una url y tambien una funcion que realiza el metodo get().
    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn; //Llenando este arreglo con las url que soporta nuesta aplicacion y cada url tendra asociada una funcion
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    //Comprobando que exista la ruta
    public function comprobarRutas() {
        session_start();
        $auth = $_SESSION['login'] ?? null;
        //Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'] ?? null;

        //Para tener lo que el usuario esta escribiendo en la url y validarlo si es valida
        $urlActual = $_SERVER['PATH_INFO'] ?? "/"; //Si no hay valor de ruta, asignale una /.
        //Saber si la estamos visitando en GET o POST(Cuando enviamos un formulario)
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        if($metodo === 'GET') {
            //Saber que funcion esta asociada a la ruta actual
            $fn = $this->rutasGET[$urlActual] ?? null; //Si no existe en nuestras rutas(en index.php), colocale un null
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        //Proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }


        if($fn) { //Existe la URL y tiene una funcion asociada
            //Nos permite llamar una funcion, cuando no sabemos como se llama esa funcion. Ya que depende de la url visitada
            call_user_func($fn, $this); //Con $this, le pasamos todas las rutas que definimos arriba.
        } else {echo "Pagina No Encontrada"; }
             
    }

    //Muestra la Vista, este recibe la vista y datos en un arreglo
    public function render($view, $datos = []) {

        foreach($datos as $key=>$value) {
            //$$, variable de variables, Generara variables de los key que le estamos pasando hacia la vista
            $$key = $value;
        }

        //Inciar un almacenamiento en memoria. Y sera el codigo que se encuentra luego de ella.
        ob_start();
        include __DIR__ . "/Views/$view.php";

        //Luego limpiamos esa memoria y guardamos en memoria a lo que le estamos dando render y lo guarda en la variable
        $contenido = ob_get_clean();
        include __DIR__ . "/Views/layout.php";
    }
}