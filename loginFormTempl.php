<a href="index.php">⬅ Назад</a><br><br>
<p class='register'>Авторизація: </p>
<form action="" method="POST">
<p>Ваш логін: </p> <input name="login" value="<?php if(isset($_POST['login'])) echo ($_POST['login']); ?>">
<p>Ваш пароль: </p> <input name="password" type="password">
<input type="submit" value="Відправити">
</form>