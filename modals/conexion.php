<?php
header("Content-Type: text/html;charset=utf-8");
$username = "root";
$password = "";
$localhost = "localhost";
$dbname = "arkano_events";

//Datos de conexión
$conn = mysqli_connect($localhost, $username, $password, $dbname) or die("Error al conectar" . mysqli_connect_error());
 ?>
