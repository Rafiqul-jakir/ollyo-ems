<?php
require_once  "../../config/app.php";
$app = App::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['eventTitle']));
    $eventDescription = htmlspecialchars(trim($_POST['eventDescription']));
    $totalAttendee = htmlspecialchars(trim($_POST['totalAttendee']));
    $eventDate = htmlspecialchars(trim($_POST['eventDate']));
    $eventTime = htmlspecialchars(trim($_POST['eventTime']));
    $createdBy = htmlspecialchars(trim($_POST['createdBy']));
    $eventId = htmlspecialchars(trim($_POST['eventId']));

    header('Content-Type: application/json');
    // Validate inputs
    if (empty($title) || empty($eventDescription) || empty($totalAttendee) || empty($eventDate) || empty($eventTime)) {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
        exit;
    }
    if (empty($eventId)) {
        $query = "INSERT INTO `events`(`title`, `description`, `max_capacity`, `event_date`, `time`, `created_by`) VALUES (:title, :description, :max_capacity, :event_date, :time, :created_by )";
        $arr = [
            ":title" => $title,
            ":description" => $eventDescription,
            ":max_capacity" => $totalAttendee,
            ":event_date" => $eventDate,
            ":time" => $eventTime,
            ":created_by" => $createdBy,
        ];
        // Check if the query executes successfully
        try {
            $register_event = $app->link->prepare($query);
            $register_event->execute($arr);
            echo json_encode(["status" => "success", "message" => "Event created successfully !"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Event not created !"]);
        }
    } else {

        $query = "UPDATE `events` SET `title`= :title,`description`=:description,`max_capacity`=:max_capacity,`event_date`=:event_date,`time`= :time WHERE id = :id";
        $arr = [
            ":title" => $title,
            ":description" => $eventDescription,
            ":max_capacity" => $totalAttendee,
            ":event_date" => $eventDate,
            ":time" => $eventTime,
            ":id" => $eventId,
        ];
        // Check if the query executes successfully
        try {
            $update_event = $app->link->prepare($query);
            $update_event->execute($arr);
            echo json_encode(["status" => "success", "message" => "Event updated successfully !"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "success", "message" => "Event not updated !"]);
        }
    }
}
