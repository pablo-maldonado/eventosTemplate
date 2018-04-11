<?php
	REQUIRE("conexion.php");
	$event_name = $_POST["event_name"];

	$response =array('status'=>false, 'message'=>"No se ha podido agregar el evento", 'events_id' => -1);

	if (empty($event_name)) {
		$response['message'] = 'Debes ingresar el nombre del evento';
 		echo json_encode($response);
		die();
  }
	$sql = "INSERT INTO events_ (events_id, events_name) VALUES (NULL, '$event_name')";
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
	}


 	echo json_encode($response);
	die();
