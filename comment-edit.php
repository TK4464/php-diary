<?php

require_once __DIR__ . '/classes/Diary.php';
require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/Comment.php';
require_once __DIR__ . '/classes/CommentData.php';

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
$commentData = new CommentData();
$comment = $commentData->get($id);

$commentBody = $comment->getCommentBody();


if (isset($_POST['submit-button'])) {
    $commentBody = $_POST['comment'];
    $createdAt = $_POST['created-at'];


    $comment->setCommentBody($commentBody);
    $comment->setCreatedAt($createdAt);

    $commentData = new CommentData();
    $commentData->update($comment);

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

            <form action="./comment-edit.php?id=<?php echo $id ?>" method="post">
                <div class="field">
                    <label class="label">日付</label>
                    <div class="control">
                        <input class="input" type="text" name="created-at">
                    </div>
                </div>

                <div class="field">
                    <label class="label">コメント</label>
                    <div class="control">
                        <textarea class="textarea" name="comment"><?php echo $commentBody ?></textarea>
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
