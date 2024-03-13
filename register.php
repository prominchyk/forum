<?php
session_start();
include 'db.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';

if(empty($_POST)) {
echo '<a href="index.php">⬅ Назад</a><br><br>
<p class="register">Реєстрація: </p>
<form action="" method="POST">
   <p>Ваш логін: </p> <input name="login">
   <p>Ваш пароль: </p> <input name="password" type="password">
   <p>Підтвердження пароля: </p> <input name="submit" type="password">
    <input type="submit" value="Відправити">
</form>';
} else {
$validLogin = '#^\w{4,10}$#';
$validPassword = '#^\w{6,12}$#';

if(preg_match($validLogin, $_POST['login']) and preg_match($validPassword, $_POST['password'])) {
    if($_POST['password'] === $_POST['submit']) {
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $date = date('Y-m-d');

        $query = "SELECT * FROM users WHERE login='$login'";
        $res = mysqli_query($link, $query);
        if(!$res and MODE === 'dev') {
            die(mysqli_error($link));
        }
        $user = mysqli_fetch_assoc($res);
        if(empty($user)) {
            $query = "INSERT INTO users SET login='$login', password='$password', status='user', date='$date'";
            mysqli_query($link, $query);
            $_SESSION['auth'] = true;
            $_SESSION['log'] = $login;
            $_SESSION['id'] = mysqli_insert_id($link);
            $_SESSION['status'] = 'user';
            //header('Location: content.php');
            include 'content.php';
        } else {?>
            <a href="index.php">⬅ Назад</a><br><br>
            <p class="register">Реєстрація: </p>
            <form action="" method="POST">
            <p>Ваш логін: </p>
            <input name="login" value="<?php if(isset($_POST['login'])) echo ($_POST['login']); ?>">
            <p>Ваш пароль: </p> <input name="password" type="password">
            <p>Підтвердження пароля: </p> <input name="submit" type="password">
            <input type="submit" value="Відправити">
            </form><br>
            <p class="message"><b>Вказаний логін вже зайнятий, виберіть, будь-ласка, інший.</b></p>
       <?php }
    } else {?>
        <a href="index.php">⬅ Назад</a><br><br>
        <p class="register">Реєстрація: </p>
        <form action="" method="POST">
        <p>Ваш логін: </p><input name="login" value="<?php if(isset($_POST['login'])) echo ($_POST['login']); ?>">
        <p>Ваш пароль: </p>
        <input name="password" type="password">
        <p>Підтвердження пароля: </p> <input name="submit" type="password">
        <input type="submit" value="Відправити">
        </form><br>
        <p class="message"><b>Невірно введене підтвердження пароля!</b></p>
   <?php }

} else {?>
    <a href="index.php">⬅ Назад</a><br><br>
    <p class="register">Реєстрація: </p>
    <form action="" method="POST">
    <p>Ваш логін: </p>
    <input name="login" value="<?php if(isset($_POST['login'])) echo ($_POST['login']); ?>">
    <p>Ваш пароль: </p> <input name="password" type="password">
    <p>Підтвердження пароля: </p> <input name="submit" type="password">
    <input type="submit" value="Відправити">
    </form><br>
    <?php
   if(!preg_match($validLogin, $_POST['login'])) {
    echo '<p class="message"><b>Невалідний логін - допустимі лише латинські символи, цифри та знак _ (без пробілів та інших розділових знаків), довжина від 4 до 10 символів.</b></p>';
    } 
   if (!preg_match($validPassword, $_POST['password'])) {
   echo '<p class="message"><b>Невалідний пароль - допустимі лише латинські символи та цифри та знак _ (без пробілів та інших розділових знаків), довжина від 6 до 12 символів)</b></p>';
   }
}
}

?>