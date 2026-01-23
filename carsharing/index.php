<?php
// 1. Подключаем файл настроек базы данных
require_once 'db.php';

// 2. Подключаем "шапку" сайта (меню, логотип, начало HTML)
require_once 'header.php';
?>

<!-- Начало основного контента страницы -->
<div class="hero-section" style="
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 100px 20px;
    text-align: center;
    border-radius: 12px;
    margin-bottom: 40px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
">
    <h1 style="font-size: 3rem; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); color: #fff;">
        Аренда авто в один клик
    </h1>
    <p style="font-size: 1.2rem; opacity: 0.9; margin-top: 10px;">
        Выбирай лучшие автомобили города по доступным ценам
    </p>
</div>

<h2 style="border-left: 5px solid #3498db; padding-left: 15px;">Доступные автомобили</h2>

<div class="cars-grid">
    <?php
    // 3. SQL запрос
    $sql = "SELECT 
                c.*, 
                cat.name AS category_name, 
                s.name AS status_name 
            FROM cars c
            LEFT JOIN car_categories cat ON c.category_id = cat.id
            LEFT JOIN car_statuses s ON c.status_id = s.id
            ORDER BY c.status_id ASC";

    $result = $conn->query($sql);

    // 4. Вывод машин
    if ($result && $result->num_rows > 0):
        while($row = $result->fetch_assoc()):

            // ────────────────────────────────────────────────
            // БЛОК ОБРАБОТКИ КАРТИНОК — ИСПРАВЛЕННЫЙ
            $imagePath = "https://via.placeholder.com/400x240?text=Нет+фото";

            if (!empty($row['image'])) {
                $baseName = $row['image'];

                // Пробуем сначала с .jpg (маленькое)
                $candidate = "img/cars/" . $baseName . ".jpg";
                if (file_exists($candidate)) {
                    $imagePath = $candidate;
                } else {
                    // Пробуем с .JPG (заглавное)
                    $candidate = "img/cars/" . $baseName . ".JPG";
                    if (file_exists($candidate)) {
                        $imagePath = $candidate;
                    }
                }

                // Если всё равно не нашли — отладка
                if ($imagePath === "https://via.placeholder.com/400x240?text=Нет+фото") {
                    $imagePath = "https://via.placeholder.com/400x240?text=Не+найден+" . urlencode($baseName);
                }
            }
            // ────────────────────────────────────────────────

            $isAvailable = ($row['status_id'] == 1);
            $statusClass = $isAvailable ? 'status-available' : 'status-busy';
            $statusText  = $row['status_name'] ?? 'Статус не указан';
    ?>
            <div class="car-card">
                <img src="<?= htmlspecialchars($imagePath) ?>" 
                     alt="<?= htmlspecialchars($row['brand'] . ' ' . $row['model']) ?>" 
                     class="car-img" loading="lazy">


                <div class="car-info">
                    <div class="car-title">
                        <?= htmlspecialchars($row['brand'] . ' ' . $row['model']) ?>
                    </div>
                    
                    <div class="car-meta">
                        <span>Год: <?= htmlspecialchars($row['year'] ?? '—') ?></span>
                        <span>Топливо: <?= htmlspecialchars($row['fuel_type'] ?? '—') ?></span>
                    </div>

                    <div class="car-meta">
                        <span>Категория: <?= htmlspecialchars($row['category_name'] ?? '—') ?></span>
                        <span style="color: grey;"><?= htmlspecialchars($row['color'] ?? '—') ?></span>
                    </div>
                    
                    <div style="margin: 10px 0;">
                        <span class="status-badge <?= $statusClass ?>">
                            <?= htmlspecialchars($statusText) ?>
                        </span>
                        <span style="float: right; font-size: 0.8em; color: #999;">
                            <?= htmlspecialchars($row['license_plate'] ?? '—') ?>
                        </span>
                    </div>

                    <?php if ($isAvailable): ?>
                        <a href="rent.php?car_id=<?= $row['id'] ?>" class="btn">Арендовать</a>
                    <?php else: ?>
                        <button class="btn" style="background: #ccc; cursor: not-allowed;" disabled>Занята</button>
                    <?php endif; ?>
                </div>
            </div>
    <?php 
        endwhile;
    else: 
    ?>
        <p>Автомобили не найдены. Проверьте базу данных.</p>
    <?php endif; ?>
</div>

<?php 
require_once 'footer.php'; 
?>