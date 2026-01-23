<?php
require_once 'db.php';
session_start();

// Проверка: вошел ли пользователь и передан ли ID аренды
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$rental_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// 1. Получаем данные об активной аренде
$sql = "SELECT * FROM rentals WHERE id = ? AND user_id = ? AND status = 'active'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $rental_id, $user_id);
$stmt->execute();
$rental = $stmt->get_result()->fetch_assoc();

if (!$rental) {
    die("Активная аренда не найдена.");
}

// 2. Расчет времени и стоимости
$start_time = strtotime($rental['start_time']); // Преобразуем строку в timestamp
$end_time = time(); // Текущее время

// Считаем разницу в секундах, переводим в минуты (округляем вверх)
$seconds_diff = $end_time - $start_time;
$minutes = ceil($seconds_diff / 60); 

if ($minutes < 1) $minutes = 1;

$price_per_min = $rental['price_per_minute'];
$total_price = $minutes * $price_per_min;

// 3. Сохраняем результат в базу
$conn->begin_transaction();
try {
    // Обновляем таблицу rentals
    $sql_update = "UPDATE rentals 
                   SET end_time = FROM_UNIXTIME(?), 
                       duration_minutes = ?, 
                       total_price = ?, 
                       status = 'completed' 
                   WHERE id = ?";
    
    $stmt = $conn->prepare($sql_update);
    
    // ИСПРАВЛЕНО ЗДЕСЬ: "iddi" (4 буквы для 4 переменных)
    // i - integer (время), d - double (минуты), d - double (цена), i - integer (id)
    $stmt->bind_param("iddi", $end_time, $minutes, $total_price, $rental_id);
    
    $stmt->execute();

    // Освобождаем машину (статус 1 - Свободна)
    $car_id = $rental['car_id'];
    // Здесь простой запрос, так как id мы получили из базы и он безопасен
    $conn->query("UPDATE cars SET status_id = 1 WHERE id = $car_id");

    $conn->commit();
    
    // Возвращаемся в список поездок
    header("Location: my_rentals.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    echo "Ошибка при завершении аренды: " . $e->getMessage();
}
?>