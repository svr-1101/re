<?php
require_once 'db.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Хешируем пароль
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, email, phone, password_hash, role_id) VALUES (?, ?, ?, ?, ?, 2)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // sssss = 5 строк (first_name, last_name, email, phone, hash)
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $pass_hash);
        
        try {
            if ($stmt->execute()) {
                echo "<div style='color: green; padding: 20px;'>Регистрация успешна! <a href='login.php'>Войти</a></div>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "<div style='color: red; padding: 20px;'>Ошибка: Скорее всего такой Email уже занят.</div>";
        }
    } else {
        echo "Ошибка подготовки запроса: " . $conn->error;
    }
}
?>

<div style="max-width: 400px; margin: 0 auto; padding-bottom: 50px;">
    <h2>Регистрация</h2>
    <form method="POST" action="">
        <div style="margin-bottom: 10px;">
            <label>Имя:</label><br>
            <input type="text" name="first_name" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Фамилия:</label><br>
            <input type="text" name="last_name" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Телефон:</label><br>
            <input type="text" name="phone" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label>Пароль:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px;">
        </div>
        
        <button type="submit" class="btn">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
</div>

<?php require_once 'footer.php'; ?>