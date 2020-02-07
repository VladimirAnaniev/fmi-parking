<?php

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
}
