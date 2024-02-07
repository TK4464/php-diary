<?php

require_once __DIR__ . '/classes/Diary.php';
require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';

session_start();

if (!isset($_SESSION['userId']) && !isset($_COOKIE['userId'])) {
    header('Location: ./login.php');
    die();
}

if (isset($_POST['submit-button'])) {
    $title = $_POST['title'];
    $createdAt = $_POST['created-at'];
    $body = $_POST['body'];

    $diary = new Diary();
    $diary->setTitle($title);
    $diary->setBody($body);
    $diary->setCreatedAt($createdAt);

    $userId = $_SESSION['userId'] ?? $_COOKIE['userId'];
    $userData = new UserData();
    $user = $userData->get($userId);
    $diary->setAuthor($user);

    $diaryData = new DiaryData();
    $diaryData->save($diary);

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
            <h1 class="title has-text-centered">投稿ページ</h1>
            <form action="./post.php" method="post">

                <div class="field">
                    <label class="label">タイトル</label>
                    <div class="control">
                        <input class="input" type="text" name="title">
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
                        <textarea class="textarea" name="body"></textarea>
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
