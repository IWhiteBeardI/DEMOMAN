<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_insert_id($conn); // Получаем ID новой записи после вставки
    $id_role = 1; // Предполагается, что роль пользователя - 1 (например, обычный пользователь)
    
    $sql = "INSERT INTO user (id, id_role, id_department, password, full_name, phone, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = prepareQuery($sql);
    
    // Передаем значения в подготовленный запрос
    mysqli_stmt_bind_param($stmt, "iisssss", $id, $id_role, $_POST['department'], $_POST['password'], $_POST['name'], $_POST['phone'], $_POST['email']);

    if ($stmt->execute()) {
        echo "<p>Регистрация успешна! Теперь вы можете войти в систему.</p>";
    } else {
        echo "<p>Ошибка при регистрации. Пожалуйста, попробуйте еще раз.</p>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Система управления задачами</h1>
    </header>
    <main>
        <h2>Регистрация</h2>
        <div class="form-container">
            <form method="post" action="">
                <label for="name">ФИО:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="phone">Телефон:</label>
                <input type="tel" id="phone" name="phone">
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                
                <?php
                $result = mysqli_query($conn, "SELECT * FROM department");
                ?>
                
                <label for="department">Отдел:</label>
                <select id="department" name="department">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                    ?>
                </select>
                
                <input type="submit" value="Зарегистрироваться">
            </form>
            
            <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
        </div>
    </main>
</body>
</html>
