<h1 class="nombre-pagina">Nuevo Servicio</h1>
<h2 class="descripcion-pagina">Llena todos los campos para añadir un nuevo servicio</h2>

<?php
    include __DIR__ . '/../templates/barra.php';
    include __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">

  <?php
       include_once __DIR__ . '/formulario.php'; 
  ?>
  <input type="submit" class="boton" value="Guardar Servicio">
</form>