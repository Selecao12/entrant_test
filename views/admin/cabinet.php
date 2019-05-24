<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет администратора безопасности</h1>
    <table>
        <caption>Заявки</caption>
        <tr>
            <th>user_id</th>
            <th>описание</th>
            <th>время</th>
            <th>принять</th>
            <th>отклонить</th>
        </tr>
        <?php foreach ($requests as $request): ?>
            <tr>
                <td><?php echo $request['user_id']; ?></td>
                <td><?php echo substr($request['description'], 0, 20); ?>...</td>
                <td><?php echo $request['time']; ?></td>
                <td>
                    <form action="/admin/acceptrequest/">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <input type="submit" value="Принять">
                    </form>
                </td>
                <td>
                    <form action="/admin/declinerequest/">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <input type="submit" value="Отклонить">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php include ROOT . '/views/layouts/footer.php'; ?>