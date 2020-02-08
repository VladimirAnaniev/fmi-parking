<?php
require 'models/ParkingDB.php';
class ParkingDBController{
    private $connection;

    public function __construct()
    {
        $this->connection = ParkingDB::getInstance()->getConnection();
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

    public function getCourseByTeacherAndDay($teacher, $day) {
        $sql = "SELECT * FROM courses WHERE teacher_id = :id AND course_day=:cday";
        $query = $this->connection->prepare($sql);
        $query->execute(['id' => $teacher, 'cday' => $day]);
        return $query;
    }

    public function insertNewCourse($newCourse) {
        $sql = "INSERT INTO courses (course_title, teacher_id, course_day, course_from, course_to)
                VALUES (:name, :teacher_id, :day, :from, :to)";
        $query = $this->connection->prepare($sql);
        $query->execute($newCourse);
    }

    public function hasFreeParkingSpots()
    {
        $sql = "SELECT * FROM parking_spots WHERE free=1";
        $query = $this->connection->prepare($sql);

        $query->execute();

        return $query->rowCount() > 0;
    }

    public function updateParkingSpots($id, $duration)
    {
        $sql = "UPDATE parking_spots
                SET free=0, owner=:id, time_in=NOW(), duration=:duration
                WHERE number =
                (SELECT number FROM parking_spots
                WHERE free = 1 LIMIT 1)";

        $query = $this->connection->prepare($sql);
        $result = $query->execute(['id' => $id, "duration" => $duration]);

        if (!$result) {
            header("Location:".INDEX_URL."?failedToUpdateParking=true");
            exit();
        }
    }

    public function freeParkingSpot($id)
    {
        $sql = "UPDATE parking_spots
                SET free=1, owner=NULL, time_in=NULL, duration=NULL
                WHERE owner =
                (SELECT owner FROM parking_spots
                WHERE free=0 AND owner=:id LIMIT 1)";

        $query = $this->connection->prepare($sql);
        $result = $query->execute(['id' => $id]);

        if (!$result) {
            header("Location:".INDEX_URL."?failToFree=true".$id);
            exit();
        }
    }

    public function userIsLeaving($id)
    {
        $sql = "SELECT * FROM parking_spots
                WHERE owner=:id AND free=0";

        $query = $this->connection->prepare($sql);
        $query->execute(['id' => $id]);

        return $query->rowCount() > 0;
    }
}
