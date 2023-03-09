<?php
    require "bd-connect.php";       // Conectamos con la base de datos [don't touch]

    $nodo 		     = $_POST['nodo'];                  // Cogemos el nodo por $_POST                   //1
    $nombre 		 = $_POST['nombre'];                // Cogemos el nombre por $_POST                 //Bulbasur
    $caracteristicas = $_POST['caracteristicas'];       // Cogemos las caracterisitcas por $_POST       //Es de tipus planta?
    $nombreAnterior  = $_POST['nombreAnterior'];        // Cogemos el nombre anteiror por $_POST        //Pikachu

    $sonL = $nodo * 2;                                                                                  //Nodo de Bulbasur
    $sonR = $nodo * 2 + 1;                                                                              //Nodo de Pikachu

    // Insertamos la nueva pregunta en la tabla arbol
        $consulta = "INSERT INTO `arbol`(`nodo`, `texto`, `pregunta`) VALUES ('".$sonL."','".$nombre."',FALSE);";
        mysqli_query($enlace, $consulta);

    // Insertamos la respuesta correcta en la tabla arbol
        $consulta = "INSERT INTO `arbol`(`nodo`, `texto`, `pregunta`) VALUES ('".$sonR."','".$nombreAnterior."',FALSE);";
        mysqli_query($enlace, $consulta);

    // Actualizamos el nodo actual
        $consulta = "UPDATE `arbol` SET `texto`='".$caracteristicas."',`pregunta`=true WHERE `nodo`= '".$nodo."';";
        mysqli_query($enlace, $consulta);

    //GUARDAMOS EL LOG DE LA PARTIDA
        $consulta = "INSERT INTO `partida`(`personaje`, `acierto`) VALUES ('".$nombre."', true)";
        mysqli_query($enlace, $consulta);

    //VOLVEMOS A LA PÁGINA PRINCIPAL
        header("Location:game.php?n=1&r=0");
?>
