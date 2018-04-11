<?php
	REQUIRE("conexion.php");
	$events_id = $_POST["events_id"];

	$response =array('status'=>false, 'message'=>"No se ha podido eliminar el evento");
	if (empty($events_id)) {
		$response['message'] = 'Sucedió un error, por favor refresque (F5) y vuelva a intentarlo';
 		echo json_encode($response);
		die();
  }
	$sqlSelect = "SELECT events_name FROM events_ WHERE events_id = $events_id;";
	$events_name = mysqli_query($conn, $sqlSelect);

  $sqlDelete = "DELETE FROM events_ WHERE events_id = $events_id;";
  $result = mysqli_query($conn, $sqlDelete);
	if ($result) {
		$response['status'] = true;
		$response['message'] = "Se ha eliminado el evento $events_id correctamente";
	}
	
 	echo json_encode($response);
	die();
