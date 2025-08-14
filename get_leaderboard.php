<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CLASSIC_BOX";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed."]));
}

$game = isset($_GET["game"]) ? $conn->real_escape_string($_GET["game"]) : "";

if ($game === "") {
    echo json_encode(["success" => false, "message" => "Game not specified"]);
    exit;
}

$sql = "SELECT username, score FROM game_scores WHERE game = '$game' ORDER BY score DESC LIMIT 10";
$result = $conn->query($sql);

$leaderboard = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}

echo json_encode(["success" => true, "data" => $leaderboard]);
$conn->close();
?>
