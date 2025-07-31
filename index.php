<?php
    require('libreria/motor.php');
    plantilla::aplicar();
?>

<h1 style="font-family: 'Dancing Script', cursive;">🩷 Bienvenida al universo profesional de Barbie ✨</h1>
<p>¡Bienvenida a un mundo donde los sueños se hacen realidad! Aquí puedes registrar y gestionar todas las increíbles profesiones de Barbie. Desde astronauta hasta diseñadora de moda, cada carrera es una oportunidad para brillar. Porque ser una líder nunca pasa de moda. 🌸👑</p>
<p>Barbies registradas:</p>

<style>
    .d-derecha {
        text-align: right;
    }
</style>

<div class="d-derecha">
    <a href="registro.php" class="boton">Registrar Barbie</a>
</div>

<div class="d-izquierda">
    <a href="panel.php" class="boton">Ir al Dashboard</a>  
</div>

<table>
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Profesión</th>
            <th>Salario</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $datos = listar_registro();

            foreach($datos as $personaje){
                echo "
                <tr>
                    <td><img src='{$personaje->foto}' alt='{$personaje->nombre}' width='50'></td>
                    <td>{$personaje->nombre} {$personaje->apellido}</td>
                    <td>{$personaje->edad()}</td>
                    <td>{$personaje->n_profesiones()}</td>
                    <td>{$personaje->salario()}</td>
                    <td>
                        <a href='registro.php?codigo={$personaje->identificacion}' class='button'>Editar</a>
                        <a href='eliminar.php?codigo={$personaje->identificacion}' class='button' onclick=\"return confirm('¿Estás segura de que deseas eliminar esta Barbie?')\">Eliminar</a>
                    </td>
                </tr>
                ";
            }
        ?>
    </tbody>
</table>
