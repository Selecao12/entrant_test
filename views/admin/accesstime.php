<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет администратора</h1>
    <h2>Установить время доступа к тестам для студентов</h2>
    <p>Текущее время доступа к тестам: <?= date('H:i d-M-Y', $currentAccessTime); ?></p>
    <p>Текущее время сервера: <?= date('H:i d-M-Y'); ?></p>
    <form action="#" method="post">
        <input type="datetime-local" name="access_time">
        <input type="submit" name="submit">
    </form>
    <p><a href="/admin/">В кабинет администратора</a></p>
<?php include ROOT . '/views/layouts/footer.php'; ?>