<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет администратора</h1>
    <table>
        <caption>Соответствие тестов их хешу</caption>
        <tr>
            <th>test_id</th>
            <th>Описание</th>
            <th>Проверить хеш</th>
            <th>Результат</th>
        </tr>
        <?php foreach ($tests as $test): ?>
            <tr>
                <td class="test_id"><?= $test['id']; ?></td>
                <td><?= $test['description']; ?></td>
                <td>
                    <input type="hidden" class="test_id" value="<?= $test['id']; ?>">
                    Соль:
                    <input type="text" class="salt">
                    <button class="check">
                        Проверить хеш
                    </button>
                </td>
                <td class="result"><i class="fa fa-question"></i></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="/">На главную</a></p>
    <script>
        $('.check').click(function () {

            test = $(this);
            testId = $(this).siblings('.test_id')[0].value;
            salt = $(this).siblings('.salt')[0].value;

            $.post(
                "/admin/checkhash",
                {
                    test_id: testId,
                    salt: salt
                },
                onCheck
            );
        });

        function onCheck(data) {
            if (data === 'OK') {
                // console.log(test.parent().siblings('.result').html());
                test.parent().siblings('.result').html('<i style="color: green" class="fa fa-plus"></i>');
            } else {
                test.parent().siblings('.result').html('<i style="color: red" class="fa fa-minus"></i>');
            }
        }
    </script>
<?php include ROOT . '/views/layouts/footer.php'; ?>