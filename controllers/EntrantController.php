<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 23.05.2019
 * Time: 3:03
 */

class EntrantController
{

    // TODO: Проверить работу метода, добавить описание
    public static function actionIndex()
    {
        if (User::checkUserGroup('entrant')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        require_once(ROOT. '/views/entrant/cabinet.php');
        return true;
    }

    // TODO: Проверить работу метода, добавить описание
    public static function actionTest()
    {
        if (User::checkUserGroup('entrant')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (time() > Test::getEntrantsAccessTime()) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['test_id'])) {
            $test = Test::getTest($_POST['test_id']);
            $testQuestions = unserialize($test['test']);

            require_once(ROOT . '/views/entrant/test.php');
            return true;
        }

        require_once(ROOT . '/views/layouts/failure.php');
        return false;
    }
}