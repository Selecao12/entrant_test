<?php

/**
 * Контроллер AdminController
 * Главная страница в админпанели
 */
class AdminController extends AdminBase
{
    public function actionIndex()
    {

        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $userGroup = User::getUserGroup($user['user_group']);

        if ($userGroup['name'] !== 'admin') {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        $requests = Test::getRequests();

        require_once(ROOT . '/views/admin/cabinet.php');

        return true;
    }

    public static function actionShowRequest()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $userGroup = User::getUserGroup($user['user_group']);

        if ($userGroup['name'] !== 'admin') {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['request_id'])) {
            $requestId = $_POST['request_id'];
            $request = Test::getRequest($requestId);

            require_once(ROOT . '/views/admin/request.php');
            return true;
        }

        require_once(ROOT . '/views/layouts/failure.php');
        return false;
    }

    public static function actionAcceptRequest()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $userGroup = User::getUserGroup($user['user_group']);

        if ($userGroup['name'] !== 'admin') {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['request_id'])) {
            $requestId = $_POST['request_id'];
            $request = Test::getRequest($requestId);

            if ($request['test_id'] == 0) {
                $testId = Test::saveTest($request['test'], $request['description'], $request['user_id'], $userId);

                if ($testId) {
                    $testHashId = Test::saveTestHash($request['test'], $testId);
                    if ($testHashId) {
                        require_once(ROOT . '/views/admin/success.php');
                        return true;
                    }
                }

                require_once(ROOT . '/views/admin/failure.php');
                return false;
            }

            if ($request['test_id'] != 0) {
                $testId = Test::updateTest($request['test_id'], $request['test'], $request['description'], $request['user_id'], $userId);
                if ($testId) {
                    $testHashId = Test::updateTestHash($request['test_id'], $request['test']);
                    if ($testHashId) {
                        require_once(ROOT . '/views/admin/success.php');
                        return true;
                    }
                }

                require_once(ROOT . '/views/admin/failure.php');
                return false;
            }
        }

        require_once(ROOT . '/views/admin/failure.php');
        return false;
    }
}