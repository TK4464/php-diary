<?php

require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/User.php';

session_start();

$errorMessage = null;
$email = '';

if (isset($_POST['submit-button'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userData = new UserData();
    $users = $userData->getAll();

    foreach ($users as $user) {
        if ($email === $user->getEmail() && password_verify($password, $user->getPassword())) {
            $_SESSION['userId'] = $user->getId();

            if (isset($_POST['remember-me'])) {
                setcookie('userId', $user->getId(), time() + 60 * 60, '/');
            }

            header('Location: ./index.php');
            die();
        }
    }

    $errorMessage = 'メアドとパスワード一致する人いなかった';
}

?>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<?php include __DIR__ . '/includes/head.php' ?>


<body>
    <?php include __DIR__ . '/includes/Header.php' ?>
    <section class="section has-background-white-bis">
        <div class="container">
            <div class="card mx-auto" style="max-width:400px;">
                <div class="card-content">
                    <h1 class="title has-text-centered">ログイン</h1>
                    <?php if (!empty($errorMessage)) : ?>
                        <div class="notification is-danger">
                            <?php echo $errorMessage ?>
                        </div>
                    <?php endif ?>
                    <form action="./login.php" method="post">
                        <div class="field">
                            <label class="label">メールアドレス</label>
                            <div class="control">
                                <input class="input" placeholder="ph16@gmail.com" type="email" name="email" value="<?php echo $email ?>">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">パスワード</label>
                            <div class="control">
                                <input class="input" placeholder="パスワードを入力" type="password" name="password">
                            </div>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="remember-me">
                                ログイン状態を保持する
                            </label>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input class="button is-primary is-fullwidth has-text-weight-bold" type="submit" value="ログイン" name="submit-button">
                            </div>
                        </div>
                    </form>
                    <div>
                        <a href="./register.php">
                            <p class="has-text-centered">登録はこちら</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include __DIR__ . '/includes/footer.php' ?>
</body>


</html>
