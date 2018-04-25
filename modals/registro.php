<?php
	REQUIRE("conexion.php");
	header("Content-Type: text/html;charset=utf-8");
	$name = $_POST["nombre"];
	$surname = $_POST["apellido"];
	$email = $_POST["email"];
	$empresa = $_POST["empresa"];
	$birthdate = $_POST["birthdate"];
	$events_id = $_POST["events_id"];


	$response = array('status'=>false, 'message'=>"nada tipo literal", 'events_id'=>-1);

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
if (!filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL) === false) {
		$response['message'] = 'Debes ingresar un mail válido';
 		echo json_encode($response);
		die();
	}
	if (empty($birthdate)) {
		$response['message'] = 'Debes ingresar tu fecha de nacimiento';
 		echo json_encode($response);
		die();
	}
	$sql = "INSERT INTO user_(user_name, user_surname, user_email, user_company, user_birthdate) VALUES ('$name', '$surname', '$email', '$empresa', STR_TO_DATE('$birthdate', '%Y-%m-%d'))";
	$result = mysqli_query($conn, $sql);
	$sql2=	"INSERT INTO user_event(events_id, user_email) VALUES ($events_id, '$email')";
	$result2 = mysqli_query($conn, $sql2);

	if ($result&&$result2) {
		$response['status'] = true;
		$response['message'] = "Se ha registrado a $name $surname correctamente.";
		$response['events_id'] = $events_id;
	}elseif (!$result && $result2) {
		$response['status'] = true;
		$response['message'] = "Se registro a " . $name . ". Muchas gracias";
	}
	elseif (!$result2){
		$response['message'] = "Este mail ya está registrado";
	}

 	echo json_encode($response);
	die();
	?>
