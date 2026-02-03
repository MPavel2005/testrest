<?php

abstract class Api
{
    protected $method = ''; //GET|POST|PUT|DELETE

    public $requestUri = [];
    public $requestParams = []; //поля: title, description, status

    protected $action = ''; //Название метода для выполнения


    public function __construct() {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        //print_r($_SERVER['REQUEST_URI']);
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        $this->requestParams = $_REQUEST;

        //Определение метода
        //print_r($_SERVER['REQUEST_METHOD']);
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Непонятный метод");
            }
        }
    }

    public function run() {

        //print_r($this->requestUri);
        if(array_shift($this->requestUri) !== 'tasks'){
            throw new RuntimeException('API Not Found', 404);
        }
        //Определение действия
        $this->action = $this->getAction();
        print_r($this->action);
        //Если метод(действие) определен в дочернем классе API
        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if($this->requestUri){
                    return 'viewTask';
                } else {
                    return 'allTasks';
                }
                break;
            case 'POST':
                return 'createTask';
                break;
            case 'PUT':
                return 'updateTask';
                break;
            case 'DELETE':
                return 'deleteTask';
                break;
            default:
                return null;
        }
    }

    abstract protected function allTasks();
    abstract protected function viewTask();
    abstract protected function createTask();
    abstract protected function updateTask();
    abstract protected function deleteTask();
}