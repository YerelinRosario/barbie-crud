<?php

require('libreria/motor.php');
plantilla::aplicar();


$personaje = new personaje();
$personaje->identificacion = $_POST['identificacion'];
$personaje->nombre = $_POST['nombre'];
$personaje->apellido = $_POST['apellido'];
$personaje->fecha_nacimiento = $_POST['fecha_nacimiento'];
$personaje->foto = $_POST['foto'];

if (isset($_POST['profesiones'])){

    foreach($_POST['profesiones']['nombre'] as $i=>$nombre){
        // Crear una nueva instancia de la clase profesion pasando los 4 parámetros necesarios
        $profesion = new Profesion(
            $nombre,  // nombre
            $_POST['profesiones']['categoria'][$i],  // categoria
            $_POST['profesiones']['nivel_experiencia'][$i],  // nivel_experiencia
            $_POST['profesiones']['salario'][$i]  // salario
        );
    
        // Agregar la profesión al personaje
        $personaje->profesiones[] = $profesion;
    }
    

}   


guardar_datos($personaje->identificacion,$personaje);

plantilla::aplicar();
?>

<h1>💾Datos Guardados</h1>
<p>Los datos de Barbie han sido guardados correctamente.</p>

<div class="d-derecha">
    <a href="index.php" class="boton">Volver al listado</a>  
</div>