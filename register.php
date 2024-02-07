<?php

require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/UserData.php';

session_start();

if (isset($_POST['submit-button'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $user->setName($name);
    $user->setEmail($email);
    $user->setPassword($password);

    $userData = new UserData();
    $userData->save($user);
    $_SESSION['userId'] = $user->getId();
    header('Location: ./index.php');
    die();
}

?>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<?php include __DIR__ . '/includes/head.php' ?>

<body>
    <?php include __DIR__ . '/includes/Header.php' ?>
    <section class="section has-background-white-bis">
        <div class="container">
            <div class="card mx-auto" style="max-width: 400px;">
                <div class="card-content">
                    <h1 class="title has-text-centered">会員登録</h1>
                    <form action="./register.php" method="post">
                        <div class="field">
                            <label class="label">名前</label>
                            <div class="control">
                                <input class="input" type="text" name="name" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">メールアドレス</label>
                            <div class="control">
                                <input class="input" type="email" name="email" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">パスワード</label>
                            <div class="control">
                                <input class="input" type="password" name="password" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input class="button is-primary is-fullwidth has-text-weight-bold" type="submit" value="登録" name="submit-button">
                            </div>
                        </div>
                    </form>
                    <div class="has-text-centered">
                        <a href="./login.php">ログインはこちら</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include __DIR__ . '/includes/footer.php' ?>
</body>

</html>
