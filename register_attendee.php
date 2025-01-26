<?php
require_once  "config/app.php";
$app = App::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $eventId = htmlspecialchars(trim($_POST['eventId']));
    $userId = htmlspecialchars(trim($_POST['userId']));

    header('Content-Type: application/json');
    // Validate inputs
    if (empty($name) || empty($phone) || empty($eventId) || empty($userId)) {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
        exit;
    }
    if (!is_numeric($phone) || !is_numeric($eventId) || !is_numeric($userId)) {
        echo json_encode(["status" => "error", "message" => "Invalid data format."]);
        exit;
    }
    $is_same_attendee = $app->selectOne("SELECT phone FROM `attendees` WHERE event_id = '$eventId'");
    if (!empty($is_same_attendee->phone)) {
        echo json_encode(["status" => "error", "message" => "You all ready registered this event !"]);
        exit;
    }
    $max_attendee = $app->selectOne("SELECT max_capacity FROM `events` WHERE id = '$eventId'");
    $enroll_attendee = $app->selectOne("SELECT COUNT(id) AS  total FROM `attendees` WHERE event_id='$eventId'");

    if (!$max_attendee || !$enroll_attendee) {
        echo json_encode(["status" => "error", "message" => "Event not found."]);
        exit;
    }

    // Check if there's available capacity
    if (intval($max_attendee->max_capacity) - intval($enroll_attendee->total) > 0) {
        $query = "INSERT INTO `attendees`(`name`, `phone`, `event_id`, `user_id`) VALUES (:name, :phone, :event_id, :user_id)";
        $arr = [
            ":name" => $name,
            ":phone" => $phone,
            ":event_id" => $eventId,
            ":user_id" => $userId,
        ];
        $register_event = $app->link->prepare($query);
        $register_event->execute($arr);

        echo json_encode(["status" => "success", "message" => "Event Booked successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Event is full."]);
    }
}
