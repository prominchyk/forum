<?php
session_start();
include 'db.php';
require_once 'classes/Topic.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';
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
if(isset($_SESSION['id']) and isset($_SESSION['log'])) {?>
    <a href="content.php">⬅ Назад</a><br><br>
    <p class="register"><?=$_SESSION['log']?></p>
    <form action="saveTopic.php" method="POST">
        <p><b>Назва теми: </b></p> <textarea name="titleTopic" rows="1"></textarea> 
        <p><b>Опис теми: </b></p> <textarea name="textTopic" rows="6"></textarea>
        <input type="submit" value="Відправити">
    </form>
<?php
    if(isset($_SESSION['flash'])) {
        echo "<p class=\"message\"><b>$_SESSION[flash]</b></p>";
    }
} else {
    echo '<a href="index.php">Реєстрація/ідентифікація</a> ';
}

?>



</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>