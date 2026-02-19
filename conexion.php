<?php

  //CONEXION A LA BASE DE DATOS
 function conectarDB(){

      $user="julisa";//USUARIO
      $pass="juVadasa21";//CONTRASEÑA
      $server="localhost";//SERVIDOR
      $db="varadero";//BASE DE DATOS

    $conexion = mysqli_connect($server, $user, $pass, $db) or die 
    ("Error en la conexion");

    return $conexion;
  }
    
