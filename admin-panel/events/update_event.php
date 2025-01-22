<?php
require_once  "../../config/app.php";
$app = App::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['eventId'];
    $query = "DELETE FROM `events` WHERE id = :id";
    $arr = [
        ":id" => $eventId
    ];
    $stmt = $app->link->prepare($query);
    $stmt->execute($arr);
}
