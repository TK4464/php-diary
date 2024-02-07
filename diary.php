<?php
require_once __DIR__ . '/classes/CommentData.php';
require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/Comment.php';

session_start();

// var_dump($id);
// var_dump($_SESSION['diaryId']);

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8') : null;

$diaryData = new DiaryData();
$diary = $diaryData->get($id);


if (is_null($diary)) {
    echo '日記が見つかりませんでした。';
    exit;
}

if (isset($_POST['submit-button'])) {
    $commentBody = $_POST['commentBody'];

    $comment = new Comment();
    $comment->setCommentBody($commentBody);
    $comment->setDiary($diary);

    $userId = $_SESSION['userId'] ?? $_COOKIE['userId'];

    $userData = new UserData();
    $user = $userData->get($userId);
    $comment->setAuthor($user);

    $commentData = new CommentData();

    $commentData->save($comment);

    header('Location: ./diary.php?id=' . $id);
    die();
}


$commentData = new CommentData();
$comments = $commentData->getAll();

$myComments = [];


foreach ($comments as $comment) {
    if (intval($comment->getDiary()->getId()) === intval($id)) {
        $myComments[] = $comment;
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
            <h1 class="title has-text-centered">タイトル：<?php echo $diary->getTitle() ?></h1>
            <div>投稿日：<?php echo $diary->getCreatedAt() ?></div>
            <div>投稿者：<?php echo $diary->getAuthor()->getName() ?>さん</div>
            <div class="content">
                投稿：<?php echo nl2br($diary->getBody()) ?>
            </div>

            <!-- コメント -->

            <form action="./diary.php?id=<?php echo $id ?>" method="post">
                <div class="field">
                    <label class="label">コメント投稿</label>
                    <div class="control">
                        <textarea class="textarea" name="commentBody"></textarea>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input class="button is-primary" type="submit" name="submit-button" value="投稿">
                    </div>
                </div>
            </form>
            <div>
                <h2>コメント欄</h2>
                <?php foreach ($myComments as $comment) : ?>
                    <div>
                        <div class="card">
                            <div class="card-content">
                                <p class="subtitle">投稿者: <?php echo $comment->getAuthor()->getName() ?></p>
                                <p class="content">コメント: <?php echo $comment->getCommentBody() ?></p>
                            </div>

                            <!-- 編集・削除ボタンは自分のコメント時のみ表示 -->
                            <?php
                            $userId = $_SESSION['userId'] ?? $_COOKIE['userId'];
                            if (intval($comment->getAuthor()->getId()) === intval($userId)) :
                            ?>
                                <div class="has-text-centered">
                                <a href="./comment-edit.php?id=<?php echo $comment->getId() ?>" class="button is-primary is-small">
                                    編集
                                </a>
                                <a href="./comment-delete.php?id=<?php echo $comment->getId() ?>" class="button is-danger is-small">
                                    削除
                                </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>



            <div>
                <a class="button is-link" href="./index.php">一覧に戻る</a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php' ?>
</body>


</html>
