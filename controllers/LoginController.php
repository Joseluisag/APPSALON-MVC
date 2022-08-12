<?php

namespace Controller;

use Classes\Email;
use MVC\Router;
use Model\Usuario;
use Model\ActiveRecord;

class LoginController{
   public static function login(Router $router){
      $alertas =[];

       if($_SERVER['REQUEST_METHOD'] === 'POST'){
          $auth = new Usuario($_POST);
         $alertas = $auth->validarLogin();

         if(empty($alertas)){
           // comprobar que existe el usuario por el email

           $usuario = Usuario::where('email',$auth->email);
           if($usuario){
              // comprobar el pasword
              if($usuario->comprobarPasswordAndVerificado($auth->password)){
                 // autentificar al usuario
                 if(!isset($_SESSION)) {
                  session_start();
                 };
                  //session_start();
                  $_SESSION['id'] = $usuario->id;
                  $_SESSION['nombre']= $usuario->nombre . " " . $usuario->apellido; 
                  $_SESSION['email'] = $usuario->email;
                  $_SESSION['login']= true;

                  // redireccionamiento si es admin o cliente
                  if($usuario->admin === '1'){
                     $_SESSION['admin'] = $usuario->admin ?? null;
                     header('Location: /admin');
                  }else {
                     header('Location: /cita');
                  }
              }
           }else{
              Usuario::setAlerta('error','usuario no encontrado');
           }


         }
       }    
       $alertas = Usuario::getAlertas();

    $router->render('auth/login',[
       'alertas' => $alertas
    ]);

   }
   public static function logout(){
      if(!isset($_SESSION)) {
         session_start();
        };
   // session_start();
    //debuguear($_SESSION);
    $_SESSION = [];
    header('Location: /');
   }
   public static function olvide(Router $router){
      $alertas = [];
      if($_SERVER['REQUEST_METHOD']=== 'POST'){
           $auth = new Usuario($_POST);
           $alertas = $auth->validarEmail();
         if(empty($alertas)){
            $usuario = Usuario::where('email',$auth->email);
            if($usuario && $usuario->confirmado === '1'){
               //generar un token
               $usuario->crearToken();
               $usuario->guardar();
               // envia el email
                $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                $email->enviarInstrucciones();

               // alerta de exito
               Usuario::setAlerta('exito','Revisa tu email');
            
               //debuguear($usuario);
            }else{
               Usuario::setAlerta('error','El Usuario no existe o no esta confirmado');
            
            }
         }

      }
      $alertas = Usuario::getAlertas();

    $router->render('auth/olvide-password',[   
      'alertas' => $alertas 
    ]);

   }
   public static function recuperar(Router $router){
      $alertas = [];
      $error = false;

      $token = s($_GET['token']);
      //debugear($token);
    // buscar al usuario por su token
      $usuario = Usuario::where('token', $token);
      //debuguear($usuario);

      if(!$usuario){
           Usuario::setAlerta('error','Token no válido');
           $error = true;
      }
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
           // LEER EL NUEVO PASSWORD Y GUARDARLO
           $password = new Usuario($_POST);
           //debuguear($password);

           $alertas = $password->validarPassword();
           if(empty($alertas)){
              $usuario->password = '';
              $usuario->password = $password->password;
              $usuario->hashPassword();

              $usuario->token = '';
              //debuguear($usuario);
              $resultado = $usuario->guardar();
              if($resultado){
                  header('Location: /');

              }
           }
           //debugear($password);

      }
      
      $alertas = Usuario::getAlertas();

    $router->render('auth/recuperar-password',[
       'alertas' => $alertas,
       'error' => $error   
    ]);

   }
   public static function crear(Router $router){
      $usuario = new Usuario;
      $alertas['error'] = [];
        //debuguear($usuario);
      if($_SERVER['REQUEST_METHOD']=== 'POST'){
         //echo 'env$iaste el formulario';
         // debuguear($usuario);
         $usuario->sincronizar($_POST);
         $alertas = $usuario->validarNuevaCuenta();
         //revisar que alertas este vacion

         if(empty($alertas)){
             //echo 'Pasaste la validación';
             //verificar que el usurio no este registrado

             $resultado = $usuario->existeUsuario();
             if($resultado->num_rows){
                $alertas = Usuario::getAlertas();   
             }else{
                // hashear password
                $usuario->hashPassword();
               // generar token unico 
                $usuario->crearToken();
                //debuguear($usuario);
               // enviar email
                $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                //debuguear($email);
                $email->enviarConfirmacion();
                // crear el usuario
                //debuguear($usuario);
                
                $resultado = $usuario->guardar();

                if($resultado){
                  header('Location: /mensaje');
                }

                //debuguear($usuario);
      
             }// fin if resultado
         }// fin if alertas

        //debuguear($alertas);
      }
    $router->render('auth/crear-cuenta',[
        'usuario' => $usuario,
        'alertas' => $alertas
        
    ]);

   }
   public static function confirmar(Router $router){
            $alertas =[];
            $token = s($_GET['token']);
            //debuguear($token);
            $usuario = Usuario::where('token',$token);
            //debuguear($usuario);
            if(empty($usuario)){
               //Mostrar mensaje de error
               Usuario::setAlerta('error','Token no válido');
            }else{
               // modificar a usurio confirmado
               $usuario->confirmado = "1";
               $usuario->token = '';//error por null
               //debuguear($usuario);
               $usuario->guardar();

               Usuario::setAlerta('exito','Cuenta comprobada Correctamente');
            }
            
            $alertas = Usuario::getAlertas();

           $router->render('auth/confirmar-cuenta',[
              'alertas'=> $alertas
           ]);

   } 
   public static function mensaje(Router $router){
      $router->render('auth/mensaje');
   }
} 