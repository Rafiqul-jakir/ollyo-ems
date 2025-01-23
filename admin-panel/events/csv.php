<?php
require_once "../../config/app.php";

$app = App::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['eventid'])) {
        $eventId = $_GET['eventid'];

        // Get attendee info
        $attendeeInfo = $app->selectAll("SELECT name, phone FROM `attendees` WHERE event_id = '$eventId'");

        // Get event title
        $eventTitle = $app->selectOne("SELECT title FROM `events` WHERE id = '$eventId'");

        // Check if event title exists
        if ($eventTitle) {
            $filename = $eventTitle->title . '.csv';

            // Set headers for CSV file download
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Open output stream
            $output = fopen('php://output', 'w');

            // Write the column headers
            fputcsv($output, ['Name', 'Phone']);

            // Write attendee data
            if ($attendeeInfo) {
                foreach ($attendeeInfo as $attendee) {
                    fputcsv($output, [$attendee->name, $attendee->phone]);
                }
            }

            // Close the output stream
            fclose($output);
        } else {
            echo "Event not found.";
        }
    } else {
        echo "Event ID is required.";
    }
}
