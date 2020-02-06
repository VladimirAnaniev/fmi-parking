<?php
require 'ParkingDBController.php';
require 'routes.php';

class RequestController{
    private $parking_db;

    public function __construct() {
        $this->parking_db = new ParkingDBController();
    }

    private function errorResponse($errorMsg,$errCode){
        http_response_code($errCode);
        echo json_encode(['error' => $errorMsg],JSON_UNESCAPED_UNICODE);
    }

    private function checkSubmitPost() {
        if(!isset($_POST['submit'])) {
            header("Location:".INDEX_URL."?action=error");
            exit();
        }
    }

    private function checkAdminAuthorisation() {
        if(!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
            header("Location:".INDEX_URL."?action=unauthorised");
            exit();
        }
    }

    private function checkLoggedAuthorisation() {
        if(!isset($_SESSION['u_id'])) {
            header("Location:".INDEX_URL."?action=unauthorised");
            exit();
        }
    }

    private function mail_utf8($to, $subject = '(No subject)', $message = '')
    { 
        $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

        $headers = "MIME-Version: 1.0" . "\r\n" . 
        "Content-type: text/plain; charset=UTF-8" . "\r\n"; 

        return mail($to, $subject, $message, $headers); 
    }

    private function checkBarierByEmail($email) {
        //Error handlers
        //Check for empty fields
        if(empty($email)) {
            header("Location:".INDEX_URL."?liftbarier=no");
            exit();
        }    
    
        $query = $this->parking_db->getUserByEmail($email);

        if($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['u_id'];
            $role = $row['u_role'];
            if($this->checkShouldLiftBarrier($role,$id)) {
                header("Location:".INDEX_URL."?liftbarier=yes");
                exit();
            } 
        }
        header("Location:".INDEX_URL."?liftbarier=no");
    }

