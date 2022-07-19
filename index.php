<?php

require_once "connect.php";

$connection = getConnection();
$youtubeLinks = $connection
    ->query("SELECT id, video_id, start, end FROM youtube_links")
    ->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Songs</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="js/admin.js" type="text/javascript"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
<?php require_once "navbar_partial.php"?>
<div class="container">
    <div class="content py-5">
        <h1>Manage songs</h1>
        <div class="mt-3 mb-3">
            <a href="add_song_page.php" class="btn btn-primary">Add new song</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Video id</th>
                <th scope="col">Image</th>
                <th scope="col">start</th>
                <th scope="col">end</th>
                <th scope="col">answers</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($youtubeLinks as $key => $youtubeLink): ?>
                <tr>
                    <th scope="row"><?php echo $youtubeLink['id'] ?></th>
                    <td><?php echo $youtubeLink['video_id'] ?></td>
                    <td>
                        <img alt="youtube_image"
                             src="https://img.youtube.com/vi/<?php echo $youtubeLink['video_id'] ?>/default.jpg">
                    </td>
                    <td><?php echo $youtubeLink['start'] ?></td>
                    <td><?php echo $youtubeLink['end'] ?></td>
                    <td>
                        <a href="answers_page.php?id=<?php echo $youtubeLink['id'] ?>" class="btn btn-primary"><i
                                    class="bi bi-binoculars"></i></a>
                    </td>
                    <td>
                        <a href="edit_song_page.php?id=<?php echo $youtubeLink['id'] ?>" type="button"
                           class="btn btn-primary"><i class="bi bi-pencil"></i> </a>
                        <form action="delete_song_in_database.php" method="POST" class="pt-2 pb-2">
                            <input type="hidden" name="id" value="<?php echo $youtubeLink['id'] ?>">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-archive"></i></button>
                        </form>
                        <button data-video-id="<?php echo $youtubeLink['video_id'] ?>"
                                data-start="<?php echo $youtubeLink['start'] ?>"
                                data-end="<?php echo $youtubeLink['end'] ?>" class="btn btn-primary play"><i
                                    class="bi bi-play"></i></button>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="player-wrapper text-center p-5">
            <div id="player"></div>
        </div>
    </div>

</div>
</body>
</html>

