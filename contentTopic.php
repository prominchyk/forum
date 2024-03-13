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
if(isset($_SESSION['id']) and isset($_SESSION['log']) and isset($_GET['id'])) {?>
    <a href="content.php">⬅ Назад</a><br><br>
    <p class="register"><?=$_SESSION['log']?></p>
<?php
    $topicId = $_GET['id'];
    $query = "SELECT * FROM forum_topics WHERE id=$topicId";
    $res = mysqli_query($link, $query);
    if(!$res and MODE === 'dev') {
        die(mysqli_error($link));
    }
    $row = mysqli_fetch_assoc($res);
    ?>
    <h2><?=$row['title']?></h2>
    <p><?=$row['text']?></p>

    <table class="topics">
    <tr>
    <th>Коментар</th><th>Автор</th><th>Дата створення</th>
    </tr>
    <?php
    $query = "SELECT comments.comment, users.login as author, comments.date
             FROM comments
             LEFT JOIN users ON users.id = comments.user_id
             WHERE topic_id = '$topicId' ORDER BY comments.date";
    $res = mysqli_query($link, $query);
    if(!$res and MODE === 'dev') {
        die(mysqli_error($link));
    }
    for($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);
    foreach($data as $comm) {
        if(!isset($comm['author'])) {
            $comm['author'] = '<i>deleted user</i>';
        }
        echo "<tr><td class=\"comm\">$comm[comment]</td><td class=\"commAuthor\">$comm[author]</td><td class=\"commDate\">$comm[date]</td></tr>";
    }
    ?>
    </table>
    <form action="saveComment.php?id=<?=$topicId?>" method="POST">
    <span>Ваш коментар:</span>
    <input name="userComment">
    <button type="submit">Відправити</button>
    </form>
<?php
} else {
    echo '<a href="index.php">Реєстрація/ідентифікація</a> ';
}
?>

</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>