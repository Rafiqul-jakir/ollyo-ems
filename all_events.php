<?php
require_once  "config/app.php";
$app = App::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $perPage = isset($_POST['per_page']) ? intval($_POST['per_page']) : 5;
    $offset = ($page - 1) * $perPage;

    // Query to count the total number of events
    $countQuery = "SELECT COUNT(*) as total_events FROM events";
    $countResult = $app->selectOne($countQuery);
    $totalEvents = $countResult->total_events;  // Get the total count of events

    // Calculate the total number of pages
    $totalPages = ceil($totalEvents / $perPage);

    $allEvents = $app->selectAll("SELECT
                                    events.id,
                                    events.title,
                                    events.description,
                                    events.max_capacity,
                                    events.event_date,
                                    events.time,
                                    events.created_by,
                                    events.created_at,
                                    (events.max_capacity - COUNT(attendees.id)) AS blank_slots
                                    FROM
                                    events
                                    LEFT JOIN
                                    attendees ON attendees.event_id = events.id
                                    GROUP BY
                                    events.id
                                    ORDER BY
                                    events.event_date LIMIT $offset, $perPage");
    // Return response as JSON
    header('Content-Type: application/json');
    if (!empty($allEvents)) {
        echo json_encode([
            "message" => "success",
            "data" => $allEvents,
            "total_pages" => $totalPages // Include total pages in the response
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["message" => "failed"]);
    }
}
