<?php
require_once 'db.php';
require_once 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['car_id'])) {
    die("Машина не выбрана.");
}

$car_id = intval($_GET['car_id']);
$user_id = $_SESSION['user_id'];

$sql_car = "SELECT c.*, cat.name as cat_name, cat.price_per_min 
            FROM cars c 
            LEFT JOIN car_categories cat ON c.category_id = cat.id 
            WHERE c.id = ?";
$stmt = $conn->prepare($sql_car);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();

if (!$car) {
    die("Машина не найдена.");
}

// 2. Обработка нажатия кнопки "Начать поездку"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $price = $car['price_per_min']; // Берем цену из базы

    $conn->begin_transaction();
    try {
        $sql_rent = "INSERT INTO rentals (user_id, car_id, start_time, status, price_per_minute) VALUES (?, ?, NOW(), 'active', ?)";
        $stmt = $conn->prepare($sql_rent);
        // "iid" -> integer, integer, decimal
        $stmt->bind_param("iid", $user_id, $car_id, $price);
        $stmt->execute();

        // Меняем статус машины на "2" (Занята)
        $sql_update = "UPDATE cars SET status_id = 2 WHERE id = ?";
        $stmt2 = $conn->prepare($sql_update);
        $stmt2->bind_param("i", $car_id);
        $stmt2->execute();

        $conn->commit();
        echo "<script>window.location.href='my_rentals.php';</script>";
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "Ошибка: " . $e->getMessage();
    }
}

// Картинка
$img = $car['image'] ? "img/" . $car['image'] : "https://via.placeholder.com/300x200";
?>

<div class="container" style="max-width: 600px; margin-top: 20px;">
    <h2>Подтверждение аренды</h2>
    <div class="car-card">
        <img src="<?php echo $img; ?>" class="car-img">
        <div class="car-info">
            <h3><?php echo $car['brand'] . ' ' . $car['model']; ?></h3>
            <p>Цена: <b style="color: green; font-size: 1.2em;"><?php echo $car['price_per_min']; ?> ₽/мин</b></p>
            <p>Номер: <?php echo $car['license_plate']; ?></p>
            <hr>
            <form method="POST">
                <button type="submit" class="btn" style="background: #28a745;">Начать поездку</button>
                <a href="index.php" class="btn" style="background: #6c757d; margin-top: 10px;">Отмена</a>
            </form>
        </div>
    </div>
</div>

<!-- БЛОК ОТЗЫВОВ (Вставляем в rent.php перед footer) -->
<div class="container" style="max-width: 600px; margin-top: 40px; margin-bottom: 40px;">
    <h3>Отзывы об этом автомобиле</h3>
    
    <?php
    $sql_reviews = "SELECT r.*, u.first_name 
                    FROM reviews r 
                    JOIN users u ON r.user_id = u.id 
                    WHERE r.car_id = ? 
                    ORDER BY r.created_at DESC";
                    
    $stmt = $conn->prepare($sql_reviews);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $reviews_res = $stmt->get_result();

    if ($reviews_res->num_rows > 0):
        while ($rev = $reviews_res->fetch_assoc()):
    ?>
            <div style="background: #fff; padding: 15px; border-bottom: 1px solid #ddd; margin-bottom: 10px; border-radius: 5px;">
                <div style="display: flex; justify-content: space-between;">
                    <strong><?php echo htmlspecialchars($rev['first_name']); ?></strong>
                    <span style="color: #f39c12;">
                        <?php echo str_repeat("★", $rev['rating']); // Рисуем звездочки ?>
                    </span>
                </div>
                <p style="margin: 10px 0; color: #333;"><?php echo htmlspecialchars($rev['comment']); ?></p>
                <small style="color: #999;"><?php echo $rev['created_at']; ?></small>
            </div>
    <?php 
        endwhile;
    else:
    ?>
        <p style="color: #777;">Отзывов пока нет. Будьте первым!</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>