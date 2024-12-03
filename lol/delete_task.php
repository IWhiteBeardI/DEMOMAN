<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    
    $sql = "DELETE FROM task WHERE id = ?";
    $stmt = prepareQuery($sql);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        echo "<p>Задача успешно удалена.</p>";
    } else {
        echo "<p>Ошибка при удалении задачи. Попробуйте еще раз.</p>";
    }

    $stmt->close();
}

header("Location: index.php");
exit;
?>