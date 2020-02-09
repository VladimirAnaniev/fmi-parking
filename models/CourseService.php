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
    }
}
