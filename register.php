<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">   
</head>
<body>
    <header>
        <span class='headerTitle'>Співзвуччя любові та мудрості</span>
        <span class='headerText'>Форум однодумців - приєднуйтесь до екологічного спілкування, додавайте свої теми</span>
    </header>
<main>
<?php
include 'db.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';
//session_start();

if(empty($_POST)) {
echo '<p class="register">Реєстрація: </p>
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
    echo '<p class="message"><b>Невалідний логін(повинен складатися з лат.символів та цифр, довжина від 4 до 10 символів)</b></p>';
    } 
   if (!preg_match($validPassword, $_POST['password'])) {
   echo '<p class="message"><b>Невалідний пароль(повинен складатися з лат.символів та цифр, довжина від 6 до 12 символів)</b></p>';
   }
}
}

?>

</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>