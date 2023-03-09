<?php
    $mysql_host = "localhost";      // Host de la base de datos [don't touch]
    $mysql_bd = "pokinator";         // Nombre de la base de datos [don't touch]
    $mysql_user = "root";           // User del phpMyAdmin [Es el "default", cambiarlo en caso de ser necesario]
    $mysql_passwd = "";             // Passord del phpMyAdmin [Es el "default", cambiarlo en caso de ser necesario]

    $enlace = mysqli_connect($mysql_host, $mysql_user, $mysql_passwd, $mysql_bd);   // Enlace de conexion a la BBDD
    if (mysqli_connect_Errno()) { 
        echo('Conection error: ' . mysqli_error());                                 // En caso de que falle la conexion muestra un mensaje con el error
        exit(); }     
    mysqli_set_charset($enlace,"utf8");                                             // Hacemos que todos los caracteres se vean [UTF8]
?>