<?php

namespace app;

use app\model\Users;

class App
{
    static $db = null;
    static $args = null;
    static $my = null;
    static $param = null;

    private $access;
    private $auth;

    private static $dev = 0;

    public function __construct($param, $access)
    {
        self::$param = $param;
        $this->access = $access;

        self::$db = new model\DataBase($param['db']);
        self::$my = $this;
        self::$dev = $param['dev'];

        $this->auth = new Users();
        $this->auth->autoAuthUser();

        if(!$this->auth->getUser() && $param['defUser']) {
            $this->auth->setUser( $this->auth->getUserById( $param['defUser']) );
        }

        if (self::$dev) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, PUT, PATCH, POST, DELETE, OPTIONS');
        }
    }

    public function run($args, $send)
    {
        $controller = "\app\controller\\" . $args['controller'];
        $method = $args['action'];
        self:$args = $args;

        if (class_exists($controller)) {
            $controller = new $controller();
        } else {
            $this->errorNotFound($args);
        }

        $access = $this->checkAccess($args['access']);

        if (!$access) {
            $this->errorAccess();
        }

        $data = file_get_contents('php://input');
        if($data){
            $data = json_decode($data,1);
        }
        if($data){
            $send = $data;
        }

        if (is_array($access)) {
            foreach ($access as $key => $it) {
                $it = ($it == 'userId') ? $this->auth->getUser()->id : $it;
                $args[$key] = $it;
            }
        }

        if (method_exists($controller, $method)) {
            try {
                $res = $controller->$method($send, $args);
                header('content-type: application/json; charset=utf-8');
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            } catch (\Exception $e) {
                $this->errorRequest($e->getMessage());
            }
        } else {
            $this->errorNotFound($args);
        }
    }

    public function errorNotFound()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header("HTTP/1.0 404 Not Found");
        die("Нет такой страницы");
    }

    public function errorAccess()
    {
        header("HTTP/1.0 403");
        die("Нет доступа");
    }

    public function errorAuth()
    {
        header("HTTP/1.0 401");
        die("Требуется авторизация");
    }

    public function errorRequest($error) {
        header("HTTP/1.0 400");
        header('content-type: application/json; charset=utf-8');
        echo json_encode([
            'error' => $error
        ], JSON_UNESCAPED_UNICODE);
        die();
    }

    public function checkAccess($roles)
    {
        $type = $this->auth->getTypeUser();

        if (!$roles) {
            return true;
        } else {
            if (in_array($type, $roles)) {
                return true;
            } else if ($roles[$type]) {
                return $roles[$type];
            } else {
                return false;
            }
        }
    }

    public function checkAccessC($controller, $method)
    {
        $type = $this->auth->getTypeUser();

        if (!isset($this->access[$controller]) || !isset($this->access[$controller][$method])) {
            return true;
        } else {
            if (in_array($type, $this->access[$controller][$method])) {
                return true;
            } else if ($this->access[$controller][$method][$type]) {
                return $this->access[$controller][$method][$type];
            } else {
                return false;
            }
        }
    }
}