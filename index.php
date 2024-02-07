<?php

require_once __DIR__ . '/classes/DiaryData.php';


session_start();

if (!isset($_SESSION['userId']) && !isset($_COOKIE['userId'])) {
    header('Location: ./login.php');
    die();
}

$diaryData = new DiaryData();
$diaries = $diaryData->getAll();

?>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<?php include __DIR__ . '/includes/head.php' ?>

<body>
    <?php include __DIR__ . '/includes/Header.php' ?>

    <section class="section">
        <div class="container">
            <h1 class="title has-text-centered">日記一覧</h1>

            <div class="field is-grouped">
                <div class="control">
                    <a class="button is-link" href="./my-page.php">マイページへ</a>
                </div>
                <div class="control">
                    <a class="button is-success" href="./post.php">新規作成</a>
                </div>
            </div>

            <div>
                <?php foreach ($diaries as $diary) : ?>
                    <a href="./diary.php?id=<?php echo $diary->getId() ?>">
                        <div>
                            <div class="card">
                                <div class="card-content">
                                    <p class="subtitle">投稿日：<?php echo $diary->getCreatedAt() ?></p>
                                    <p class="title is-4">
                                        タイトル：<?php echo $diary->getTitle() ?>
                                    </p>
                                    <p class="content">投稿者：<?php echo $diary->getAuthor()->getName() ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php' ?>
</body>

</html>
