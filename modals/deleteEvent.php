<?php
	REQUIRE("conexion.php");
	$events_id = $_POST["events_id"];
	$force = $_POST["force_event"];
	// if (isset($_POST["force_event"])) {
	// 	$force = $_POST["force_event"];
	// }else {
	// 	$force = 0;
	// }
	$response =array('status'=>false, 'message'=>"No se ha podido eliminar el evento", 'event_name'=> " ");
	if (empty($events_id)) {
		$response['message'] = 'Sucedió un error, por favor refresque (F5) y vuelva a intentarlo';
 		echo json_encode($response);
		die();
  }
	$sqlSelect = "SELECT events_name FROM events_ WHERE events_id = $events_id;";
	$result_events_name = mysqli_query($conn, $sqlSelect);
	while ($row_name = mysqli_fetch_array($result_events_name)) {
		$event_name = $row_name["events_name"];
	}
	if ($force == 0) {
		$sqlDelete = "DELETE FROM events_ WHERE events_id = $events_id;";
		$result = mysqli_query($conn, $sqlDelete);
		$resultDeleteRow = $result;
	}else if ($force == 1) {
		$sqlDeleteRowFromEvent = "DELETE FROM user_event WHERE events_id = $events_id;";
		$sqlDelete = "DELETE FROM events_ WHERE events_id = $events_id;";
		$resultDeleteRow = mysqli_query($conn, $sqlDeleteRowFromEvent);
		$result = mysqli_query($conn, $sqlDelete);
	}


	if ($result && $resultDeleteRow) {
		$response['status'] = true;
		$response['event_name'] = $event_name;
	}

 	echo json_encode($response);
	die();
