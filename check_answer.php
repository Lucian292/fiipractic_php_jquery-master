<?php
ini_set('display_errors', 1);

require_once "connect.php";

$answerId = $_POST['answer_id'];
$songId = $_POST['song_id'];

$connection = getConnection();
$sql = "SELECT COUNT(a.id) FROM answers a WHERE a.id = :answear_id AND youtube_link_id = :song_id AND is_correct = 1";
$query = $connection->prepare($sql);
$query->execute([
   "answear_id" => $answerId,
   "song_id" => $songId
]);

$status = $query->fetchColumn();

echo  $status;
