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
<a href="content.php">⬅ Назад</a><br><br>
<p class='register'>Зміна пароля: </p>
<?php
include 'db.php';
echo '<link href="styles.css" rel="stylesheet" type="text/css">';
//session_start();
?>

<form action="" method="POST">
   <p>Старий пароль: </p> <input name="old_password" type="password">
   <p>Новий пароль: </p> <input name="new_password" type="password">
   <p>Підтвердження нового пароля: </p> <input name="new_password_confirm" type="password">
   <input type="submit" value="Відправити"> 
</form>

<?php
if($_SESSION['auth']) {
    if(!empty($_POST['old_password']) and !empty($_POST['new_password']) and !empty($_POST['new_password_confirm'])) {
        $newPassword = $_POST['new_password'];
        $newPasswordConfirm = $_POST['new_password_confirm'];
        $validPassword = '#^\w{6,12}$#';

        if(preg_match($validPassword, $newPassword)) {
            if($newPassword === $newPasswordConfirm) {
                $id = $_SESSION['id'];
                $query = "SELECT * FROM users WHERE id='$id'";

                $res = mysqli_query($link, $query);
                if(!$res and MODE === 'dev') {
                    die(mysqli_error($link));
                }
                $user = mysqli_fetch_assoc($res);

                $hash = $user['password'];
                $oldPassword = $_POST['old_password'];

                if(password_verify($oldPassword, $hash)) {
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password='$newPasswordHash' WHERE id='$id'";
                    mysqli_query($link, $query);
                    echo '<p class="messageSuccess"><b>Пароль успішно змінений!</b></p> <br><br>';
                   // echo '<a href="content.php">Повернутися на сайт</a>';
                } else {
                    echo '<p class="message"><b>Невірно введений старий пароль!</b></p>';
                }
            } else {
                echo '<p class="message"><b>Невірно введене підтвердження нового пароля!</b></p>';
            }
        } else {
            echo '<p class="message"><b>Невалідний пароль(повинен складатися з лат.символів та цифр, довжина від 6 до 12 символів)</b></p>';
        }
    } else {
        echo '<p class="message"><b>Не всі поля заповнені!</b></p>';
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

