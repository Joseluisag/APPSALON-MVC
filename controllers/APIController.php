<?php

namespace Controller;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);

        //debuguear($servicios);
    }
    public static function guardar() {

        // guarda la cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];

       // $respuesta = [
          //  'cita' => $cita
        //];
        // guarda la cita y los servicios

        // almacna los ervicios con el id de la cita
        $idServicios = explode(",",$_POST['servicios']);
        foreach($idServicios as $idServicio){
            $args =[
                'citaId' => $id,
                 'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();

        }
        // se retorna una respuesta

        echo json_encode(['resultado'=> $resultado]);

    }
  public static function eliminar(){
     if($_SERVER['REQUEST_METHOD']=== 'POST'){
        $id = $_POST['id'];
        $cita = Cita::find($id);
        $cita->eliminar();
        header('Location:'. $_SERVER['HTTP_REFERER']);        
     }
  } 
} 