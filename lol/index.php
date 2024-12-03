<?php


include 'config.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
} else {
    // Вывод задач пользователя
    $sql = "SELECT t.id AS task_id, u.full_name, d.name AS department, c.name AS category, s.name AS status, t.description 
            FROM task t 
            JOIN user u ON t.id_user = u.id 
            JOIN department d ON u.id_department = d.id 
            JOIN category c ON t.id_category = c.id 
            JOIN status s ON t.id_status = s.id 
            WHERE u.id = ?";
    $stmt = prepareQuery($sql);
    $stmt->bind_param("i", $_SESSION['id']);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        echo "<p>Ошибка при загрузке задач.</p>";
    }
    $stmt->close();
}

// обработка выхода из аккаунта
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

// Закрытие подключения к базе данных
$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои задачи</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Система управления задачами</h1>
    </header>
    <main>
        <h2>Ваш список задач:</h2>
        <div id="issues-list">
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<div class='issue'>";
        echo "<h3>" . htmlspecialchars($row['category']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Создано: " . htmlspecialchars($row['full_name']) . "</p>";
        echo "<p>Отдел: " . htmlspecialchars($row['department']) . "</p>";
        echo "<p>Статус: " . htmlspecialchars($row['status']) . "</p>";
        
        // Добавляем кнопку удаления
        echo "<form action='delete_task.php' method='post'>";
        echo "<input type='hidden' name='task_id' value='" . $row['task_id'] . "'>";
        echo "<button type='submit'>Удалить задачу</button>";
        echo "</form>";
        
        echo "</div>";
    }
    ?>
</div>
        
        <a href="new_issue.php">Создать новую задачу</a>
        
        <form action="" method="post">
            <button type="submit" name="logout" class="logout-button">Выйти из аккаунта</button>
        </form>
    </main>
</body>
</html>
<?php
// ... (обработка выхода и закрытие соединения)
?>
