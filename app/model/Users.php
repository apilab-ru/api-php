<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Teacher;
use app\entity\UserRole;
use app\entity\User;
use app\entity\Student;

class Users extends Base
{
    private static $COOKIE = 'auth';
    private static $TYPE = 'type';
    private static $SALT = 'API_SALT';
    private static $COOKIE_EXPIRE = 60 * 60 * 24 * 30;

    public function getTypeUser() {
        $user = $this->getUser();
        return $user ? $user->role : UserRole::NONE;
    }

    public function getUser(): ?User {
        return $_SESSION['user'] ? new User($_SESSION['user']) : null;
    }

    public function autoAuthUser()
    {
        if($this->getUser()) {
            return;
        }

        $cookie = ($_COOKIE[self::$COOKIE]) ? $_COOKIE[self::$COOKIE] : $_REQUEST[self::$COOKIE];
        $type = ($_COOKIE[self::$TYPE]) ? $_COOKIE[self::$TYPE] : $_REQUEST[self::$TYPE];
        if($cookie){
            setcookie(self::$COOKIE, $cookie, time() + self::$COOKIE_EXPIRE);
            // TODO автоавторизация не работает
            $user = $this->getUserByCookie($cookie, $type);
            if($user) {
                $this->setUser($user);
            }
        }
    }

    public function logoutUser()
    {
        unset($_SESSION['user']);
    }

    public function getUserById(int $id) : ?User
    {
        $user = $this->db->selectRow("select * from user where id=?d", $id);
        return $user ? new User($user) : null;
    }

    public function getUserByCookie(string $cookie=null, string $type=null) : ?User
    {
        $user = null;
        switch($type) {
            case 'admin':
                $data = $this->db->selectRow("select * from user where cookie=?", $cookie);
                $user = new User($data);
                break;

            case 'student':
                $data = $this->db->selectRow("select * from students where cookie=?", $cookie);
                $user = new User($data);
                break;

            case 'teacher':
                $data = $this->db->selectRow("select * from teachers where cookie=?", $cookie);
                $user = new User($data);
                break;
        }

        return $user;
    }

    public function setUser($user, $remember = false, $type = null)
    {
        if ($remember) {
            $user->cookie = $this->genCookie();
            switch ($type) {
                case 'teacher':
                    $table = 'teachers';
                    break;
                case 'student':
                    $table = 'students';
                    break;
                default:
                    $table = 'user';
                    break;
            }
            $this->updateObject($table, [
                'cookie' => $user->cookie,
            ], $user->id);
        }
        $_SESSION['user'] = (array)$user;
    }

    public function genCookie() : string
    {
        return md5(self::$SALT . time());
    }

    public function getUserByLoginPass($login, $pass, $type)
    {
        $user = null;
        switch($type) {
            case 'teacher':
                $data = $this->db->selectRow("select * from teachers where email=? && password=?", $login, md5($pass));
                if($data)
                $user = new Teacher($data);
                break;

            case 'student':
                $data = $this->db->selectRow("select * from students where email=? && password=?", $login, md5($pass));
                if($data)
                $user = new Student($data);
                break;

            default:
                $data = $this->db->selectRow("select * from user where email=? && password=?", $login, md5($pass));
                if($data)
                    $user = new User($data);
                break;
        }

        return $user;
    }

    public function getList(): array {
        $data = $this->db->select("select * from user where role in ('admin', 'manager', 'corporate')");
        $list = [];
        foreach($data as $item) {
            $list[] = new User($item);
        }
        return $list;
    }

    public function addUser(array $userData)
    {
        $user = (new User($userData, true))->serializeToBd();
        return $this->updateObject('user', $user);
    }

    public function updateUser(array $userData, $id)
    {
        $user = (new User($userData, true));
        return $this->updateObject('user', $user->serializeToBd(), $id);
    }

    public function deleteUser($id)
    {
        return $this->deleteObject('user', $id);
    }
    
}
