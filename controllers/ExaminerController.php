<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 21.05.2019
 * Time: 22:15
 */

class ExaminerController
{
    public function actionIndex() {

        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $userGroup = User::getUserGroup($user['user_group']);

        if ($userGroup['name'] !== 'examiner') {
            require_once(ROOT . '/views/layouts/access_denied.php');
            return false;
        }

        require_once(ROOT. '/views/examiner/cabinet.php');

        return true;
    }

    public function actionSendRequest() {

        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $userGroup = User::getUserGroup($user['user_group']);

        if ($userGroup['name'] !== 'examiner') {
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
                require_once(ROOT . '/views/examiner/failure.php');
                return false;
            }

            // Сортировать вопросы и ответы в тесте по алфавиту
            $sortedTest = Test::sortFormattedTest($formattedTest);

            // Сохранить тест в заявках
            if (Test::saveRequest($userId, $sortedTest, $description, $testId)) {
                require_once(ROOT . '/views/examiner/success.php');
                return true;
            } else {
                require_once(ROOT . '/views/examiner/failure.php');
                return false;
            }
        }

        require_once(ROOT . '/views/examiner/failure.php');
        return false;
    }
}