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
session_start();
if(isset($_SESSION['id']) and isset($_SESSION['log'])) {?>
    <a href="content.php">⬅ Назад</a><br><br>
    <p class="register"><?=$_SESSION['log']?></p>
    <form action="" method="POST">
        <p><b>Назва теми: </b></p> <textarea name="titleTopic" rows="1"></textarea> 
        <p><b>Опис теми: </b></p> <textarea name="textTopic" rows="6"></textarea>
        <input type="submit" value="Відправити">
    </form>
<?php
    if(!empty($_POST['titleTopic']) and !empty($_POST['textTopic'])) {
        $id = $_SESSION['id'];
        $titleTopic = $_POST['titleTopic'];
        $textTopic = $_POST['textTopic'];
        $date = date('Y-m-d');
    
        $query = "INSERT INTO forum_topics SET title='$titleTopic', text='$textTopic', user_id='$id', date='$date'";
        $res = mysqli_query($link, $query);
        if(!$res and MODE === 'dev') {
            die(mysqli_error($link));
        }
        header('Location: content.php');
        } else {
            echo '<p><b>Для створення теми заповніть поля вище.</b></p>';
        }
} else {
    header('Location: index.php');
}

?>



</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>