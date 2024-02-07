<?php

require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/DiaryData.php';

session_start();

if (!isset($_SESSION['userId']) && !isset($_COOKIE['userId'])) {
    header('Location: ./login.php');
    die();
}

$id = $_SESSION['userId'] ?? $_COOKIE['userId'];

$userData = new UserData();
$user = $userData->get($id);

$name = $user->getName();
$email = $user->getEmail();
$password = $user->getPassword();

$diaryData = new DiaryData();
$diaries = $diaryData->getAll();
$myDiaries = [];

foreach ($diaries as $diary) {
    if (intval($diary->getAuthor()->getId()) === intval($id)) {
        $myDiaries[] = $diary;
    }
}

?>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<?php include __DIR__ . '/includes/head.php' ?>

<body>
    <?php include __DIR__ . '/includes/Header.php' ?>

    <section class="section">
        <div class="container">
            <h1 class="title has-text-centered">マイページ</h1>

            <div class="field is-grouped">
                <div class="control">
                    <a class="button is-danger" href="./logout.php">ログアウト</a>
                </div>
                <div class="control">
                    <a class="button" href="./index.php">一覧へ</a>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="columns">
                        <div class="column is-one-quarter">
                            <div class="field">
                                <label class="label">ID：</label>
                                <div class="control">
                                    <?php echo $id ?>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">お名前：</label>
                                <div class="control">
                                    <?php echo $name ?>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">メールアドレス：</label>
                                <div class="control">
                                    <?php echo $email ?>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">パスワード：</label>
                                <div class="control">
                                    <?php echo $password ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <ul>
                <?php foreach ($myDiaries as $diary) : ?>
                    <li class="box">
                        <p>投稿日：<?php echo $diary->getCreatedAt() ?></p>
                        <br>
                        <a href="./diary.php?id=<?php echo $diary->getId() ?>">
                            タイトル：<?php echo $diary->getTitle() ?>
                        </a>
                        <a href="./edit.php?id=<?php echo $diary->getId() ?>" class="button is-primary is-small">
                            編集
                        </a>
                        <a href="./delete.php?id=<?php echo $diary->getId() ?>" class="button is-danger is-small">
                            削除
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php' ?>
</body>


</html>
