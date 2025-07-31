<?php
    require('libreria/motor.php');
    plantilla::aplicar();

    $datos = listar_registro();

    $total_profesiones = 0;
    $total_edades = 0;
    $cantidad_personajes = 0;
    $categorias = [];
    $niveles_experiencia = [];
    $salarios = [];
    $personaje_salarial_max = null;
    $max_salario = 0;
    $min_salario = PHP_INT_MAX;
    $persona_max_salario = null;
    $profesion_max = null;
    $profesion_min = null;

    // Inicializamos las variables
    foreach ($datos as $personaje) {
        $cantidad_personajes++;
        $total_edades += $personaje->edad();
        $total_profesiones += count($personaje->profesiones);

        // Buscar la profesión mejor remunerada
        foreach ($personaje->profesiones as $profesion) {
            if ($profesion_max === null || $profesion->salario > $profesion_max->salario) {
                $profesion_max = $profesion;
            }
        }

            // Buscar la profesión menos remunerada
        foreach ($personaje->profesiones as $profesion) {
            if ($profesion->salario < $min_salario) {
                $min_salario = $profesion->salario;
                $profesion_min = $profesion;
            }
        }

        // Distribuir categorías y contar las profesiones
        foreach ($personaje->profesiones as $profesion) {

            $nivel = $profesion->nivel_experiencia;
            if(isset($niveles_experiencia[$nivel])) {
                $niveles_experiencia[$nivel] += 1; // Sumar la frecuencia
            } else {
                $niveles_experiencia[$nivel] = 1; // Inicializar la frecuencia
        }

            $categorias[$profesion->categoria] = isset($categorias[$profesion->categoria]) ? $categorias[$profesion->categoria] + 1 : 1;
            
            // Calcular salarios
            $salarios[] = $profesion->salario;
            
            // Comprobar el salario más alto y bajo
            if ($profesion->salario > $max_salario) {
                $max_salario = $profesion->salario;
                $persona_max_salario = $personaje;
            }
            if ($profesion->salario < $min_salario) {
                $min_salario = $profesion->salario;
            }

            // Contar niveles de experiencia
            $niveles_experiencia[$profesion->nivel_experiencia] = isset($niveles_experiencia[$profesion->nivel_experiencia]) ? $niveles_experiencia[$profesion->nivel_experiencia] + 1 : 1;
        }
    }


    // Cálculos
    $promedio_profesiones = $cantidad_personajes > 0 ? $total_profesiones / $cantidad_personajes : 0;
    $edad_promedio = $cantidad_personajes > 0 ? $total_edades / $cantidad_personajes : 0;
    $salario_promedio = count($salarios) > 0 ? array_sum($salarios) / count($salarios) : 0;
    $nivel_experiencia_comun = array_search(max($niveles_experiencia), $niveles_experiencia);
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Barbie</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlazamos el CSS -->
</head>
<body>

    <header>
    <h1>📊 Panel de Estadísticas de Barbie</h1>
</header>

<div class="d-derecha">
    <a href="index.php" class="boton">Volver al listado</a>  
</div>

<main class="dashboard">
    <section class="stats grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>👯‍♀️ Total de Barbies</h2>
            <p><?php echo $cantidad_personajes; ?></p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>🦋 Total de profesiones</h2>
            <p><?php echo $total_profesiones; ?></p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>📈 Promedio de profesiones</h2>
            <p><?php echo number_format($promedio_profesiones, 2); ?></p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>🤭 Edad promedio</h2>
            <p><?php echo number_format($edad_promedio, 2); ?> años</p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>💥 Nivel de experiencia más común</h2>
            <p><?php echo $nivel_experiencia_comun; ?></p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>🔥 Profesión mejor remunerada</h2>
            <p>
            <?php 
            if (!empty($profesion_max)) {
                echo $profesion_max->nombre . " (" . number_format($profesion_max->salario, 2) . ")";
            } else {
                echo "No hay profesiones registradas.";
            }
            ?>                
            </p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>📉 Profesión menos remunerada</h2>
            <p><?php 
            if ($profesion_min) {
                echo $profesion_min->nombre . " (" . number_format($profesion_min->salario, 2) . ")";
            } else {
                echo "No hay profesiones registradas.";
            }
            ?></p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>🪷 Salario promedio en el mundo Barbie</h2>
            <p><?php echo number_format($salario_promedio, 2); ?></p>
        </div>
        <br>
        <div class="card bg-white p-6 rounded-lg shadow-md text-center">
            <h2>🤹🏻‍♀️ Barbie mejor pagada</h2>
            <p><?php echo $persona_max_salario->nombre . " " . $persona_max_salario->apellido; ?> (<?php echo $max_salario; ?>)</p>
        </div>
    </section>
</main>



</body>
</html>

<!-- Gráfico Chart.js -->
<h2><strong> <i>⭐ Barbies organizadas por profesión:</i></strong></h2>
<div style="display: flex; justify-content: space-around;">
    <!-- Gráfico de torta (Pie) -->
    <canvas id="salariosPorCategoria" width="250" height="150"></canvas>

    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de torta
    var ctx1 = document.getElementById('salariosPorCategoria').getContext('2d');
    var chart1 = new Chart(ctx1, {
        type: 'pie', // Gráfico de torta
        data: {
            labels: <?php echo json_encode(array_keys($categorias)); ?>,
            datasets: [{
                label: 'Distribución de salarios por categoría',
                data: <?php echo json_encode(array_values($categorias)); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#66FF66', '#FF5733'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var label = tooltipItem.label || '';
                            var salary = tooltipItem.raw ? tooltipItem.raw : 0;
                            return label + ': ' + salary;
                        }
                    }
                }
            }
        }
    });
</script>
