<?php
//削除機能を実装する
// delete.php?id=◯から comment を消したい取得
//CommentDataのdeleteメソッドを使う
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

$commentData = new CommentData();
$commentData->delete($comment);


?>

<html>
<?php include __DIR__ . '/includes/head.php' ?>
<body>
    <?php include __DIR__ . '/includes/Header.php' ?>
    <div class="card mx-auto" style="max-width:400px;">
        <div class="card-content">
            <p>削除しました</p>
            <a href="./index.php">一覧へ</a>
        </div>
    </div>
    <?php include __DIR__ . '/includes/footer.php' ?>
</body>

</html>
