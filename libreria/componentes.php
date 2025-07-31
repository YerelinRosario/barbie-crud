<?php

    function my_input($nombre, $label, $valor="", $extra=[]){

        $type = "text";
        $required ="";
        extract($extra);

        return <<<HTML
        <div style="margin:10px;">
            <label for="{$nombre}">{$label}:</label><br/>
            <input {$required} type="{$type}" style="width:400px;" value="{$valor}" name="{$nombre}" id="{$nombre}">
        </div>
    HTML;
    }

    function guardar_datos($codigo, $datos){
        if(!is_dir("datos")){
            mkdir("datos");
        }

        file_put_contents("datos/{$codigo}.dat", serialize($datos));
    }

    function cargar_datos($codigo){
        if(!file_exists("datos/{$codigo}.dat")){
       return false;
    }

        $datos = file_get_contents("datos/{$codigo}.dat");
        return unserialize($datos);
    }

    function listar_registro(){
        $registros = [];
        if (!is_dir("datos")) {
            return $registros; 
        }
        $archivos = scandir("datos");
        foreach($archivos as $archivo){
            if(!is_file("datos/{$archivo}")){
                continue;
            }

            $datos = cargar_datos(str_replace(".dat", "", $archivo));
            $registros[] = $datos;
        }
        return $registros;
    }