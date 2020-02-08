<?php


class Course
{
    private $id;
    private $title;
    private $teacherId;
    private $courseDay;
    private $courseFrom;
    private $courseTo;

    /**
     * Course constructor.
     * @param $id
     * @param $title
     * @param $teacherId
     * @param $courseDay
     * @param $courseFrom
     * @param $courseTo
     */
    public function __construct($id, $title, $teacherId, $courseDay, $courseFrom, $courseTo)
    {
        $this->id = $id;
        $this->title = $title;
        $this->teacherId = $teacherId;
        $this->courseDay = $courseDay;
        $this->courseFrom = $courseFrom;
        $this->courseTo = $courseTo;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * @param mixed $teacherId
     */
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    /**
     * @return mixed
     */
    public function getCourseDay()
    {
        return $this->courseDay;
    }

    /**
     * @param mixed $courseDay
     */
    public function setCourseDay($courseDay)
    {
        $this->courseDay = $courseDay;
    }

    /**
     * @return mixed
     */
    public function getCourseFrom()
    {
        return $this->courseFrom;
    }

    /**
     * @param mixed $courseFrom
     */
    public function setCourseFrom($courseFrom)
    {
        $this->courseFrom = $courseFrom;
    }

    /**
     * @return mixed
     */
    public function getCourseTo()
    {
        return $this->courseTo;
    }

    /**
     * @param mixed $courseTo
     */
    public function setCourseTo($courseTo)
    {
        $this->courseTo = $courseTo;
    }

    public static function getCourseById($id)
    {
        $sql = "SELECT * FROM courses WHERE teacher_id = :id";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $query->execute(['id' => $id]);
        return $query;
    }
}
