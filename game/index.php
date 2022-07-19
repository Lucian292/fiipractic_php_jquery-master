<?php
ini_set('display_errors', 1);
require_once "../connect.php";

$connection = getConnection();

$sql = "SELECT * from youtube_links yl JOIN answers a on a.youtube_link_id = yl.id";
$youtubeLinks = $connection
    ->query($sql)
    ->fetchAll();

$songs = [];
foreach ($youtubeLinks as $key => $youtubeLink) {
    $youtubeLinkId = $youtubeLink['youtube_link_id'];
    $videoId = $youtubeLink['video_id'];
    $start = $youtubeLink['start'];
    $end = $youtubeLink['end'];

    $answer = [
        'answer' => $youtubeLink['answer'],
        'is_correct' => $youtubeLink['is_correct'],
        'id' => $youtubeLink['id']
    ];
    
    if(!array_key_exists($youtubeLinkId, $songs)) {
        $songs[$youtubeLinkId] = [
            'video_id' => $videoId,
            'id' => $youtubeLinkId,
            'start' => $start,
            'end' => $end,
            'answers' => []
        ];
    }

    $songs[$youtubeLinkId]['answers'][] = $answer;

}
shuffle($songs);


?>

<html>
<head>
    <title>Game</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="../js/game.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/game.css">
    <style>

    </style>
</head>

<body>
<div class="container">
    <div class="content text-center py-5">
        <h1>Guess the song</h1>
        <div class="button-wrapper">
            <button type="button" id="play" class="btn btn-primary "><i class="bi bi-play"></i></button>
        </div>
        <div class="py-5" id="progress-wrapper"></div>
        <div id="player-wrapper">
            <div id="player"></div>
            <div id="player-icon"></div>
        </div>
        <div id="answers-wrapper" class="py-5"></div>
    </div>
</div>
</body>
<script>
    var songs =  <?php echo json_encode($songs); ?>;
</script>
</html>
