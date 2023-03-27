<?php
    $servidor="sdb-57.hosting.stackcp.net";
    $usuario="usuario-d271";
    $passwd="usuario123";
    $bd="pruebasdesarrollo-353031356513";
    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);
    if(!$enlace) {
        echo "Conexion fallida: ".mysqli_connect_error();
    }
?>