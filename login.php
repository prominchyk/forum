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
<p class='register'>Авторизація: </p>
<?php 
include 'db.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';
session_start(); ?>

<form action="" method="POST">
<p>Ваш логін: </p> <input name="login" value="<?php if(isset($_POST['login'])) echo ($_POST['login']); ?>">
<p>Ваш пароль: </p> <input name="password" type="password">
<input type="submit" value="Відправити">
</form>

<?php
if(!empty($_POST['login']) and !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login='$login'";
    $res = mysqli_query($link, $query);
    if(!$res and MODE === 'dev') {
        die(mysqli_error($link));
    }
    $user = mysqli_fetch_assoc($res);

    if(!empty($user)) {
        //echo "Авторизация прошла успешно!";
        $hash = $user['password'];
        if(password_verify($password, $hash)) {
            $_SESSION['auth'] = true;
            $_SESSION['log'] = $login;
            $_SESSION['id'] = $user['id'];
            $_SESSION['status'] = $user['status'];
            header('Location: content.php');
        } else {?>
            <p class="message">Невірно введений логін чи пароль!</p>
            <?php
            $_SESSION['auth'] = null;
            $_SESSION['log'] = null;
            $_SESSION['id'] = null;
            $_SESSION['status'] = null;
        }
    } else {?>
        <p class="message">Невірно введений логін чи пароль!</p>
        <?php
        $_SESSION['auth'] = null;
        $_SESSION['log'] = null;
        $_SESSION['id'] = null;
        $_SESSION['status'] = null;
    }
}


?>
</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>