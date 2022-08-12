<?php

namespace Controller;

use Model\Servicio;
use MVC\Router;
use Socket;

class servicioController {
    public static function index(Router $router){
      if(!isset($_SESSION)) {
        session_start();
       };
        //  session_start();
          
          isAdmin();

      $servicios = Servicio::all();

      $router->render('servicios/index',[
       'nombre' => $_SESSION['nombre'],
       'servicios' => $servicios
      ]);
    }
    public static function crear(Router $router){
      if(!isset($_SESSION)) {
        session_start();
       };
        //session_start();
        isAdmin();

        $servicio = new Servicio;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
          $servicio->sincronizar($_POST);
        
          $alertas = $servicio->validar();

          if(empty($alertas)){
            $servicio->guardar();
            header('Location: /servicios');
          }
        }
        $router->render('servicios/crear',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
           ]);
    }
    public static function actualizar(Router $router){
      if(!isset($_SESSION)) {
        session_start();
       };
         //session_start();
         isAdmin();

         //debuguear($_GET['id']);
         if(!is_numeric($_GET['id'])) return;
         $servicio = Servicio::find($_GET['id']);
         //debuguear($servicio);
         $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
             $servicio->sincronizar($_POST);
             $alertas = $servicio->validar();
            if(empty($alertas)){
               $servicio->guardar();
               header('Location: /servicios');
            }
        }
        $router->render('servicios/actualizar',[
          'nombre' => $_SESSION['nombre'],
          'servicio' => $servicio,
           'alertas'=> $alertas
           ]);
    }
    public static function eliminar(){
      if(!isset($_SESSION)) {
        session_start();
       };
         //  session_start();
           isAdmin();

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
              $id = $_POST['id'];
              $servicio = Servicio::find($id);
              $servicio->eliminar();
              header('Location: /servicios');
        }
    }
} 