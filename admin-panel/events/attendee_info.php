<?php
require_once  "../../config/app.php";
$app = App::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $event_id = htmlspecialchars(trim($_POST['event_id']));

    $query = "SELECT name as attendeeName , phone as attendeePhone FROM `attendees` WHERE event_id = '$event_id'";
    $attendeeInfo = $app->selectAll($query);
    header('Content-Type: application/json');
    echo json_encode(["message" => "success", "data" => $attendeeInfo], JSON_PRETTY_PRINT);
}
