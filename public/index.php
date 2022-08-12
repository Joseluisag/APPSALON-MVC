<?php 

require_once __DIR__ . '/../includes/app.php';

use Controller\APIController;
use MVC\Router;
use Controller\LoginController;
use Controller\CitaController;
use Controller\AdminController;
use Controller\servicioController;

$router = new Router();

// iniciar sesion

$router->get('/',[LoginController::class,'login']);// lee pagina login
$router->post('/',[LoginController::class,'login']);// lee formulario

$router->get('/logout',[LoginController::class,'logout']); // cerrar sesion

// recuperar password

$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);

$router->get('/recuperar',[LoginController::class,'recuperar']);
$router->post('/recuperar',[LoginController::class,'recuperar']);
// crear cuenta
$router->get('/crear-cuenta',[LoginController::class,'crear']);
$router->post('/crear-cuenta',[LoginController::class,'crear']);

// confirmar cuenta
$router->get('/confirmar-cuenta',[LoginController::class,'confirmar']);
$router->get('/mensaje',[LoginController::class,'mensaje']);
// ----- area privada------------------------------
$router->get('/cita',[CitaController::class,'index']);
$router->get('/admin',[AdminController::class,'index']);

// API CITA
$router->get('/api/servicios',[APIController::class,'index']);
$router->post('/api/citas',[APIController::class,'guardar']);
$router->post('/api/eliminar',[APIController::class,'eliminar']);

// crud de servicios

$router->get('/servicios',[servicioController::class,'index']);
$router->get('/servicios/crear',[servicioController::class,'crear']);
$router->post('/servicios/crear',[servicioController::class,'crear']);
$router->get('/servicios/actualizar',[servicioController::class,'actualizar']);
$router->post('/servicios/actualizar',[servicioController::class,'actualizar']);
$router->post('/servicios/eliminar',[servicioController::class,'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();