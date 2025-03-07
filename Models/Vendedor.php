<?php

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono']; //Identificar que forma tendran los datos, las columnas que van a tener y de esa forma podemos mapear el objeto que estamos buscando en la DB.

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
        //This para hacer referencia a los atributos de la clase
        if(!$this->nombre) {
            //Self, porque el atributo es static
            self::$errores[] = "Debes agregar un nombre";
        }
        if(!$this->apellido) {
            //Self, porque el atributo es static
            self::$errores[] = "Debes agregar un apellido";
        }
        if(!$this->telefono) {
            //Self, porque el atributo es static
            self::$errores[] = "Debes agregar un telefono";
        }

        //Validando telefono y usando expresiones regulares
        if(!preg_match('/[0-9]{10}/', $this->telefono)) {
            self::$errores[] = "Formato no valido";
        }
        return self::$errores;
    }
}