<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
// funcio para determinar el total a pagar de los servicios
function esUltimo(string $actual, string $proximo): bool {
   if($actual !== $proximo){
        return true;
   }
   return false;
}
// funcion para revisar que el usuario este autentificado

function isAuth() : void{
   if(!isset($_SESSION['login'])){
     header('Location: /');
     
   }
}
function isAdmin(){
  if(!isset($_SESSION['admin'])){
     header('Location: /');
  }
}