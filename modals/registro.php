<?php
	REQUIRE("conexion.php");
	header("Content-Type: text/html;charset=utf-8");
	$name = $_POST["nombre"];
	$surname = $_POST["apellido"];
	$mail = $_POST["email"];
	$empresa = $_POST["empresa"];
	$birthdate = $_POST["birthdate"];
	$events_id = $_POST["events_id"];

	$response = array('status'=>false, 'message'=>"nada tipo literal");

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
	if (empty($birthdate)) {
		$response['message'] = 'Debes ingresar tu fecha de nacimiento';
 		echo json_encode($response);
		die();
	}
	$sql = "INSERT INTO user_(user_name, user_surname, user_email, user_company, user_birthdate) VALUES ('$name', '$surname', '$mail', '$empresa', STR_TO_DATE('$birthdate', '%Y-%m-%d'))";
	$result = mysqli_query($conn, $sql);

	 $sql2=	"INSERT INTO user_event(events_id, user_email) VALUES ($events_id, '$mail')";
	 $result2 = mysqli_query($conn, $sql2);

	// mysqli_set_charset($conn, "utf8");

	if ($result) {
		$response['status'] = true;
		$response['message'] = "Se ha registrado a $name $surname correctamente.";
	}




 	echo json_encode($response);
	die();
