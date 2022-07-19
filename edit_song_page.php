<?php
require_once "connect.php";
$id = $_GET['id'];
$connection = getConnection();

$sql = "SELECT video_id, start, end FROM youtube_links WHERE id = :id";
$query =  $connection->prepare($sql);
$query->execute(['id' => $id]);
$youtubeLink = $query->fetch();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit song</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php require_once "navbar_partial.php"?>
<div class="container">
    <h1>Edit song</h1>
    <form method="post" action="edit_song_in_database.php">
        <div class="mb-3">
            <label for="video_id" class="form-label">Video id</label>
            <input required type="text" name="video_id" class="form-control" value="<?php echo $youtubeLink['video_id']?>" id="video_id">
        </div>
        <div class="mb-3">
            <label for="start" class="form-label">Start</label>
            <input required type="number" name="start" class="form-control" value="<?php echo $youtubeLink['start']?>" id="start">
        </div>
        <div class="mb-3">
            <label for="end" class="form-label">End</label>
            <input required type="number" name="end" class="form-control" value="<?php echo $youtubeLink['end']?>" id="end">
        </div>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
