<?php

namespace Controllers;

use MVC\Router;


class CitaController {
    public static function index(Router $router) {

        // Para que llene automaticamente en el form de la cita el Nombre del usuario logueado
        
        isAuth();

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}