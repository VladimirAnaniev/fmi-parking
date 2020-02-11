<?php

require_once 'Course.php';
require_once 'ParkingDB.php';

class CourseService
{
    public static function getAllCoursesByTeacherId($id)
    {
        $connection = ParkingDB::getInstance()->getConnection();
        $sql = "SELECT * FROM courses WHERE teacher_id = :id";
        $query = $connection->prepare($sql);
        $query->execute(['id' => $id]);

        $result = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            array_push(
                $result,
                new Course(
                    $row['course_id'],
                    $row['course_title'],
                    $row['teacher_id'],
                    $row['course_day'],
                    $row['course_from'],
                    $row['course_to']
                )
            );
        }
        return $result;
    }

    public static function getCourseByTeacherAndDay($teacher, $day) {
        $sql = "SELECT * FROM courses WHERE teacher_id = :id AND course_day=:cday";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $query->execute(['id' => $teacher, 'cday' => $day]);
        return $query;
    }

    public static function insertNewCourse($newCourse) {
        $sql = "INSERT INTO courses (course_title, teacher_id, course_day, course_from, course_to)
                VALUES (:name, :teacher_id, :day, :from, :to)";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $query->execute($newCourse);
    }
}
