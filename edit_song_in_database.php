<?php
ini_set('display_errors', 1);
require_once "connect.php";

$videoId = $_POST['video_id'];
$start = $_POST['start'];
$end = $_POST['end'];
$id = $_POST['id'];

$connection  = getConnection();

$sql = "SELECT video_id, start, end FROM youtube_links WHERE id = :id";
$query =  $connection->prepare($sql);
$query->execute(['id' => $id]);
$youtubeLink = $query->fetch();

if(!$youtubeLink) {
    echo "VIDEO_NOT_EXIST";
    exit;
}

$sql = "UPDATE youtube_links SET video_id = :video_id, start = :start, end = :end WHERE id = :id";
$query = $connection->prepare($sql);
$query->execute([
    'video_id' => $videoId,
    'start' => $start,
    'end' => $end,
    'id' => $id
]);


header("Location: /index.php");