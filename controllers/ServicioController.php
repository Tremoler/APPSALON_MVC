<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;


class ServicioController {
    public static function index(Router $router) {
        isAdmin();

        $servicios = Servicio::all();
        
        // Para mensaje de creado, actualizado o eliminado correctamente
        $resultado = null;
        $resultado = $_GET['resultado'] ?? null;

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router) {
        isAdmin();
        $servicio = new Servicio;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios?resultado=1'); // Mensaje de creado correctamente
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }
    
    public static function actualizar(Router $router) {
        isAdmin();
        if(!is_numeric($_GET['id'])) return; // El id de la URL es un id valido y que existe
        $servicio = Servicio::find(($_GET['id']));
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios?resultado=2'); // Mensaje de actualizado correctamente
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar() {
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios?resultado=3'); // Mensaje de eliminado correctamente
        }
    }
}