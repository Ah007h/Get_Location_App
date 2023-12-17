<?php
	if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
	}
	include_once("dbconnect.php");
	$userid = $_POST['userid'];
  $name= ucwords(addslashes($_POST['name']));
	
  
  $state= addslashes($_POST['state']);
  $local= addslashes($_POST['local']);
  $lat= $_POST['lat'];
  $lon= $_POST['lon'];
  
	
	$sqlinsert = "INSERT INTO `tbl_locations`( `user_id`, `user_name`, `user_state`, `user_local`, `user_lat`, `user_long`) VALUES ('$userid','$name','$state','$local','$lat','$lon')";
	
  try {
		if ($conn->query($sqlinsert) === TRUE) {
			
			
			$response = array('status' => 'success', 'data' => null);
			sendJsonResponse($response);
		}
		else{
			$response = array('status' => 'failed', 'data' => null);
			sendJsonResponse($response);
		}
	}
	catch(Exception $e) {
		$response = array('status' => 'failed', 'data' => null);
		sendJsonResponse($response);
	}
	$conn->close();
	
	function sendJsonResponse($sentArray)
	{
    header('Content-Type= application/json');
    echo json_encode($sentArray);
	}
?>