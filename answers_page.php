<?php

ini_set('display_errors', 1);
require_once "connect.php";

$youtubeLinkId = $_GET["id"];
$connection = getConnection();

$sql = "SELECT COUNT(id) FROM youtube_links WHERE id = :id";
$query = $connection->prepare($sql);
$query->execute(['id' => $youtubeLinkId]);
$youtubeLinkExist = $query->fetchColumn();

if (!$youtubeLinkExist) {
    echo "NO_YOUTUBE_LINK";
    exit;
}

$sql = "SELECT answer, is_correct, youtube_link_id FROM answers WHERE youtube_link_id=:youtube_link_id";
$query = $connection->prepare($sql);
$query->execute(['youtube_link_id' => $youtubeLinkId]);
$answers = $query->fetchAll();

if (!count($answers)) {
    for ($i = 0; $i < 3; $i++) {
        $answers[] = [
            'answer' => null,
            'is_correct' => false
        ];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add song</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php require_once "navbar_partial.php"?>
<div class="container">
    <h1>Answers</h1>
    <form method="post" action="answers_database.php">
        <div class="mb-3">
            <select class="form-select" name="is_correct">
                <?php foreach ($answers as $key => $answerItem): ?>
                    <option <?php if ($answerItem['is_correct']): ?> selected <?php endif; ?>
                            value="<?php echo $key + 1 ?>">Answer <?php echo $key + 1 ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php foreach ($answers as $key => $answerItem): ?>
            <div class="mb-3">
                <label for="answer_<?php echo $key ?>" class="form-label">Answer <?php echo $key + 1 ?></label>
                <input required type="text" name="answers[<?php echo $key + 1 ?>]"
                       value="<?php echo $answerItem['answer'] ?>" class="form-control" id="answer_<?php echo $key ?>">
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="id" value="<?php echo $youtubeLinkId ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>


