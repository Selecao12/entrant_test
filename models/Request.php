<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 24.05.2019
 * Time: 18:56
 */

class Request
{

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

        $sql = 'INSERT INTO request (user_id, test, description, test_id, time)'
            . 'VALUES (:user_id, :test, :description, :test_id, NOW())';

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

        $sql = 'SELECT * FROM request';
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
     * Удаляет заявку по id
     *
     * @param $requestId
     * @return bool
     */
    public static function deleteRequest($requestId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM request WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $requestId, PDO::PARAM_INT);

        return $result->execute();
    }
}