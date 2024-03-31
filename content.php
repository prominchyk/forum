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
if(isset($_SESSION['log'])) {
    if($_SESSION['status'] === 'user') {?>
    <div class="profile">
        <p class="register"><?=$_SESSION['log']?></p>
        <a href="logout.php">Вийти з профілю</a>   
        <a href="changePassword.php">Зміна пароля</a>      
        <a href="deleteProfile.php">Видалити профіль</a>
    </div>
    <?php
    } else if($_SESSION['status'] === 'admin') {?>
    <div class="profile">
        <p class="register"><?=$_SESSION['log']?></p>
        <a href="logout.php">Вийти з профілю</a>   
        <a href="changePassword.php">Зміна пароля</a>      
        <a href="users.php">Користувачі</a>
    </div>

    <?php
    }?>

    <a class="addTopic" href="addTopic.php">Додати тему</a>

    <table class="topics">
        <tr>
            <th>Тема</th><th>Опис</th><th>Кількість коментарів</th><th>Автор</th><th>Дата створення</th>
        </tr>
        <?php
        $query = "SELECT forum_topics.id, forum_topics.title, forum_topics.text, users.login as author, forum_topics.date
                FROM forum_topics
                LEFT JOIN users ON users.id = forum_topics.user_id ORDER BY forum_topics.date";
        $res = mysqli_query($link, $query);
        if(!$res and MODE === 'dev') {
            die(mysqli_error($link));
        }
        for($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);
        foreach($data as $topic) {
            if(!isset($topic['author'])) {
                $topic['author'] = '<i>deleted user</i>';
            }
            $query2 = "SELECT COUNT(*) FROM comments WHERE topic_id=$topic[id]";
            $res2 = mysqli_query($link, $query2);
            $data2 = mysqli_fetch_assoc($res2)["COUNT(*)"];
            for($i = 0; $i < count($data); $i++) { 
                if ((int)$data2 > 0) {
                    echo "<tr><td class=\"tableTitle\"><a href=\"contentTopic.php?id=$topic[id]\">$topic[title]</a></td><td class=\"tableText\">$topic[text]</td><td class=\"tableCountComments\">$data2</td><td class=\"tableAuthor\">$topic[author]</td><td class=\"tableDate\">$topic[date]</td></tr>";
                    break;
                } else {
                    echo "<tr><td class=\"tableTitle\"><a href=\"contentTopic.php?id=$topic[id]\">$topic[title]</a></td><td class=\"tableText\">$topic[text]</td><td class=\"tableCountComments\">0</td><td class=\"tableAuthor\">$topic[author]</td><td class=\"tableDate\">$topic[date]</td></tr>";
                    break;
                }
            }  
        }
        ?>
    </table>

 <?php
 } else {
    echo '<a href="index.php">Реєстрація/ідентифікація</a>';  
}
?>
</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>