<?php

/**
 * @SWG\Info(title="Angular PHP Api", version="0.1")
 */

namespace app\controller;

use \app\App;
use \app\model\Users as MUsers;
use app\entity\BaseResponse;

class Users extends Base
{
    /**
     * @SWG\Get(
     *     path="/api/user",
     *     summary="Текущий пользователь",
     *     description="Получение текущего пользователя",
     *     operationId="getUser",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Требуется авторизация",
     *     )
     * )
     */
    public function getUser()
    {
        $authModel = new MUsers();
        $user = $authModel->getUser();
        if(!$user) {
            App::$my->errorAuth();
        }
        return $user;
    }

    /**
     * @SWG\Get(
     *     path="/api/user/logout",
     *     summary="Завершить сессию",
     *     operationId="logoutUser",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Требуется авторизация",
     *     )
     * )
     */
    public function logoutUser()
    {
        (new MUsers())->logoutUser();
        return new BaseResponse(true);
    }


    /**
     * @SWG\Get(
     *     path="/api/user/{id}",
     *     summary="Получить пользователя по ID",
     *     description="Получить пользователя по ID",
     *     operationId="getUserById",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID пользователя",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(response=403, description="Нет доступа к запросу пользователей"),
     *     @SWG\Response(
     *         response="404", description="Пользователь не найден",
     *     )
     * )
     */
    public function getUserById($params, $args)
    {
        return (new MUsers())->getUserById((int) $args['id']);
    }

    /**
     * @SWG\Post(
     *     path="/api/auth",
     *     summary="Авторизовать пользователя",
     *     operationId="authUser",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Parameter(
     *         name="login",
     *         in="path",
     *         description="Логин",
     *         required=true,
     *         type="string",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="path",
     *         description="Пароль",
     *         required=true,
     *         type="string",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="path",
     *         description="Тип пользователя",
     *         required=true,
     *         type="string",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(
     *         response="400", description="Неверный логин или пароль",
     *     )
     * )
     */
    public function authUser($params)
    {
        if (!$params['login'] || !$params['password']) {
            throw new \Exception("Не передан логин или пароль");
        }

        $model = new MUsers();
        $user = $model->getUserByLoginPass($params['login'], $params['password'], $params['type']);
        if (!$user) {
            throw new \Exception("Логин или пароль не верны");
        }
        $model->setUser($user, $params['remember'], $params['type']);
        return $user;
    }

    /**
     * @SWG\Get(
     *     path="/api/users",
     *     summary="Список пользователей",
     *     operationId="getUsersList",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/User")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Требуется авторизация",
     *     )
     * )
     */
    public function getList()
    {
        return (new MUsers())->getList();
    }

    /**
     * @SWG\Post(
     *     path="/api/users",
     *     summary="Добавить пользователя",
     *     operationId="addUser",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="404", description="Пользователь не найден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function addUser($param)
    {
        return (new MUsers())->addUser($param);
    }

    /**
     * @SWG\Patch(
     *     path="/api/users/{id}",
     *     summary="Редактировать пользователя",
     *     operationId="editStudent",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="404", description="Польхователь не найден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function editUser($param, $args)
    {
        (new MUsers())->updateUser($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/users/{id}",
     *     summary="Удалить пользователя",
     *     operationId="deleteUser",
     *     produces={"application/json"},
     *     tags={"user"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     *     @SWG\Response(response=403, description="Нет доступа"),
     *     @SWG\Response(
     *         response="404", description="Пользователь не найден",
     *     )
     * )
     */
    public function deleteUser($param, $args)
    {
        (new MUsers())->deleteUser((int)$args['id']);
        return new BaseResponse(true);
    }

}

