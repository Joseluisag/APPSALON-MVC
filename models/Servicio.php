<?php

namespace Model;
use MVC\Router;

class Servicio extends ActiveRecord{
    // base dedatos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio'];
    
    public $id;
    public $nombre;
    public $precio;

    public function __construct($args=[])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';

    }
    public function validar(){
        if(!$this->nombre){
          self::$alertas['error'][] = 'El nombre del servicio es oblogatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] = 'El precio del servicio es oblogatorio';
        }
        if(!is_numeric($this->precio)){
            self::$alertas['error'][] = 'El precio no es válido';
        }
        return self::$alertas;
    }

}