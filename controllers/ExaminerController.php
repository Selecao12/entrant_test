<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 21.05.2019
 * Time: 22:15
 */

class ExaminerController
{
    // TODO: Проверить работу метода, добавить описание
    public function actionIndex() {

        if (!User::checkUserGroup('examiner')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        require_once(ROOT. '/views/examiner/cabinet.php');
        return true;
    }

    // TODO: Проверить работу метода, добавить описание
    public function actionSendRequest() {

        $userId = User::checkLogged();
        if (!User::checkUserGroup('examiner')) {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        if (isset($_POST['test'])) {

            $uploadedTest = $_POST['test'];
            $description = $_POST['description'];
            $testId = isset($_POST['test_id']) ? $_POST['test_id'] : 0;

            // Форматировать тест в массив
            $formattedTest = Test::formatTest($uploadedTest);

            if ($formattedTest === false) {
                require_once(ROOT . '/views/layouts/failure.php');
                return false;
            }

            // Сортировать вопросы и ответы в тесте по алфавиту
            $sortedTest = Test::sortFormattedTest($formattedTest);

            // Сохранить тест в заявках
            if (Request::saveRequest($userId, $sortedTest, $description, $testId)) {
                require_once(ROOT . '/views/layouts/success.php');
                return true;
            } else {
                require_once(ROOT . '/views/layouts/failure.php');
                return false;
            }
        }

        require_once(ROOT . '/views/layouts/failure.php');
        return false;
    }
}