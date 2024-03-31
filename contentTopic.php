<?php
session_start();
include 'db.php';
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
    $query = "SELECT comments.comment, comments.userImg, users.login as author, comments.date
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
        if(!empty($comm['comment']) and !empty($comm['userImg'])) {
            echo "<tr><td class=\"comm\"><p>$comm[comment]</p><a href=\"$comm[userImg]\" target=\"_blank\"><img class=\"userImg\" src=\"$comm[userImg]\"></a></td><td class=\"commAuthor\">$comm[author]</td><td class=\"commDate\">$comm[date]</td></tr>";
           // echo "<tr><td><a href=\"$comm[userImg]\" target=\"_blank\"><img class=\"userImg\" src=\"$comm[userImg]\"></a></td><td class=\"commAuthor\">$comm[author]</td><td class=\"commDate\">$comm[date]</td></tr>";
        } 
        elseif (!empty($comm['userImg']) and empty($comm['comment'])) {
            echo "<tr><td><a href=\"$comm[userImg]\" target=\"_blank\"><img class=\"userImg\" src=\"$comm[userImg]\"></a></td><td class=\"commAuthor\">$comm[author]</td><td class=\"commDate\">$comm[date]</td></tr>";
        }
        elseif(!empty($comm['comment']) and empty($comm['userImg'])) {
            echo "<tr><td class=\"comm\">$comm[comment]</td><td class=\"commAuthor\">$comm[author]</td><td class=\"commDate\">$comm[date]</td></tr>";
        } 
    }
    ?>
    </table>
    <form action="saveComment.php?id=<?=$topicId?>" method="POST">
    <span>Ваш коментар:</span>
    <input name="userComment">
    <span>Додати картинку (вкажіть її URL-адресу):</span>
    <input name="userImg"><br><br>
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