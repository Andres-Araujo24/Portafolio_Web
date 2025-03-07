<?php

namespace Model;

class ActiveRecord {
    //Base de datos, es static para no tener diversas instancias nuevas.
    protected static $db;
    protected static $columnasDB = [];//Este atributo existe pero lo sobreescribiremos en Propiedad 
    protected static $tabla = '';
    //Errores/Validacion
    protected static $errores = [];

    //Conexion a la DB, es static para poder acceder al atributo estatico definido
    public static function setDB($database) {
        self::$db = $database; //Recordar que self hace referencia a los atributos estaticos de una misma clase
    }


    public function guardar() {
        if(!is_null($this->id)) { //Si el valor no es null
            //Actualizar
            $this->actualizar(); //Llamando al metodo
        } else { //Si es null
            //Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear() {
        //Sanitizar los datos ingresados
        $atributos = $this->sanitizarAtributos();

        //Join, crea un nuevo string apartir de un arreglo. EL primer parametro es el separador, y el segundo el arreglo.

        //Insertar en la DB
        $query = "INSERT INTO " . static::$tabla . " ("; 
        $query.= join(', ', array_keys($atributos)); //El arreglo de las llaves; titulo, precio, imagen, etc...
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos)); //Lo mismo pero para los valores
        $query .= " ')";

        $resultado = self::$db->query($query);
        if($resultado) {
            //Redireccionando al usuario para evitar reenvios de formularios
            header("Location: /admin?resultado=1");
        }
    }

    public function actualizar() {
        //Sanitizar los datos ingresados
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach($atributos as $key=>$value) {
            $valores[] = "{$key}='{$value}'";
            $query = "UPDATE " . static::$tabla . " SET ";
            $query .= join(', ', $valores); // $valores debe contener las asignaciones tipo "columna = 'valor'"
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
            $query .= " LIMIT 1 "; 

            $resultado = self::$db->query($query);
            if($resultado) {
                //Redireccionando al usuario para evitar reenvios de formularios
                header("Location: /admin?resultado=2");
            }
        }
    }

    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) { //Si hay resultado, borra la imagen y luego redirigelo
            $this->borrarImagen();//Llamando al metodo
            header('LOCATION: /admin?resultado=3');
        }
    }

    //Identificar y unir los atributos de la DB
    public function atributos() {
        //Para iterar en el arreglo de los atributos de columnasDB
        $atributos = [];
        foreach (static::$columnasDB as $columna) { 
            if($columna === 'id') continue; //Para obviar el id, ya que eso se pone cuando se inserta en la DB.
            //Haremos referencia al objeto en memoria para que se vayan mapeando y se agreguen iguales, titulo:titulo, etc
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Sanitizacion
    public function sanitizarAtributos() {
        $atributos = $this->atributos(); //Llamamos el metodo atributos, una vez identificados ahora a sanitizar

        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            //Agregando un nuevo arreglo sanitizado. Key para que lo mapee en orden.
            $sanitizado[$key] = self::$db->escape_string($value); //Para todo lo de DB, usando self..., para sanitizar le agregamos escape_string a value, porque son a los valores.
        }
        return $sanitizado; //Lo retornamos y ya estara disponible en $atributos de la funcion guardar()
    }


    //Validacion
    public static function getErrores() {
        return static::$errores;
    }


    public function validar() {
        static::$errores = [];
        return static::$errores; //Para que referencia a la clase hija
    }

    public function setImagen($imagen) {
        if($imagen) {
            //Elimina la imagen previa
            if(!is_null($this->id)) {//Si no es null pues borra la imagen
                $this->borrarImagen();
            }

            $this->imagen = $imagen; //Para escribir el valor introducido en el atributo imagen
        }
    }

    public function borrarImagen() {
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            chmod(CARPETA_IMAGENES . $this->imagen, 0777);
            unlink(CARPETA_IMAGENES . $this->imagen); //Le pasamos la ruta para que la elimine
        }
    }

    //Listar todas las propiedades
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla; //Static, va a heredar este metodo y buscara la clase en la cual se esta heredando
        $resultado = self::consultarSQL($query); //Llamando el metodo consultarSQL y pasandole la consulta
        return $resultado;
    }

    //Obtener determinado numero de registro
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        $resultado = self::consultarSQL($query); 
        return $resultado;
    }

    //Listar propiedad por ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query); 
        return array_shift($resultado); //Array_shift, nos retorna el primer elemento de un arreglo
    }

    public static function consultarSQL($query) {
        //Consultar BD
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro); //Como es un array que devuelve, lo convertimos en objeto
        }
        
        //Liberar Memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static; //Para crear nuevo objeto en la clase que se esta heredando 

        //Mapeando los objetos
        foreach($registro as $key=>$value) {
            if(property_exists($objeto, $key)) {//Verifica si existe una propiedad
                $objeto->$key = $value; //Si existe pues le asignamos el valor
            }
        }
        return $objeto;
    }


    //Sincronizar el objeto en memoria para cuando vayamos a actualizar una propiedad
    public function sincronizar($args = []) {
        //Reescribiendo con los datos nuevos introducidos
        foreach($args as $key=>$value) {
            if(property_exists($this, $key) && !is_null($value)) { //$This, hace referencia al objeto actual.
                $this->$key = $value;  //Para que vaya iterando en la variable.
            }
        }
    }
}