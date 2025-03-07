<?php

//El namespace sera Model, que fue el que le dimos en composer.json
namespace Model;

//La clase propiedad era de activeRecord
class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId']; //Identificar que forma tendran los datos, las columnas que van a tener y de esa forma podemos mapear el objeto que estamos creando en crear.php(creando nueva propiedad).

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? ''; 
    }

    public function validar() {
        //This para hacer referencia a los atributos de la clase
        if(!$this->titulo) {
            //Self, porque el atributo es static
            self::$errores[] = "Debes agregar el titulo";
        }
        if(!$this->precio) {
            self::$errores[] = "Debes agregar el precio";
        }
        if(strlen($this->descripcion) < 50 ) {
            self::$errores[] = "Debes agregar la descripcion y debe tener al menos 50 caracteres";
        }
        if(!$this->habitaciones) {
            self::$errores[] = "Debes agregar las habitaciones";
        }
        if(!$this->wc) {
            self::$errores[] = "Debes agregar los baños";
        }
        if(!$this->estacionamiento) {
            self::$errores[] = "Debes agregar los estacionamiento";
        }
        if(!$this->vendedorId) {
            self::$errores[] = "Debes agregar el vendedor";
        }
        if(!$this->imagen) {
            self::$errores[] = "Debes agregar una imagen";
        }

        return self::$errores;
    }
}