<?php
require_once 'db.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ищем пользователя по Email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['first_name']; 
            
            echo "<script>window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<div class='container'><p style='color:red'>Неверный пароль</p></div>";
        }
    } else {
        echo "<div class='container'><p style='color:red'>Пользователь с таким Email не найден</p></div>";
    }
}
?>

<div style="max-width: 400px; margin: 0 auto; padding-top: 20px;">
    <h2>Вход в систему</h2>
    <form method="POST">
        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label>Пароль:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px;">
        </div>
        
        <button type="submit" class="btn">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
</div>

<?php require_once 'footer.php'; ?>