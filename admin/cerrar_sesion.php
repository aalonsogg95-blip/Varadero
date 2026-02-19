<?php
 session_start();

 unset($_SESSION["datosUsuarioVaradero"]);
//  session_unset();
//  session_destroy();
 header("location: index.php");