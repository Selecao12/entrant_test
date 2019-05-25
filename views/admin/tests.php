<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет администратора</h1>
    <table>
        <caption>Соответствие тестов их хешу</caption>
        <tr>
            <th>test_id</th>
            <th>Описание</th>
            <th>Соответствие хеша</th>
        </tr>
        <?php foreach ($tests as $test): ?>
            <tr>
                <td><?= $test['id']; ?></td>
                <td><?= $test['description']; ?></td>
                <td><?= $test['valid'] ? 'OK' : 'FALSE'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="/">На главную</a></p>
<?php include ROOT . '/views/layouts/footer.php'; ?>