<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет администратора</h1>
    <h2>Добавить пользователя</h2>
    <form action="#" method="post">
        <p>
            <input type="text" name="login" placeholder="Логин">
        </p>
        <p>
            <input type="text" name="password" placeholder="Пароль">
        </p>
        <p>
            <select name="user_group" id="">
                <option disabled>Группа пользователей</option>
                <option value="1">Администратор</option>
                <option value="2">Сотрудник приемной комиссии</option>
                <option value="3">Абитуриент</option>
            </select>
        </p>
        <p>
            <input type="submit">
        </p>
    </form>
    <p><a href="/admin/">В кабинет администратора</a></p>
<?php include ROOT . '/views/layouts/footer.php'; ?>