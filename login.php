<?php
session_start();
include 'db.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';

if(empty($_POST['login']) and empty($_POST['password'])) {
    include 'loginFormTempl.php';
} else {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login='$login'";
    $res = mysqli_query($link, $query);
    if(!$res and MODE === 'dev') {
        die(mysqli_error($link));
    }
    $user = mysqli_fetch_assoc($res);

    if(!empty($user)) {
        $hash = $user['password'];
        if(password_verify($password, $hash)) {
            $_SESSION['auth'] = true;
            $_SESSION['log'] = $login;
            $_SESSION['id'] = $user['id'];
            $_SESSION['status'] = $user['status'];
            include 'content.php';
        } else {
            include 'loginFormTempl.php';?>
            <p class="message">Невірно введений логін чи пароль!</p>
            <?php
            $_SESSION['auth'] = null;
            $_SESSION['log'] = null;
            $_SESSION['id'] = null;
            $_SESSION['status'] = null;
        }
    } else {
        include 'loginFormTempl.php';?>
        <p class="message">Невірно введений логін чи пароль!</p>
        <?php
        $_SESSION['auth'] = null;
        $_SESSION['log'] = null;
        $_SESSION['id'] = null;
        $_SESSION['status'] = null;
    }
}


?>