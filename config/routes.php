<?php

return array(

    // Кабинет администратора
    'admin' => 'admin/index',
    'admin/request' => 'admin/showrequest',
    'admin/acceptrequest' => 'admin/acceptrequest',
    'admin/declinerequest' => 'admin/declinerequest',
    'admin/adduser' => 'admin/adduser',

    // Кабинет сотрудника приемной комиссии
    'examiner/sendrequest' => 'examiner/sendrequest',
    'examiner' => 'examiner/index',

    // Кабинет студента
    'entrant/test' => 'entrant/test',
    'entrant' => 'entrant/index',

    // Авторизация
    'login' => 'user/login',
    'logout' => 'user/logout',

    // Главная страница
    'index.php' => 'site/index', // actionIndex в SiteController
    '' => 'site/index', // actionIndex в SiteController
);
