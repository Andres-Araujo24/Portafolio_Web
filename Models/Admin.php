<?php

namespace Model;

class Admin extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar() {
        if(!$this->email) {
            self::$errores[] = 'El email es obligatorio';
        }
        if(!$this->password) {
            self::$errores[] = 'El password es obligatorio';
        }

        return self::$errores;
    }

    public function existeUsuario() {
        //Revisar si un usuario existe o no
        $query = "SELECT * FROM " . self::$tabla. " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        
        //Si no hay resultados
        if(!$resultado -> num_rows) {
            self::$errores[] = "El Usuario no existe";
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado) {
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($this->password, $usuario->password); //Revisa si el que ingreso es igual al que esta en la DB.
        if(!$autenticado) {
            self::$errores [] = "El Password es incorrecto";
        }
        return $autenticado;
    }

    public function autenticar() {
        //El usuario esta autenticado
        session_start(); //Iniciando sesion para tener acceso a la super global $_SESSION
        //Llenar el arreglo de la sesion
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('LOCATION: /admin'); //Lo redirigimos a /admin
    }
}