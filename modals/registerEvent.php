<?php
	REQUIRE("conexion.php");
	header("Content-Type: text/html;charset=utf-8");
	$event_name = $_POST["event_name"];
	$event_date = $_POST["event_date"];
	$event_addres = $_POST["event_addres"];
	$event_photo = $_POST["event_photo"];
	$event_description = $_POST["event_description"];

	$prueba_date = date_parse($event_date);

	$response =array('status'=>false, 'message'=>"No se ha podido agregar el evento", 'events_id' => -1, 'events_description'=>"Sin descripción");

	if (empty($event_name)) {
		$response['message'] = 'Debes ingresar el nombre del evento';
 		echo json_encode($response);
		die();
  }
	if (empty($event_date)) {
		$response['message'] = 'Debes ingresar fecha';
 		echo json_encode($response);
		die();
  }
	if (empty($event_description)) {
		$event_description = 'El evento ' . $event_name . " se realizará el " . $prueba_date["day"] . "-" . $prueba_date["month"]. "-" . $prueba_date["year"];
	}
	if (empty($event_addres)) {
		$event_addres = 'Lugar desconocido...';
	}

	$sql = "INSERT INTO events_ (events_id, events_name, events_description, events_date, events_addres, events_photo) VALUES (NULL, '$event_name', '$event_description', STR_TO_DATE('$event_date', '%Y-%m-%d'), '$event_addres', '$event_photo')";
	$result = mysqli_query($conn, $sql);

	$sqlSelectId = "SELECT events_id FROM events_ order by events_id desc LIMIT 1";
	$resultSelectId = mysqli_query($conn, $sqlSelectId);
		while ($row = mysqli_fetch_array($resultSelectId)) {
			$events_id = $row["events_id"];
		}

	if ($result) {
		$response['status'] = true;
		$response['message'] = "Se ha registrado el evento $event_name correctamente";
		$response['events_id'] = $events_id;
		$response['events_description'] = $event_description;
	}

 	echo json_encode($response);
	die();
