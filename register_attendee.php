<?php
require_once  "config/app.php";
$app = App::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $eventId = htmlspecialchars(trim($_POST['eventId']));
    $userId = htmlspecialchars(trim($_POST['userId']));

    $query = "INSERT INTO `attendees`(`name`, `phone`, `event_id`, `user_id`) VALUES (:name, :phone, :event_id, :user_id)";
    $arr = [
        ":name" => $name,
        ":phone" => $phone,
        ":event_id" => $eventId,
        ":user_id" => $userId,
    ];
    // Check if the query executes successfully
    try {
        $register_event = $app->link->prepare($query);
        $register_event->execute($arr);
        echo "success";
    } catch (Exception $e) {
        echo "insert failed";
    }
}
