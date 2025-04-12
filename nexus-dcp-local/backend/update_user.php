<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
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

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];
$username = $data["username"];
$password = password_hash($data["password"], PASSWORD_DEFAULT);

$sql = "UPDATE users SET username = ?, password = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $username, $password, $id);
$success = $stmt->execute();

echo json_encode(["success" => $success]);
?>