<?php

$username = "root";
$password = "";
$localhost = "localhost";
$dbname = "openhouse";

//Datos de conexión
$conn = mysqli_connect($localhost, $username, $password, $dbname) or die("Error al conectar" . mysqli_connect_error());

 ?>
