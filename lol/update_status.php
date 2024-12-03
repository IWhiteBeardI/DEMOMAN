<?php

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['new_status'];

    try {
        // Получаем ID статуса из базы данных
        $sql = "SELECT id FROM status WHERE name = '$new_status'";
        $result = mysqli_query($conn, $sql);

        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<p>Ошибка: Статус '$new_status' не найден в базе данных.</p>";
            exit;
        }

        $status_row = mysqli_fetch_assoc($result);
        $status_id = $status_row['id'];

        // Обновляем статус задачи
        $sql = "UPDATE task SET id_status = '$status_id' WHERE id = '$task_id'";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Ошибка при выполнении запроса обновления: " . mysqli_error($conn));
        }

        echo "<p>Статус заявки успешно обновлен.</p>";
    } catch (Exception $e) {
        echo "<p>Произошла ошибка: " . $e->getMessage() . "</p>";
    }
}

header("Refresh:2; url=admin_panel.php");
exit;