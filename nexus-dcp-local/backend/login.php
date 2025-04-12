<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Methods: POST");
  header("Content-Type: application/json");

  header("Access-Control-Allow-Origin: http://127.0.0.1:5500");

  // Database credentials
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
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
  }

  // Get data from POST request
  $data = json_decode(file_get_contents("php://input"), true);
  $username = $data["username"];
  $password = $data["password"];

  // Prepare SQL query to find user by username
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    // User found, verify password
    if (password_verify($password, $row['password'])) {
      echo json_encode(["success" => true]);
    } else {
      // Password incorrect
      echo json_encode(["success" => false, "error" => "Invalid password"]);
    }
  } else {
    // User not found
    echo json_encode(["success" => false, "error" => "User not found"]);
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
?>
