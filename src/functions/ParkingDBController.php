<?php
require 'ParkingDB.php';
class ParkingDBController{
    private $connection;

    public function __construct()
    {
        $this->connection = ParkingDB::getInstance()->getConnection();
    }
    
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE u_email = :email";
        $query = $this->connection->prepare($sql);
        $query->execute(['email' => $email]);
        return $query;
    }
    
    public function changeUserPassword($newData) {
        $sql = "UPDATE users SET u_password = :password WHERE u_email = :email;";
        $query = $this->connection->prepare($sql);
        $query->execute($newData);
    }

    public function changeUserStatus($newData) {
        $sql = "UPDATE users SET u_role = :role WHERE u_email = :email;";
        $query = $this->connection->prepare($sql);
        $query->execute($newData);
    }
    
    public function insertNewUser($newUser) {
        $sql = "INSERT INTO users (u_first, u_last, u_email, u_password, u_role)
                VALUES (:first, :last, :email, :password, :role)";
        $query = $this->connection->prepare($sql);
        $query->execute($newUser);
    }

    public function getCourseById($id) {
        $sql = "SELECT * FROM courses WHERE teacher_id = :id";
        $query = $this->connection->prepare($sql);
        $query->execute(['id' => $id]);
        return $query;
    }

    public function insertNewCourse($newCourse) {
        $sql = "INSERT INTO courses (course_title, teacher_id, course_day, course_from, course_to)
                VALUES (:name, :teacher_id, :day, :from, :to)";
        $query = $this->connection->prepare($sql);
        $query->execute($newCourse);
    }
    
}
