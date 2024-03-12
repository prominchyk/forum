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
?>

<?php
if($_SESSION['status'] === 'user') {
    echo "<form action='' method=\"POST\">
    <p>Для видалення профілю <b>$_SESSION[log]</b> введіть пароль: </p> <input name=\"password\" type=\"password\">
     <input type=\"submit\" value=\"Відправити\">
 </form>";
    if(!empty($_POST)) {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id='$id'";
        $res = mysqli_query($link, $query);
        if(!$res and MODE === 'dev') {
            die(mysqli_error($link));
        }
        $user = mysqli_fetch_assoc($res);

        $hash = $user['password'];
        if(password_verify($_POST['password'], $hash)) {
            $query = "DELETE FROM users WHERE id='$id'";
            mysqli_query($link, $query);
            echo '<p class="messageSuccess"><b>Ваш профіль успішно видалений!</b></p> <br><br>';
            $_SESSION['auth'] = null;
            $_SESSION['log'] = null;
            $_SESSION['id'] = null;
            $_SESSION['status'] = null;
            echo '<a href="index.php">Повернутися на сайт</a>';
        } else {
            echo '<p class="message"><b>Невірно введений пароль!</b></p>';
        }
    }
} else if($_SESSION['status'] === 'admin') {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id='$id'";
    mysqli_query($link, $query);
    echo '<p class="messageSuccess"><b>Профіль успішно видалений!</b></p> <br><br>';
    echo '<a href="users.php">Повернутися до списку користувачів</a>';

} else {
    echo '<a href="index.php">Реєстрація/ідентифікація</a> ';
}


?>
</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>