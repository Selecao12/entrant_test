<?php

class User
{

    /**
     * Добавляет пользователя в базу данных
     *
     * @param $login
     * @param $password
     * @param $userGroup
     * @return bool
     */
    public static function addUser($login, $password, $userGroup)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $db = Db::getConnection();

        $sql = 'INSERT INTO user(login, password, user_group) VALUES (:login, :password, :user_group)';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':user_group', $userGroup, PDO::PARAM_INT);

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

    /**
     * Проверяет залогинен ли пользователь
     *
     * @return mixed
     */
    public static function checkLogged()
    {
        // Если сессия есть, вернет идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        return 0;
    }

    /**
     * Возвращает пользователя по id
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

    /**
     * Проверяет к нужной ли группе относится пользователя
     *
     * @param $userGroup
     * @return bool
     */
    public static function checkUserGroup($userGroup)
    {
        $userId = self::checkLogged();

        if ($userId === 0) {
            return false;
        }
        $user = self::getUserById($userId);

        return $userGroup == self::getUserGroup($user['user_group'])['name'];

    }

    /**
     * Проверяет логин и пароль пользователя
     *
     * @param $login
     * @param $password
     * @return bool
     */
    public static function checkUserData($login, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE login = :login';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $passwordHash = $user['password'];

            if (password_verify($password, $passwordHash)) {
                return $user['id'];
            }
        }

        return false;
    }

    /**
     * Обновляет время доступа к тесту для группы пользователей "абитуриенты"
     *
     * @param $accessTime
     * @return bool
     */
    public static function setAccessTime($accessTime)
    {
        $db = Db::getConnection();

        $sql = 'UPDATE user_group SET access_time = :access_time WHERE id = 3';

        $result = $db->prepare($sql);
        $result->bindParam(':access_time', $accessTime, PDO::PARAM_INT);

        return $result->execute();
    }
}
