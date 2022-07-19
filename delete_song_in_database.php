<?php
require_once "connect.php";

$id = $_POST['id'];


$connection  = getConnection();

$sql = "SELECT COUNT(id) FROM youtube_links WHERE id = :id";
$query =  $connection->prepare($sql);
$query->execute(['id' => $id]);
$youtubeLinkExist = $query->fetchColumn();

if($youtubeLinkExist) {
    $sql = "DELETE FROM youtube_links WHERE id = :id";
    $query = $connection->prepare($sql);
    $query->execute([
        'id' => $id
    ]);
}

header("Location: /index.php");