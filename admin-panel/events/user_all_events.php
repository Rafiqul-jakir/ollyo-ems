<?php
require_once  "../../config/app.php";
$app = App::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = htmlspecialchars(trim($_POST['userId']));

    $query = "SELECT 
                events.id AS id,
                events.title,
                events.description,
                events.max_capacity AS max_capacity,
                COUNT(attendees.id) AS enroll_attendee,
                DATE_FORMAT(events.event_date, '%d %M %Y') AS event_date,
                DATE_FORMAT(events.time, '%h:%i %p') AS time
            FROM 
                events
            LEFT JOIN 
                attendees ON attendees.event_id = events.id
                WHERE events.created_by='$userId'
            GROUP BY 
                events.id
            ORDER BY 
                events.event_date";
    $admin_all_events = $app->selectAll($query);
    header('Content-Type: application/json');
    echo json_encode(["message" => "success", "data" => $admin_all_events], JSON_PRETTY_PRINT);
}
