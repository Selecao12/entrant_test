<?php

class Test
{

    /**
     * Форматирует загруженный тест в массив
     *
     * @param string $uploadedTest
     * @return false|array
     */
    public static function formatTest($uploadedTest)
    {

        $uploadedTestArray = explode("\n", $uploadedTest);

        $formattedTest = [];

        $questionCount = 0;

        foreach ($uploadedTestArray as $string) {

            if (trim($string) === '') {
                continue;
            }

            // выделить из строки часть, идущую до закрывающей скобки
            $caption = mb_strstr($string, ')', true);

            // если часть до скобки - число, то это вопрос
            if (is_numeric($caption)) {

                $formattedTest[] = [
                    'question' => trim(mb_substr(mb_strstr($string, ')', false), 1)),
                    'true' => [],
                    'false' => []
                ];
                $questionCount++;

                continue;
            }

            // если часть до скобки - не число, то это вариант ответа
            if (!is_numeric($caption)) {

                // если счетчик вопросов на нуле, то возвращаем ошибку
                if ($questionCount == 0) {
                    return false;
                }

                // если в варианте ответа есть плюс, то помещаем в подмассив true
                if (mb_substr($caption, 0, 1) === '+') {
                    $formattedTest[$questionCount - 1]['true'][] = trim(mb_substr(mb_strstr($string, ')', false), 1));
                    continue;
                }

                // если в варианте ответа нет плюса, то помещаем в подмассив false
                if (mb_substr($caption, 0, 1) !== '+') {
                    $formattedTest[$questionCount - 1]['false'][] = trim(mb_substr(mb_strstr($string, ')', false), 1));
                    continue;
                }
            }
        }

        if ($questionCount === 0) {
            return false;
        }

        return $formattedTest;
    }

    /**
     * Сохраняет тест из заявки в таблицу тестов в БД
     *
     * @param $test
     * @param $description
     * @param $userId
     * @param $adminId
     * @return int|string 0 при неудаче или ID последней записи
     */
    public static function saveTest($test, $description, $userId, $adminId)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO test (test, description, time, user_id, admin_id) ' .
            'VALUES (:test, :description, NOW(), :user_id, :admin_id)';

        $result = $db->prepare($sql);
        $result->bindParam(':test', $test, PDO::PARAM_STR);
        $result->bindParam(':description', $description, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':admin_id', $adminId, PDO::PARAM_INT);

        if ($result->execute()) {
            return $db->lastInsertId();
        }

        return 0;
    }

    /**
     * Сохраняет хеш теста
     *
     * @param $test
     * @param $testId
     * @return int|string
     */
    public static function saveTestHash($test, $testId)
    {
        $testHash = sha1($test);

        $db = Db::getConnection();

        $sql = 'INSERT INTO test_hash (hash, test_id) VALUES (:hash, :test_id)';

        $result = $db->prepare($sql);
        $result->bindParam(':hash', $testHash, PDO::PARAM_STR);
        $result->bindParam(':test_id', $testId, PDO::PARAM_INT);

        if ($result->execute()) {
            return $db->lastInsertId();
        }

        return 0;
    }

    /**
     * Возвращает все тесты
     *
     * @return array
     */
    public static function getTests()
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM test';

        $result = $db->query($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает тест по id
     *
     * @param $testId
     * @return mixed
     */
    public static function getTest($testId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM test WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $testId, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Проверяет соответствие теста его хешу
     *
     * @param $testId
     * @return bool
     */
    public static function checkHash($testId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM test WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $testId, PDO::PARAM_INT);

        $result->execute();

        $test = $result->fetch(PDO::FETCH_ASSOC)['test'];

        $sql = 'SELECT * FROM test_hash WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $testId, PDO::PARAM_INT);

        $result->execute();

        $testHash = $result->fetch(PDO::FETCH_ASSOC)['hash'];

        if (sha1($test) == $testHash) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Сортирует вопросы и ответы теста по алфавиту
     * 
     * @param $formattedTest
     * @return mixed
     */
    public static function sortFormattedTest($formattedTest)
    {
        $sortedFormattedTest = $formattedTest;

        usort($sortedFormattedTest, function ($a, $b) {
            return $a['question'] <=> $b['question'];
        });

        foreach ($sortedFormattedTest as &$question) {
            sort($question['true']);
            sort($question['false']);
        }

        return $sortedFormattedTest;
    }

    /**
     * Получает всемя доступа к тесту для группы пользователей абитуриенты
     *
     * @return mixed
     */
    public static function getEntrantsAccessTime()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM user_group WHERE name = 'entrant'";

        $result = $db->query($sql);
        $accessTime = $result->fetch(PDO::FETCH_ASSOC)['access_time'];

        return $accessTime;
    }
    
}