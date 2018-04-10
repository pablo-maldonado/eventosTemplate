<?php
	REQUIRE("conexion.php");
	$name = $_POST["nombre"];
	$surname = $_POST["apellido"];
	$mail = $_POST["email"];
	$empresa = $_POST["empresa"];
	
	$response =array('status'=>false, 'message'=>"nada tipo literal");

	if (empty($name)) {	
		$response['message'] = 'Debes ingresar nombre';
 		echo json_encode($response);
		die();
	}
	if (empty($surname)) {	
		$response['message'] = 'Debes ingresar apellido';
 		echo json_encode($response);
		die();
	}
	if (empty($mail)) {	
		$response['message'] = 'Debes ingresar mail';
 		echo json_encode($response);
		die();
	}
	$sql = "INSERT INTO user_ (user_name, user_surname, user_email, user_company, user_birthdate) VALUES ('$name', '$surname', '$mail', '$empresa', NULL)";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$response['status'] = true;
		$response['message'] = "Se ha registrado a $name $surname correctamente";
	}


 	echo json_encode($response);
	die();