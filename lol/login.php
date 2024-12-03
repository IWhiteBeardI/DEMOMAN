<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM user WHERE email = ? AND password = ?";
    $stmt = prepareQuery($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            session_start();
            $_SESSION['username'] = $row['full_name'];
            $_SESSION['id'] = $row['id'];
            header('Location: index.php');
        } else {
            echo "<p>Неправильный email или пароль.</p>";
        }
    } else {
        echo "<p>Ошибка при проверке данных.</p>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Система управления задачами</h1>
    </header>
    <main>
        <h2>Авторизация</h2>
        <div class="form-container">
            <form method="post" action="">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Войти">
            </form>
            
            <p>Еще нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
            <p>Вы администратор? <a href="admin_login.php">Войти</a></p>
        </div>
    </main>
</body>
</html>
