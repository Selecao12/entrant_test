<?php include ROOT . '/views/layouts/header.php'; ?>
    <div>
        <h1>Главная страница</h1>
        <div>
            <div><a href="/admin/">Кабинет администратора</a></div>
            <div><a href="/examiner/">Кабинет сотрудника приемной комиссии</a></div>
            <div><a href="/entrant/">Кабинет абитуриента</a></div>
            <div>
                <a href="<?= $userId ? '/logout/' : '/login/' ?>">
                    <?= $userId ? 'Выйти' : 'Войти' ?>
                </a>
            </div>
        </div>
        <div>
            <pre>
            <?php
            $user = User::getUserById(3);
            var_dump($user);
            ?>
            </pre>
        </div
        <div>
            <?php
            if (User::checkUserGroup('admin')) {
                echo 'Success';
            } else {
                echo 'FUUUUU!';
            }
            ?>
        </div>
    </div>
<?php include ROOT . '/views/layouts/footer.php'; ?>