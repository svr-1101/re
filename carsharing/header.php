<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каршеринг</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.php">Главная</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- ЭТОТ БЛОК ВИДЯТ ТОЛЬКО ТЕ, КТО ВОШЕЛ -->
                    
                    <!-- Новая ссылка на поездки -->
                    <a href="my_rentals.php" style="margin-left: 15px;">Мои поездки</a>

                    <span style="color: #ccc; margin-left: 20px;">
                        Привет, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                    <a href="logout.php" style="float: right; color: #ff6b6b;">Выйти</a>
                    
                <?php else: ?>
                    <!-- ЭТОТ БЛОК ВИДЯТ ГОСТИ -->
                    <div style="float: right;">
                        <a href="login.php">Войти</a>
                        <a href="register.php">Регистрация</a>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <div class="container">