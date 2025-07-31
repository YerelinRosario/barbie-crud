<?php
    require('libreria/motor.php');
    plantilla::aplicar();

    $p = new personaje();

    if(isset($_GET['codigo'])){
        $p = cargar_datos($_GET['codigo']);

        if(!$p){
            echo "<h1> 🚨 Error</h1>";
            echo "<p> Esta Barbie no existe.☹️</p>";
            echo "<div class='d-derecha'> <a href='index.php' class='boton'>Volver al listado</a> </div>";
            exit;
        }
    }
      

?>

<h1>👩🏻Registro de Barbies</h1>
<p>Por favor, ingrese los datos de Barbie:</p>

<form method="post" action="guardar.php">

    <?php
        echo my_input("identificacion", "Identificación",$p->identificacion, ["required"=>"required"]);
        echo my_input("nombre", "Nombre", $p->nombre, ["required"=>"required"]);
        echo my_input("apellido", "Apellido", $p->apellido, ["required"=>"required"]);
        echo my_input("fecha_nacimiento", "Fecha de nacimiento", $p->fecha_nacimiento, ["type"=>"date", "required"=>"required"]);
        echo my_input("foto", "Foto", $p->foto, ["type"=>"url"]);

    ?>
    <h3>Profesiones</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre de la profesión</th>
                <th>Categoría</th>
                <th>Nivel de experiencia</th>
                <th>Salario mensual</th>
                <td><button type="button" onclick="agregarProfesion()">+</button></td>

            </tr>
        </thead>
        <tbody id="tdProfesiones">
            <?php
                foreach($p->profesiones as $profesion){
                    echo "<tr>";
                    echo "<td><input type='text' name='profesiones[nombre][]' value='{$profesion->nombre}'></td>";
                    echo "<td><input type='text' name='profesiones[categoria][]' value='{$profesion->categoria}'></td>";
                    echo "<td><input type='number' name='profesiones[nivel_experiencia][]' value='{$profesion->nivel_experiencia}'></td>";
                    echo "<td><input type='number' name='profesiones[salario][]' value='{$profesion->salario}'></td>";
                    echo "<td><button type='button' onclick='quitarFila(this)'>❌</button></td>";
                    echo "</tr>";
                }
                
            ?>
        </tbody>
    </table>

    <div style="margin: 10px;">
       <button type="submit" class="boton">💾Guardar</button>
    </div>

    <div class="d-derecha">
    <a href="index.php" class="boton">Cancelar</a>  
</div>
    
</form>

<script>
    function agregarProfesion(){
        var tr = document.createElement("tr");

        var td = document.createElement("td");
        var input = document.createElement("input");
        input.type = "text";
        input.name = "profesiones[nombre][]";
        td.appendChild(input);
        tr.appendChild(td);

        var td = document.createElement("td");
        var input = document.createElement("input");
        input.type = "text";
        input.name = "profesiones[categoria][]";
        td.appendChild(input);
        tr.appendChild(td);

        var td = document.createElement("td");
        var input = document.createElement("input");
        input.type = "number";
        input.name = "profesiones[nivel_experiencia][]";
        td.appendChild(input);        
        tr.appendChild(td);

        var td = document.createElement("td");
        var input = document.createElement("input");
        input.type = "number";
        input.name = "profesiones[salario][]";
        td.appendChild(input);        
        tr.appendChild(td);

        var td = document.createElement("td");
        var button = document.createElement("button");
        button.type = "button";
        button.innerHTML = "❌";
        button.setAttribute("onclick", "quitarFila(this)");
        td.appendChild(button);
        tr.appendChild(td);

        document.getElementById("tdProfesiones").appendChild(tr);
    }

    function quitarFila(boton){
        if(confirm("¿Está seguro que desea eliminar esta profesion?")){
            boton.parentElement.parentElement.remove();
    
        }
    }  

</script>