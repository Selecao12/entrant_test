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

        if (isset($_POST['request_id']) && isset($_POST['salt'])) {
            $requestId = $_POST['request_id'];
            $request = Request::getRequest($requestId);

            $testId = Test::saveTest($request['test'], $request['description'], $request['user_id'], $userId);

            if ($testId) {
                $salt = $_POST['salt'];
                $testHashId = Test::saveTestHash($request['test'], $testId, $salt);
                if ($testHashId) {

                    Request::deleteRequest($requestId);

                    require_once(ROOT . '/views/layouts/success.php');
                    return true;
                }
            }

            require_once(ROOT . '/views/layouts/failure.php');
            return false;
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

    /**
     * Установить время доступа для студентов
     */
    public static function actionSetAccessTime()
    {

        if (!User::checkUserGroup('admin')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['submit'])) {
            $accessTime = strtotime($_POST['access_time']);
            if (User::setAccessTime($accessTime)) {
                require_once(ROOT . '/views/layouts/success.php');
                return true;
            } else {
                require_once(ROOT . '/views/layouts/failure.php');
                return false;
            }
        }

        $currentAccessTime = Test::getEntrantsAccessTime();
        require_once(ROOT . '/views/admin/accesstime.php');
        return true;
    }

    /**
     * Показать тесты и проверить хеш
     *
     * @return bool
     */
    public static function actionTests()
    {
        if (!User::checkUserGroup('admin')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        $tests = Test::getTests();

        require_once(ROOT . '/views/admin/tests.php');
        return true;
    }

    public static function actionCheckHash()
    {
        if (isset($_POST['test_id']) && isset($_POST['salt'])) {
            $testId = $_POST['test_id'];
            $salt = $_POST['salt'];
            $result = Test::checkHash($testId, $salt);

            if ($result) {
                echo 'OK';
            } else {
                echo 'FAIL';
            }
        }
    }

}