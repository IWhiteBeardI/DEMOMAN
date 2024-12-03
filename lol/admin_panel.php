<?php

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

include 'config.php';

$sql = "SELECT t.id AS task_id, u.full_name, d.name AS department, c.name AS category, s.name AS status, t.description 
        FROM task t 
        JOIN user u ON t.id_user = u.id 
        JOIN department d ON u.id_department = d.id 
        JOIN category c ON t.id_category = c.id 
        JOIN status s ON t.id_status = s.id";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Панель администратора</h1>
    </header>
    <main>
        <h2>Все заявки:</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>ФИО пользователя</th>
                <th>Отдел</th>
                <th>Категория проблемы</th>
                <th>Описание</th>
                <th>Статус</th>
                <th>Изменить статус</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['task_id']; ?></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['department']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <form action="update_status.php" method="post">
                        <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                        <select name="new_status">
                            <?php
                            $statuses = array('Новое', 'В процессе', 'Отменено', 'Выполнено');
                            foreach ($statuses as $status) {
                                echo "<option value='" . htmlspecialchars($status) . "'>" . htmlspecialchars($status) . "</option>";
                            }
                            ?>
                        </select>
                        <button type="submit">Обновить</button>
                    </form>
                    <form action="delete_taskA.php" method="post">
        <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
        <input type="submit" value="Удалить заявку" class="btn btn-danger">
    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        
        <p><a href="admin_login.php?logout=true">Выйти из панели администратора</a></p>
    </main>
</body>
</html>

<?php
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: admin_login.php');
}
?>