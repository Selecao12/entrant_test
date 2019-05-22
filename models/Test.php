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
     * Сериализует и сохраняет новый тест в БД
     *
     * @param int $userId
     * @param array $formattedTest
     * @param string $description
     * @param int $testId
     *
     * @return int
     */
    public static function saveRequest($userId, $formattedTest, $description, $testId = 0)
    {
        $serializedTest = serialize($formattedTest);

        // Соединение с БД
        $db = Db::getConnection();

        $sql = 'INSERT INTO request (user_id, test, description, time)'
            . 'VALUES (:user_id, :test, :description, NOW())';

        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':test', $serializedTest, PDO::PARAM_STR);
        $result->bindParam(':description', $description, PDO::PARAM_STR);
        $result->bindParam(':test_id', $testId, PDO::PARAM_INT);

        if ($result->execute()) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }

        // Иначе возвращаем 0
        return 0;
    }

    /**
     * Возвращает все заявки от сотрудников приемной комиссии
     *
     * @param int $offset
     * @return array
     */
    public static function getRequests($offset = 0)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM request' . $offset ? " offset $offset" : '';
        $result = $db->query($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает заявку от сотрудника приемной комиссии по id заявки
     *
     * @param $requestId
     * @return mixed
     */
    public static function getRequest($requestId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM request WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $requestId, PDO::PARAM_INT);

        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
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
     * Обновляет запись в таблице тестов
     *
     * @param $testId
     * @param $test
     * @param $description
     * @param $userId
     * @param $adminId
     * @return int|string
     */
    public static function updateTest($testId, $test, $description, $userId, $adminId)
    {
        $db = Db::getConnection();

        $sql = 'UPDATE test SET test = :test, description = :description, user_id = :user_id, admin_id = :admin_id WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':test', $test, PDO::PARAM_STR);
        $result->bindParam(':description', $description, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
        $result->bindParam(':id', $testId, PDO::PARAM_INT);

        if ($result->execute()) {
            return $db->lastInsertId();
        }

        return 0;
    }

    /**
     * Обновляет хеш теста в таблице тестов
     *
     * @param $testId
     * @param $test
     * @return int|string
     */
    public static function updateTestHash($testId, $test)
    {
        $testHash = sha1($test);

        $db = Db::getConnection();

        $sql = 'UPDATE test_hash SET hash = :test_hash WHERE test_id = :test_id';

        $result = $db->prepare($sql);
        $result->bindParam(':test_hash', $testHash, PDO::PARAM_STR);
        $result->bindParam(':test_id', $testId, PDO::PARAM_INT);

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
     * Return formatted test for preview
     *
     * @param string $uploadedTest
     * @return mixed formattedTest
     */
    public static function previewFormattedTest($uploadedTest)
    {
        // отформатировать загруженный тест
        $formattedTest = self::formatTest($uploadedTest);

        // представить
        return $formattedTest;
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
}