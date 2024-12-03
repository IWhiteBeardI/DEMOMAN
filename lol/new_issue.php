<?php

include 'config.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO task (id_user, id_category, id_status, description) VALUES (?, ?, ?, ?)";
    $stmt = prepareQuery($sql);
    
    // Передаем значения параметров отдельно
    $user_id = $_SESSION['id'];
    $category_id = (int)$category_id; // Приводим к целому числу
    $status = 1; // Используем статус 'new' по умолчанию
    
    $stmt->bind_param("iiss", $user_id, $category_id, $status, $description);

    if ($stmt->execute()) {
        echo "<p>Задача успешно создана!</p>";
        header("Refresh:1; url=index.php");
    } else {
        echo "<p>Ошибка при создании задачи.</p>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание новой задачи</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Система управления задачами</h1>
    </header>
    <main>
        <h2>Создание новой задачи</h2>
        <div class="form-container">
            <form method="post" action="">
                <?php
                $result = mysqli_query($conn, "SELECT * FROM category");
                ?>
                
                <label for="category">Выберите категорию:</label>
                <select id="category" name="category">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                    ?>
                </select>
                
                <label for="description">Описание проблем:</label>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea>
                
                <input type="submit" value="Создать задачу">
            </form>
        </div>
    </main>
</body>
</html>
