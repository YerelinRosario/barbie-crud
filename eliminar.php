<?php
require('libreria/motor.php');
plantilla::aplicar();

if (isset($_GET['codigo'])) {
    $archivo = "datos/" . $_GET['codigo'] . ".dat";
    if (file_exists($archivo)) {
        unlink($archivo);
        echo "<h1>🗑️ Barbie eliminada</h1>";
        echo "<p>La Barbie ha sido eliminada correctamente.</p>";
    } else {
        echo "<h1>🚫 ERROR</h1>";
        echo "<p>No se encontró el archivo a eliminar.</p>";
    }
} else {
    echo "<h1>🚫 ERROR</h1>";
    echo "<p>No se recibió ningún código para eliminar.</p>";
}
?>

<div class="d-derecha">
    <a href="index.php" class="boton">Volver al listado</a>
</div>
