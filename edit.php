<?php

require_once __DIR__ . '/classes/Diary.php';
require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';

session_start();

if (!isset($_SESSION['userId']) && !isset($_COOKIE['userId'])) {
    header('Location: ./login.php');
    die();
}

// idがsetされていなかったら
if (!isset($_GET['id'])) {
    header('Location: ./index.php');
    die();
}

$id = $_GET['id'];
$diaryData = new DiaryData();
$diary = $diaryData->get($id);

$title = $diary->getTitle();
$body = $diary->getBody();


if (isset($_POST['submit-button'])) {
    $title = $_POST['title'];
    $createdAt = $_POST['created-at'];
    $body = $_POST['body'];

    $diary->setTitle($title);
    $diary->setBody($body);
    $diary->setCreatedAt($createdAt);

    $diaryData = new DiaryData();
    $diaryData->update($diary);

    header('Location: ./index.php');
    die();
}

?>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<?php include __DIR__ . '/includes/head.php' ?>

<body>
    <?php include __DIR__ . '/includes/Header.php' ?>

    <section class="section">
        <div class="container">
            <h1 class="title has-text-centered">編集ページ</h1>

            <form action="./edit.php?id=<?php echo $id ?>" method="post">
                <div class="field">
                    <label class="label">タイトル</label>
                    <div class="control">
                        <input class="input" type="text" name="title" value="<?php echo $title ?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label">日付</label>
                    <div class="control">
                        <input class="input" type="text" name="created-at">
                    </div>
                </div>

                <div class="field">
                    <label class="label">本文</label>
                    <div class="control">
                        <textarea class="textarea" name="body"><?php echo $body ?></textarea>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input class="button is-primary" type="submit" name="submit-button" value="投稿">
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php' ?>
</body>

</html>
