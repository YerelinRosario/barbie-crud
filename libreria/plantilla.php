<?php

class plantilla{

    static $instancia = null;

    public static function aplicar(){
        if(self:: $instancia == null){
            self::$instancia = new plantilla();
        }
    }

    public function __construct(){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mundo de Barbie💖</title>
            <link rel="icon" href="img/favicon.jpg" type="image/x-icon">
            <link rel="stylesheet" type="text/css" href="style.css">
            <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">


</head>
<body>
    <div class="container">
        <?php
    }
    public function __destruct(){
        ?>
        </div>
        <hr>
           <p style="text-align:center">💅 Desarrollado con amor por Yerelin Rosario | ¡Nunca dejes de soñar como Barbie! 🌟</p>
     </body>
</html>
        <?php
    }
}