<?php
 session_start();
 

unset($_SESSION["datosUsuarioCaja"]);


  header("location: index.php");