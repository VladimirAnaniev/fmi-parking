<?php

require_once '../models/UserService.php';

class UserController
{
    public static function getCoursesByUserId($userId)
    {
        return UserService::getCoursesByUserId($userId);
    }
}
