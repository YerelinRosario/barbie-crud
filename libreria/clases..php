<?php

class personaje {
    var $identificacion = "";
    var $nombre = "";
    var $apellido = "";
    var $fecha_nacimiento = "";
    var $foto = "";
    var $profesiones = [];

    // calcular la edad
    function edad (){
        $fecha_n = strtotime($this->fecha_nacimiento);
        $fecha_actual = time();
        $edad = ($fecha_actual - $fecha_n) / (60 * 60 * 24 * 365.25);
        return floor($edad);
    }

    // Función para calcular el salario total de todas las profesiones
    public function salario() {
        $salario_total = 0;
        
        // Recorrer las profesiones del personaje y sumar los salarios
        foreach ($this->profesiones as $profesion) {
            $salario_total += $profesion->salario;
        }
        
        return $salario_total;
    }

    // contar el número de profesiones
    function n_profesiones(){
        return count($this->profesiones);
    }

    public function profesion_con_salario_alto() {
        if (empty($this->profesiones)) {
            return null;
        }
    
        usort($this->profesiones, function($a, $b) {
            return $b->salario - $a->salario;
        });

        return $this->profesiones[0];
    }
    
}

class profesion {
    var $nombre = "";
    var $categoria = "";
    var $nivel_experiencia = "";
    var $salario = "";

    public function __construct($nombre, $categoria, $nivel_experiencia, $salario) {
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->nivel_experiencia = $nivel_experiencia;
        $this->salario = $salario;
    }
}
