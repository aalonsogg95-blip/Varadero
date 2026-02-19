<?php
 session_start();

 unset($_SESSION['datosUsuarioAdmin']);
//  session_destroy();
 header("location: index.php");