    private function checkShouldLiftBarrier($role, $id) {
        if($role == 'admin' || $role == 'permanent') {
            return true;
        }

        if($role == 'temporary') {

            $query = $this->parking_db->getCourseById($id);

            date_default_timezone_set('Europe/Sofia');
            $curWeekday = date('l');
            $curTime = date('H:i:s');

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                //echo $row['course_from'] . '-' . $row['course_to'];
                if($row['course_day'] == $curWeekday && $row['course_from'] < $curTime && $curTime < $row['course_to']) {
                    return true;
                }
            }
        }
        return false;
    }

    private function generatePassword($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
    
    public function register() {
        $this->checkAdminAuthorisation();
        $this->checkSubmitPost();

        $first = $_POST['first'];
        $last  = $_POST['last'];
        $email = $_POST['email'];
        $role = $_POST['role'];
    
        //Error handlers
        //Check for empty fields
        if(empty($first) || empty($last) || empty($email) || empty($role)) {
            header("Location:" .REGISTER_URL."?register=empty");
            exit();
        } 
        //Check if input characters are valid
        if(!preg_match('/[а-яА-Яa-zA-Z]/u', $first) ||
           !preg_match('/[а-яА-Яa-zA-Z]/u',$last)) {
            header("Location:" .REGISTER_URL."?register=invalidNameSymbols");
            exit();
        }
        
        //Check if email is valid
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            header("Location:" .REGISTER_URL."?register=invalidEmail");
            exit();
        }
        
        $query = $this->parking_db->getUserByEmail($email);
        if($query->rowCount() > 0) {
            header("Location:" .REGISTER_URL."?register=emailTaken");
            exit();
        } 

        //Hashing the password
        //$pwd = $this->generatePassword(12);
        $pwd = 'pass';
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        
        //Insert the user into the database
        $newUser = ['first' => $first, 'last' => $last, 'email' => $email, 'password' => $hashedPwd, 'role' => $role];
        $this->parking_db->insertNewUser($newUser);
                
        $msg = "Здравейте, $first $last.\n С Вашият имейл бе създаден профил в системата за паркиране към ФМИ!
            \n Вашата парола е: $pwd";
        $subject = "Създаден профил";
        $this->mail_utf8($email,$subject,$msg);
        
        header("Location:".INDEX_URL."?register=success");
        exit();
    }

    public function login() {
        //Error handlers
        if(isset($_SESSION['u_id'])) {
            header("Location:".INDEX_URL."?action=unauthorised");
            exit();
        }
        $this->checkSubmitPost();

        $email = $_POST['email'];
        $pwd   = $_POST['pwd'];
        $query = $this->parking_db->getUserByEmail($email);
    
        if(($row = $query->fetch(PDO::FETCH_ASSOC)) && password_verify($pwd, $row['u_password'])) {
            //Log in the user
            $_SESSION['u_id'] = $row['u_id'];
            $_SESSION['u_first'] = $row['u_first'];
            $_SESSION['u_last'] = $row['u_last'];
            $_SESSION['u_email'] = $row['u_email'];
            $_SESSION['u_role'] = $row['u_role'];
            header("Location:".INDEX_URL."?login=success");
        } else {
            header("Location:" .LOGIN_URL."?login=wrongCredentials");
        } 
    }

    public function logout() {
        $this->checkLoggedAuthorisation();
        //setcookie($_SESSION['email'],$_SESSION['role'],time()-1,'/');
        session_unset();
        session_destroy();
        header("Location:".INDEX_URL."?logout=success");
    }

    public function addCourse() {
        $this->checkAdminAuthorisation();    
        $this->checkSubmitPost();

        $email = $_POST['email'];
        $name = $_POST['name'];
        $day = $_POST['day'];
        $from = $_POST['from'];
        $to = $_POST['to'];
    
        //Error handlers
        //Check for empty fields
        if(empty($email) || empty($name) || empty($day) || empty($from) || empty($to)) {
            header("Location:" .ADD_COURSE_URL."?addcourse=empty");
            exit();
        } 
        //Format dates
        $from=date('H:i:s',strtotime($from));
        $to=date('H:i:s',strtotime($to));

        //Check if input characters are valid
        if($from >= $to) {
            header("Location:" .ADD_COURSE_URL."?addcourse=invalidTimes");
            exit();
        } 
        
        $query = $this->parking_db->getUserByEmail($email);
    
        if($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //Insert the course into the database
            $newCourse = ['name' => $name, 'teacher_id' => $row['u_id'], 'day' => $day, 'from' => $from, 'to' => $to];
            $this->parking_db->insertNewCourse($newCourse);
            header("Location:".INDEX_URL."?addcourse=success");
        } else {
            header("Location:" .ADD_COURSE_URL."?addcourse=noSuchEmail");
        }
    }

    public function changePass() {

        $this->checkLoggedAuthorisation();
        $this->checkSubmitPost();
        
        $pwd = $_POST['pwd'];
        $newPwd = $_POST['newPwd'];
        $newPwd2 = $_POST['newPwd2'];
        $email = $_SESSION['u_email'];
        $first = $_SESSION['u_first'];
        $last = $_SESSION['u_last'];
        
        if(empty($pwd) || empty($newPwd) || empty($newPwd2)) {
            header("Location:" .CHANGE_PASS_URL."?changepass=empty");
            exit();
        } 
        if($newPwd != $newPwd2) {
            header("Location:" .CHANGE_PASS_URL."?changepass=passwordsMismatch");
            exit();
        } 

        $query = $this->parking_db->getUserByEmail($email);
        
        if(($row = $query->fetch(PDO::FETCH_ASSOC)) && password_verify($pwd, $row['u_password'])) {
            //Hashing the password
            $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);

            //Insert the user into the database
            $newData = ['email' => $email, 'password' => $hashedPwd];
            $this->parking_db->changeUserPassword($newData);
            
            $msg = "Здравейте, $first $last.\n Вашата парола за системата за паркиране към ФМИ бе променена!
            \n Новата Ви парола е: $newPwd";
            $subject = "Смяна на парола";
            $this->mail_utf8($email,$subject,$msg);
            
            header("Location:".INDEX_URL."?changepass=success");
        } else {
            header("Location:" .CHANGE_PASS_URL."?changepass=wrongCredentials");
        }
    }

    public function changeStatus() {
        $this->checkAdminAuthorisation();
        $this->checkSubmitPost();
        
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        if(empty($email) || empty($role)) {
            header("Location:" .CHANGE_STATUS_URL."?changestatus=empty");
            exit();
        }  

        $query = $this->parking_db->getUserByEmail($email);

        if($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $first = $row['u_first'];
            $last = $row['u_last'];

            //change user status
            $newData = ['email' => $email, 'role' => $role];
            $this->parking_db->changeUserStatus($newData);
            
            $msg = "Здравейте, $first $last. \n Вашата роля в системата за паркиране към ФМИ бе променена!
                        \n Новата Ви роля е: $role";
            $subject = "Промяна на ролята";
            $this->mail_utf8($email,$subject,$msg);
            
            header("Location:".INDEX_URL."?changestatus=success");
        } else {
            header("Location:" .CHANGE_STATUS_URL."?changestatus=noEmail");
        }
    }

    public function checkCode() {
        if(!isset($_GET['email'])) {
            header("Location:".INDEX_URL."?liftbarier=no");
            exit();
        }
        $email = $_GET['email'];
        
        $this->checkBarierByEmail($email);
    }

    public function liftBarier() {
        $this->checkSubmitPost();

        $email = $_POST['email'];

        $this->checkBarierByEmail($email);
    }

    public function forgottenPass() {
        if(isset($_SESSION['u_id'])) {
            header("Location:".INDEX_URL."?action=unauthorised");
            exit();
        }
        
        $this->checkSubmitPost();
        
        $email = $_POST['email'];
        
        if(empty($email)) {
            header("Location:" .FORGOTTEN_PASS_URL."?=forgottenPass=empty");
            exit();
        }
        
        $query = $this->parking_db->getUserByEmail($email);        
        
        if($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $first = $row['u_first'];
            $last = $row['u_last'];
    
            //Hashing the password
            $newPwd = $this->generatePassword(12);
            $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);
            
            //Insert the user into the database
            $newData = ['email' => $email, 'password' => $hashedPwd];
            $this->parking_db->changeUserPassword($newData);
        
            $msg = "Здравейте, $first $last.\n Вашата парола за системата за паркиране към ФМИ бе променена!
            \n Новата Ви парола е: $newPwd";
            $subject = "Забравена парола";
            $this->mail_utf8($email,$subject,$msg);
    
            header("Location:".INDEX_URL."?forgottenPass=success");
        } else {
            header("Location:" .FORGOTTEN_PASS_URL."?forgottenPass=noSuchEmail");
        } 
    }

}