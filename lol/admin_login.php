<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'help' && $password == 'helpme') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_panel.php');
        exit;
    } else {
        echo '<p style="color: red;">Неверное имя пользователя или пароль.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в панель администратора</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Вход в панель администратора</h1>
    </header>
    <main>
        <div class="form-container">
            <form method="post" action="">
                <label for="username">Логин:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Войти">
            </form>

            <p><a href="login.php">Вернуться</a></p>
        </div>
    </main>
</body>
</html>