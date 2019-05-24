<?php

class UserController {

    // TODO: Проверить работу метода, добавить описание
    public function actionLogin() {

        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            
            $errors = FALSE;

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($login, $password);
            
            if ($userId == FALSE) {
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);
                
                // Перенаправляем пользователя на главную страницу
                header("Location: /");
            }
        }
        
        require_once (ROOT . '/views/user/login.php');
        
        return true;
    }
    
    public function actionLogout() {
        unset($_SESSION['user']);
        header("Location: /");
    }
}
