<?php

/**
 * Контроллер AdminController
 * Главная страница в админпанели
 */
class AdminController extends AdminBase
{
    /**
     * Кабинет администратора, в котором отображаются заявки от сотрудника приемной комиссии
     *
     * @return bool
     */
    public function actionIndex()
    {

        if (!User::checkUserGroup('admin')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        $requests = Request::getRequests();

        require_once(ROOT . '/views/admin/cabinet.php');

        return true;
    }

    /**
     * Показывает одну заявку
     * 
     * @return bool
     */
    public static function actionShowRequest()
    {
        if (!User::checkUserGroup('admin')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['request_id'])) {
            $requestId = $_POST['request_id'];
            $request = Request::getRequest($requestId);

            require_once(ROOT . '/views/admin/request.php');
            return true;
        }

        require_once(ROOT . '/views/layouts/failure.php');
        return false;
    }

    /**
     * Одобрить заявку
     * 
     * @return bool
     */
    public static function actionAcceptRequest()
    {
        $userId = User::checkLogged();
        if (!User::checkUserGroup('admin')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['request_id'])) {
            $requestId = $_POST['request_id'];
            $request = Request::getRequest($requestId);

            if ($request['test_id'] == 0) {
                $testId = Test::saveTest($request['test'], $request['description'], $request['user_id'], $userId);

                if ($testId) {
                    $testHashId = Test::saveTestHash($request['test'], $testId);
                    if ($testHashId) {
                        require_once(ROOT . '/views/layouts/success.php');
                        return true;
                    }
                }

                require_once(ROOT . '/views/layouts/failure.php');
                return false;
            }

            if ($request['test_id'] != 0) {
                $testId = Test::updateTest($request['test_id'], $request['test'], $request['description'], $request['user_id'], $userId);
                if ($testId) {
                    $testHashId = Test::updateTestHash($request['test_id'], $request['test']);
                    if ($testHashId) {
                        require_once(ROOT . '/views/layouts/success.php');
                        return true;
                    }
                }

                require_once(ROOT . '/views/layouts/failure.php');
                return false;
            }
        }

        require_once(ROOT . '/views/layouts/failure.php');
        return false;
    }

    /**
     * Отклонить заявку
     *
     * @return bool
     */
    public static function actionDeclineRequest()
    {

        if (!User::checkUserGroup('admin')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['request_id'])) {
            $requestId = $_POST['request_id'];

            if (Request::deleteRequest($requestId)) {
                require_once(ROOT . '/views/layouts/success.php');
                return true;
            }
        }

        require_once(ROOT . '/views/layouts/failure.php');
        return true;

    }

    /**
     * Добавить нового пользователя
     *
     * @return bool
     */
    public static function actionAddUser()
    {

        if (!User::checkUserGroup('admin')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['user_group'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $userGroup = $_POST['user_group'];

            if (User::addUser($login, $password, $userGroup)) {
                require_once(ROOT . '/views/layouts/success.php');
                return true;
            } else {
                require_once(ROOT . '/views/layouts/failure.php');
                return false;
            }
        }

        require_once(ROOT . '/views/admin/adduser.php');
        return true;
    }

    // TODO: Написать метод
    /**
     * Установить время доступа для студентов
     */
    public static function actionSetAccessTime()
    {

    }

}