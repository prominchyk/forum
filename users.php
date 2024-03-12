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
<a href="content.php">⬅ Назад</a><br>
<?php
include 'db.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';
//session_start();
if(!empty($_SESSION['auth']) and $_SESSION['status'] === 'admin') {
    $query = "SELECT * FROM users";
    $res = mysqli_query($link, $query);
    if(!$res and MODE === 'dev') {
        die(mysqli_error($link));
    }
    for($data=[]; $row=mysqli_fetch_assoc($res); $data[] = $row);

    echo '<p><b>Список зареєстрованих користувачів:</b></p>';
    echo '<table class="topics">';
    echo '<tr>';
    echo '<th>Логін</th><th>Статус</th><th>Дата реєстрації</th><th>Видалити профіль</th>';
    echo '</tr>';
    foreach($data as $elem) {
        echo '<tr>';
        echo "<td>$elem[login]</td><td>$elem[status]</td><td>$elem[date]</td><td><a href=\"deleteProfile.php?id=$elem[id]\">видалити</a></td>";
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<a href="index.php">Реєстрація/ідентифікація</a> ';
}
?>

</main>
<footer>
    Даний сайт створений для толерантного спілкування людей на теми, які збільшують кількість радості, гармонії, мудрості, освіченості, позитиву. <br>Адміністрація сайту залишає за собою право без попередження видаляти коментарі та теми, які не відповідають даним принципам.
</footer>
</body>