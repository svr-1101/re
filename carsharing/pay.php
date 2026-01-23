<?php
require_once 'db.php';
require_once 'header.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['rental_id'])) {
    header("Location: index.php");
    exit();
}

$rental_id = intval($_GET['rental_id']);
$user_id = $_SESSION['user_id'];

// 1. Ищем неоплаченную завершенную поездку
$sql = "SELECT * FROM rentals WHERE id = ? AND user_id = ? AND status = 'completed'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $rental_id, $user_id);
$stmt->execute();
$rental = $stmt->get_result()->fetch_assoc();

if (!$rental) {
    die("<div class='container'><p>Поездка не найдена или уже оплачена.</p></div>");
}

// 2. Обработка оплаты
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // В реальной жизни тут был бы запрос к банку API
    
    $amount = $rental['total_price'];
    
    // Вставляем запись в таблицу payments
    $sql_pay = "INSERT INTO payments (rental_id, amount, payment_date, status) VALUES (?, ?, NOW(), 'completed')";
    $stmt = $conn->prepare($sql_pay);
    $stmt->bind_param("id", $rental_id, $amount);
    
    if ($stmt->execute()) {
        // ИСПРАВЛЕННАЯ ЧАСТЬ НИЖЕ (кавычки)
        echo "<div class='container' style='padding: 20px; text-align: center;'>
                <h2 style='color: green;'>Оплата прошла успешно!</h2>
                <p>Спасибо, что пользуетесь нашим сервисом.</p>
                <a href='my_rentals.php' class='btn' style='max-width: 200px; margin: 20px auto;'>Вернуться к поездкам</a>
              </div>";
        require_once 'footer.php';
        exit();
    } else {
        echo "Ошибка: " . $conn->error;
    }
}
?>

<div class="container" style="max-width: 500px; margin-top: 30px;">
    <h2>Оплата поездки #<?php echo $rental['id']; ?></h2>
    
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <p style="font-size: 1.2em;">К оплате: <b style="font-size: 1.5em;"><?php echo $rental['total_price']; ?> ₽</b></p>
        
        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label>Номер карты</label><br>
                <input type="text" placeholder="0000 0000 0000 0000" required 
                       style="width: 100%; padding: 10px; font-size: 1.1em; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label>Срок (ММ/ГГ)</label><br>
                    <input type="text" placeholder="12/25" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <div style="flex: 1;">
                    <label>CVC</label><br>
                    <input type="text" placeholder="123" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
            </div>
            
            <button type="submit" class="btn" style="background: #28a745; font-size: 1.2em;">Оплатить</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?> 