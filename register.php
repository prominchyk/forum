<?php
session_start();
include 'db.php';
require_once 'classes/User.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';

if(empty($_POST)) {
    include 'registerFormTempl.php';
} else {
    if(User::checkLogin($_POST['login']) and User::checkPassword($_POST['password'])) {
        if($_POST['password'] === $_POST['submit']) {
            $user = new User($_POST['login'], password_hash($_POST['password'], PASSWORD_DEFAULT), 'user', date('Y-m-d'));
            $query = "SELECT * FROM users WHERE login='$user->login'";
            $res = mysqli_query($link, $query);
            if(!$res and MODE === 'dev') {
                die(mysqli_error($link));
            }
            $userFromDB = mysqli_fetch_assoc($res);
            if(empty($userFromDB)) {
                $query = "INSERT INTO users SET login='$user->login', password='$user->password', status='$user->status', date='$user->date'";
                mysqli_query($link, $query);
                $_SESSION['auth'] = true;
                $_SESSION['log'] = $user->login;
                $_SESSION['id'] = mysqli_insert_id($link);
                $_SESSION['status'] = $user->status;
                include 'content.php';
            } else {
                include 'registerFormTempl.php';?>
                <p class="message"><b>Вказаний логін вже зайнятий, виберіть, будь-ласка, інший.</b></p>
            <?php }
        } else {
            include 'registerFormTempl.php';?>
            <p class="message"><b>Невірно введене підтвердження пароля!</b></p>
    <?php }

    } else {
        include 'registerFormTempl.php';
        if(!User::checkLogin($_POST['login'])) {
            echo '<p class="message"><b>Невалідний логін - допустимі лише латинські символи, цифри та знак _ (без пробілів та інших розділових знаків), довжина від 4 до 10 символів.</b></p>';
            } 
        if (!User::checkPassword($_POST['password'])) {
            echo '<p class="message"><b>Невалідний пароль - допустимі лише латинські символи, цифри та знак _ (без пробілів та інших розділових знаків), довжина від 6 до 12 символів.</b></p>';
            }
        }
}

?>