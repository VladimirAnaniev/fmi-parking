<?php

require 'Course.php';

class User
{
    private $u_first;
    private $u_last;
    private $u_email;
    private $u_role;
    private $u_id;
    private $car;

    /**
     * User constructor.
     * @param $u_first
     * @param $u_last
     * @param $u_email
     * @param $u_role
     * @param $u_id
     * @param $car
     */
    public function __construct($u_first, $u_last, $u_email, $u_role, $u_id, $car)
    {
        $this->u_first = $u_first;
        $this->u_last = $u_last;
        $this->u_email = $u_email;
        $this->u_role = $u_role;
        $this->u_id = $u_id;
        $this->car = $car;
    }


    public static function getAllUsers($conn)
    {
        $result = $conn->query("SELECT * FROM `users`;");
        return $result;
    }

    public static function addUser($conn, $args)
    {
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
     * @return mixed
     */
    public function getUFirst()
    {
        return $this->u_first;
    }

    /**
     * @param mixed $u_first
     */
    public function setUFirst($u_first)
    {
        $this->u_first = $u_first;
    }

    /**
     * @return mixed
     */
    public function getULast()
    {
        return $this->u_last;
    }

    /**
     * @param mixed $u_last
     */
    public function setULast($u_last)
    {
        $this->u_last = $u_last;
    }

    /**
     * @return mixed
     */
    public function getUEmail()
    {
        return $this->u_email;
    }

    /**
     * @param mixed $u_email
     */
    public function setUEmail($u_email)
    {
        $this->u_email = $u_email;
    }

    /**
     * @return mixed
     */
    public function getURole()
    {
        return $this->u_role;
    }

    /**
     * @param mixed $u_role
     */
    public function setURole($u_role)
    {
        $this->u_role = $u_role;
    }

    /**
     * @return mixed
     */
    public function getUId()
    {
        return $this->u_id;
    }

    /**
     * @param mixed $u_id
     */
    public function setUId($u_id)
    {
        $this->u_id = $u_id;
    }

    /**
     * @return mixed
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param mixed $car
     */
    public function setCar($car)
    {
        $this->car = $car;
    }

    /**
     * @brief Updates DB with the user's new password hash
     */
    public static function changePasswordByEmail($email, $newPassword)
    {
        $sql = "UPDATE users SET u_password = :newPasswordHash WHERE u_email = $email;";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $query->bindParam(':newPasswordHash', $newPasswordHash);
        $query->execute();
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
