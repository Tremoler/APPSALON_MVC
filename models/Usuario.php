<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apeliido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de Validacion para la creacion de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][]= 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][]= 'El Apellido es Obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][]= 'El Telefono es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][]= 'El email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][]= 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][]= 'El Password debe tener un minimo de 6 caracteres';
        }
        return self::$alertas;
    }

    // Mensajes de Validacion para login
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][]= 'El email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][]= 'El Password es Obligatorio';
        }
        return self::$alertas;
    }

    // Recuperacion de Password
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][]= 'El email es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][]= 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][]= 'El Password debe tener un minimo de 6 caracteres';
        }
        return self::$alertas;
    }

    // Revisa si el mail del usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 ";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][]= 'El Usuario ya se encuentra registrado';
        }
        return $resultado;
    }

    // Hashear Password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Crear Token
    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);

        // Verificar si confirmo la cuenta luego de crearla
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][]= 'Password incorrecto o Cuenta no verificada';
        } else {
            return true;
        }
    }
}