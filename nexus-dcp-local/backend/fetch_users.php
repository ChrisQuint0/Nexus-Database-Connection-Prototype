<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// $host = "sql106.infinityfree.com";
// $user = "if0_38687107";
// $password = "tKpgd2aWVLG";
// $db = "if0_38687107_nexus_dcp";

$host = "localhost";
$user = "root";
$password = "";
$db = "nexus_dcp";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
  die(json_encode(["error" => "Connection failed"]));
}

$sql = "SELECT user_id, username, password FROM users";
$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
  $users[] = $row;
}

echo json_encode($users);
?>