<?php

require_once 'User.php';
require_once 'ParkingDB.php';

class UserService
{
    public static function getAllUsers()
    {
        $conn = ParkingDB::getInstance()->getConnection();
        $result = $conn->query("SELECT * FROM `users`;");
        return $result;
    }

    public static function addUser($args)
    {
        $conn = ParkingDB::getInstance()->getConnection();
        $result = $conn
            ->prepare("INSERT INTO `users` (`u_first`, `u_last`, `u_email`, `u_role`) VALUES (?,?,?,?);")
            ->execute($args);
        return $result;
    }

    public static function getCourses($userId)
    {
        $conn = ParkingDB::getInstance()->getConnection();
        $sql = "SELECT * FROM courses WHERE teacher_id = :id";

        $query = $conn->prepare($sql);
        $query->execute(['id' => $userId]);

        $courses = array();
        while ($row = $query->fetch()) {
            $course = new Course(
                $row["course_id"],
                $row["course_title"],
                $row["teacher_id"],
                $row["course_day"],
                $row["course_from"],
                $row["course_to"]
            );

            array_push($courses, $course);
        }

        return $courses;
    }

    /**
     * @brief Updates DB with the user's new password hash
     * @return true if DB was sucessfully updated; false otherwise
     */
    public static function changePasswordByEmail($email, $newPassword)
    {
        $sql = "UPDATE users SET u_password = :newPasswordHash WHERE u_email = :email;";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        return $query->execute([':newPasswordHash' => $newPasswordHash, ':email' => $email]);
    }

    public static function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE u_id = :id";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $query->execute(['id' => $id]);
        return self::createUserByExecutedQuery($query);
    }

    public static function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE u_email = :email";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $query->execute(['email' => $email]);
        return self::createUserByExecutedQuery($query);
    }

    public static function getPasswordHashByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE u_email = :email";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $query->execute(['email' => $email]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return $row['u_password'];
    }

    private static function createUserByExecutedQuery($executedQuery)
    {
        $row = $executedQuery->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new User(
            $row['u_first'],
            $row['u_last'],
            $row['u_email'],
            $row['u_role'],
            $row['u_id'],
            $row['car']
        );
    }
}
