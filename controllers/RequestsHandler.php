<?php
require_once 'RequestController.php';
include_once 'routes.php';

class RequestsHandler
{
    private $requests;
    private $request_controller;

    public function __construct() {
        $this->requests = [];
        $this->request_controller = new RequestController();
        $this->setRequests();
    }

    private function addNewRequest($method, $cmd, $callback) {
        array_push($this->requests, [
            'method' => $method,
            'cmd' => $cmd,
            'callback' => $callback
        ]);
    }

    private function setRequests() {
        $this->addNewRequest('POST', 'register', function(){
            $this->request_controller->register();
        });
        $this->addNewRequest('POST', 'login', function(){
            $this->request_controller->login();
        });
        $this->addNewRequest('GET', 'logout', function(){
            $this->request_controller->logout($email);
        });
        $this->addNewRequest('POST', 'addcourse', function(){
            $this->request_controller->addCourse($data);
        });
        $this->addNewRequest('POST', 'changepass', function(){
            $this->request_controller->changePass();
        });
        $this->addNewRequest('POST', 'changestatus', function(){
            $this->request_controller->changeStatus();
        });
        $this->addNewRequest('GET', 'checkcode', function(){
            $this->request_controller->checkCode();
        });
        $this->addNewRequest('POST', 'liftbarier', function(){
            $this->request_controller->liftBarier();
        });
        $this->addNewRequest('POST', 'forgottenpass', function(){
            $this->request_controller->forgottenPass();
        });
    }

    public function run(){

        $method = $_SERVER['REQUEST_METHOD'];
        $cmd = $_SERVER['PATH_INFO'];

        session_start();

        $cmd_args = explode('/',$cmd);

        $matched = false;
        foreach($this->requests as $request){
            if($request['method'] === $method && $request['cmd'] === $cmd_args[1]){
                $matched = true;
                $request['callback']();
                break;
            }
        }

        if(!$matched) {
            header("Location:".INDEX_URL."?action=wrongCommand");
        }
    }
}