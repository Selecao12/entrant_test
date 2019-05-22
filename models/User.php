<?php

class User
{

    public static function register($name, $email, $password)
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) '
            . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();

    }

    /**
     * Запоминаем пользователя
     * @param string $userId
     */
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {
        // Если сессия есть, вернет идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * Returns user by id
     * @param integer $id
     *
     * @return array
     */
    public static function getUserById($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Проверяет права пользователя
     *
     * @param int $userGroupId
     * @return array
     */
    public static function getUserGroup($userGroupId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user_group WHERE id = ' . $userGroupId;
        $result = $db->query($sql);

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    public static function isAdmin()
    {
        if (self::isGuest()) {
            return false;
        }

        $userId = self::checkLogged();
        $user = self::getUserById($userId);

        if ($user['role'] == 'admin') {
            return true;
        }

        return false;
    }

    public static function isExaminer()
    {
        if (self::isGuest()) {
            return false;
        }
    }
}
