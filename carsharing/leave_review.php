<?php
require_once 'db.php';
require_once 'header.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['car_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$car_id = intval($_GET['car_id']);

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = intval($_POST['rating']);
    $comment = $_POST['comment'];

    // Простая валидация
    if ($rating < 1 || $rating > 5) {
        echo "Ошибка: оценка должна быть от 1 до 5.";
    } else {
        // Записываем отзыв
        $sql = "INSERT INTO reviews (user_id, car_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $user_id, $car_id, $rating, $comment);
        
        if ($stmt->execute()) {
            echo "<div class='container'><h3 style='color:green'>Спасибо за ваш отзыв!</h3><a href='index.php'>В каталог</a></div>";
            require_once 'footer.php';
            exit();
        } else {
            echo "Ошибка: " . $conn->error;
        }
    }
}

// Получаем название машины, чтобы красиво вывести в заголовке
$res = $conn->query("SELECT brand, model FROM cars WHERE id = $car_id");
$car = $res->fetch_assoc();
?>

<div class="container" style="max-width: 500px; margin-top: 20px;">
    <h2>Отзыв о <?php echo $car['brand'] . ' ' . $car['model']; ?></h2>
    
    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label>Ваша оценка (1-5):</label><br>
            <select name="rating" style="width: 100%; padding: 10px; margin-top: 5px;">
                <option value="5">5 - Отлично</option>
                <option value="4">4 - Хорошо</option>
                <option value="3">3 - Нормально</option>
                <option value="2">2 - Плохо</option>
                <option value="1">1 - Ужасно</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Комментарий:</label><br>
            <textarea name="comment" rows="5" required style="width: 100%; padding: 10px; margin-top: 5px;"></textarea>
        </div>

        <button type="submit" class="btn">Отправить отзыв</button>
    </form>
</div>

<?php require_once 'footer.php'; ?>