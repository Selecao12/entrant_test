<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет администратора безопасности</h1>
    <div>
        <p><a href="/admin/adduser/">Добавить пользователя</a></p>
    </div>
    <div>
        <p><a href="/admin/accesstime/">Установить время доступа для абитуриентов</a></p>
    </div>
    <div>
        <p><a href="/admin/tests/">Посмотреть существующие тесты</a></p>
    </div>
    <table>
        <caption>Заявки</caption>
        <tr>
            <th>user_id</th>
            <th>описание</th>
            <th>время</th>
            <th>принять</th>
            <th>отклонить</th>
            <th>подробнее</th>
        </tr>
        <?php foreach ($requests as $request): ?>
            <tr>
                <td><?php echo $request['user_id']; ?></td>
                <td><?php echo substr($request['description'], 0, 20); ?>...</td>
                <td><?php echo $request['time']; ?></td>
                <td>
                    <form action="/admin/acceptrequest/" method="post">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <input type="submit" value="Принять">
                    </form>
                </td>
                <td>
                    <form action="/admin/declinerequest/" method="post">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <input type="submit" value="Отклонить">
                    </form>
                </td>
                <td>
                    <form action="/admin/request/" method="post">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <input type="submit" value="Открыть">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="/">На главную</a></p>
<?php include ROOT . '/views/layouts/footer.php'; ?>