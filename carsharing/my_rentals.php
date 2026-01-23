<?php
require_once 'db.php';
require_once 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT r.*, c.brand, c.model, c.license_plate, p.id as payment_id, p.payment_date
        FROM rentals r
        JOIN cars c ON r.car_id = c.id
        LEFT JOIN payments p ON r.id = p.rental_id
        WHERE r.user_id = ?
        ORDER BY r.start_time DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <h2>Мои поездки</h2>
    <?php if ($result->num_rows > 0): ?>
        <table style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #eee; text-align: left;">
                    <th style="padding: 10px;">Авто</th>
                    <th style="padding: 10px;">Дата</th>
                    <th style="padding: 10px;">Итого</th>
                    <th style="padding: 10px;">Статус</th>
                    <th style="padding: 10px;">Действие</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">
                        <b><?php echo $row['brand'] . ' ' . $row['model']; ?></b><br>
                        <small style="color: #888;"><?php echo $row['license_plate']; ?></small>
                    </td>
                    <td style="padding: 10px;">
                        <?php echo date('d.m.Y H:i', strtotime($row['start_time'])); ?>
                    </td>
                    <td style="padding: 10px;">
                        <?php echo $row['total_price'] ? "<b>{$row['total_price']} ₽</b>" : '-'; ?>
                    </td>
                    <td style="padding: 10px;">
                        <?php 
                        if ($row['status'] == 'active') {
                            echo '<span style="color: green;">В пути...</span>';
                        } elseif ($row['payment_id']) {
                            echo '<span style="color: blue;">✔ Оплачено</span>';
                        } else {
                            echo '<span style="color: red;">Ожидает оплаты</span>';
                        }
                        ?>
                    </td>
                    <td style="padding: 10px;">
                        <?php if ($row['status'] == 'active'): ?>
                            <!-- Если поездка идет -> Кнопка Завершить -->
                            <a href="finish_rent.php?id=<?php echo $row['id']; ?>" class="btn" style="background: #dc3545; padding: 5px 10px; width: auto; display:inline-block;">Завершить</a>
                        
                        <?php elseif (!$row['payment_id']): ?>
                            <!-- Если поездка завершена, но НЕ оплачена -> Кнопка Оплатить -->
                            <a href="pay.php?rental_id=<?php echo $row['id']; ?>" class="btn" style="background: #ffc107; color: #000; padding: 5px 10px; width: auto; display:inline-block;">Оплатить</a>
                        
                        <?php else: ?>
                            <!-- Если оплачено -> Показываем ссылку на отзыв -->
                            <span style="color: grey; font-size: 0.9em;">Оплачено</span>
                            <br>
                            <a href="leave_review.php?car_id=<?php echo $row['car_id']; ?>" style="font-size: 0.85em; color: blue; text-decoration: underline;">Оставить отзыв</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Поездок пока нет.</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>