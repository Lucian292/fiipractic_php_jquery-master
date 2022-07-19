<?php
ini_set('display_errors', 1);
require_once "connect.php";

$youtubeVideoId = $_POST['id'];
$isCorrect = $_POST['is_correct'];
$answers = $_POST['answers'];
$connection  = getConnection();

$sql = "SELECT video_id, start, end FROM youtube_links WHERE id = :id";
$query =  $connection->prepare($sql);
$query->execute(['id' => $youtubeVideoId]);
$youtubeLink = $query->fetch();

if(!$youtubeLink) {
    echo "VIDEO_NOT_EXIST";
    exit;
}

$sql = "DELETE FROM answers WHERE youtube_link_id = :youtube_link_id";
$query =  $connection->prepare($sql);
$query->execute(['youtube_link_id' => $youtubeVideoId]);

foreach ($answers as $key => $answer) {
    $sql = "INSERT into answers (answer, is_correct, youtube_link_id) VALUES (:answer, :is_correct, :youtube_link_id)";
    $query =  $connection->prepare($sql);
    $query->execute([
        'answer' => $answer,
        'youtube_link_id' => $youtubeVideoId,
        'is_correct' => (int)$isCorrect === $key ? 1 : 0
    ]);
}

header("Location: /index.php");