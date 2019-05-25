<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет администратора безопасности</h1>
    <table>
        <caption>Заявка</caption>
        <tr>
            <th>user_id</th>
            <th>описание</th>
            <th>время</th>
            <th>принять</th>
            <th>отклонить</th>
        </tr>
        <tr>
            <td><?= $request['user_id']; ?></td>
            <td><?= $request['description']; ?></td>
            <td><?= $request['time']; ?></td>
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
    </table>

    <p><a href="/admin/">В кабинет администратора</a></p>
<?php include ROOT . '/views/layouts/footer.php'; ?>