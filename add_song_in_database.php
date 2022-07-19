<?php

require_once "connect.php";

$id = $_POST['video_id'];
$start = $_POST['start'];
$end = $_POST['end'];

$connection  = getConnection();

$sql = "INSERT into youtube_links (video_id, start, end) VALUES (:video_id, :start, :end)";
$query =$connection->prepare($sql);
$query->execute([
    'video_id' => $id,
    'start' => $start,
    'end' => $end,
]);

header("Location: /index.php");