<?php include ROOT . '/views/layouts/header.php'; ?>
<div>
    <h1>Кабинет сотрудника приемной комиссии</h1>
    <div>Отправить заявку</div>
    <form action="/examiner/sendrequest/" method="post">
        <p>Тест</p>
        <textarea name="test" id="" cols="50" rows="30"></textarea>
        <p>Описание</p>
        <textarea name="description" id="" cols="50" rows="10"></textarea>
        <input type="submit">
    </form>
    <p><a href="/">На главную</a></p>
</div>
<?php include ROOT . '/views/layouts/footer.php'; ?>