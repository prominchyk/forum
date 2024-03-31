<?php
session_start();
echo '<link href="styles.css" rel="stylesheet" type="text/css">';
error_reporting(E_ALL);
ini_set('display-errors', 'on');
mb_internal_encoding('UTF-8');

if(isset($_SESSION['id'])) {
    header("Location: content.php");
} else {?>
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
        <div class='greeting'>
            <a href="register.php">Зареєструватися</a><br><br>
            <a href="login.php">Авторизуватися</a>
        </div>
    </main>
    <footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
    </footer>
</body>
<?php
}
?>
