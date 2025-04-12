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

  if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "DB connection failed"]);
    exit;
  }

  $data = json_decode(file_get_contents("php://input"), true);
  $username = $data["username"];
  $password = $data["password"];

  // Check if user exists
  $check = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
  $check->bind_param("s", $username);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "error" => "Username already exists"]);
    exit;
  }

  $stmt = $conn->prepare("ALTER TABLE users AUTO_INCREMENT = 1");
  $stmt->execute();

  // Hash password and insert
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $hashedPassword);

  if ($stmt->execute()) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "error" => "Failed to sign up"]);
  }

   // Close the connection
   $stmt->close();
   $conn->close();
?>
