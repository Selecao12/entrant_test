<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет абитуриента</h1>
    <table>
        <caption>Тесты</caption>
        <tr>
            <th>Описание</th>
            <th>Перейти</th>
        </tr>
        <?php foreach ($tests as $test): ?>
            <tr>
                <td><?= $test['description']; ?></td>
                <td>
                    <form action="/entrant/test/">
                        <input type="hidden" name="test_id" value="<?= $test['id']; ?>">
                        <input type="submit">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php include ROOT . '/views/layouts/footer.php'; ?>