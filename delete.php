<?php
//削除機能を実装する
// delete.php?id=◯から diary を消したい取得
//DiaryDataのdeleteメソッドを使う
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

$diaryData = new DiaryData();
$diaryData->delete($diary);


?>

<html>
<?php include __DIR__ . '/includes/head.php' ?>
<body>
    <?php include __DIR__ . '/includes/Header.php' ?>
    <div class="card mx-auto" style="max-width:400px;"">
        <div class="card-content">
            <p>削除しました</p>
            <a href="./index.php">一覧へ</a>
        </div>
    </div>
    <?php include __DIR__ . '/includes/footer.php' ?>
</body>

</html>
