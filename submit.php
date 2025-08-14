<?php
$servername = "localhost";
$username = "root";         // Default WAMP username
$password = "";             // Default WAMP has no password
$dbname = "CLASSIC_BOX";    // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST
$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->score) && isset($data->game)) {
    $username = $conn->real_escape_string($data->username);
    $score = (int)$data->score;
    $game = $conn->real_escape_string($data->game);

    $sql = "INSERT INTO game_scores (username, score, game) VALUES ('$username', $score, '$game')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Score submitted!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
}

$conn->close();
?>
