<?php

if (!isset($_POST)) {
  $response = array('status' => 'failed', 'data' => null);
  sendJsonResponse($response);
  die();
}

include_once("dbconnect.php");

$query = "SELECT user_id, user_name FROM tbl_users";
$result = $conn->query($query);

if ($result) {
  $response = array('status' => 'success', 'data' => array());

  while ($row = $result->fetch_assoc()) {
    $user = array(
      'id' => $row['user_id'],
      'name' => $row['user_name'],
    );
    $response['data'][] = $user;
  }

  sendJsonResponse($response);
} else {
  $response = array('status' => 'failed', 'data' => null);
  sendJsonResponse($response);
}

$conn->close();

function sendJsonResponse($sentArray)
{
  header('Content-Type: application/json');
  echo json_encode($sentArray);
}

?>
