<?php
session_start();
session_destroy(); // Удаляем сессию
header("Location: index.php"); // Возвращаем на главную
?>