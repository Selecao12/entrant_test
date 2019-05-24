<?php include ROOT . '/views/layouts/header.php'; ?>
    <div>
        <h1>Главная страница</h1>
        <div>
            <div><a href="/admin/">Кабинет администратора</a></div>
            <div><a href="/examiner/">Кабинет сотрудника приемной комиссии</a></div>
            <div><a href="/entrant/">Кабинет абитуриента</a></div>
            <div>
                <a href="<?= $userId ? '/user/logout/' : '/user/login/'?>">
                    <?= $userId ? 'Выйти' : 'Войти' ?>
                </a>
            </div>
        </div>
    </div>
<?php include ROOT . '/views/layouts/footer.php'; ?>