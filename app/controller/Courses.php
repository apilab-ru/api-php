<?php

namespace app\controller;

use \app\model\Courses as MCourses;
use \app\entity\BaseResponse;

class Courses extends Base {

    /**
     * @SWG\Get(
     *     path="/api/courses",
     *     summary="Список",
     *     operationId="getCourses",
     *     produces={"application/json"},
     *     tags={"course"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Course")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getList()
    {
        return (new MCourses())->getList();
    }

    /**
     * @SWG\Get(
     *     path="/api/courses/{id}",
     *     summary="Курс",
     *     operationId="getCourse",
     *     produces={"application/json"},
     *     tags={"course"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/Course"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getCourse($params, $args)
    {
        return (new MCourses())->getCourse((int) $args['id']);
    }

    /**
     * @SWG\Post(
     *     path="/api/courses",
     *     summary="Добавить",
     *     operationId="addCourse",
     *     produces={"application/json"},
     *     tags={"course"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Course"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа",
     *     )
     * )
     */
    public function add($param)
    {
        $id = (new MCourses())->add($param);
        return new BaseResponse(true, null, $id);
    }

    /**
     * @SWG\Patch(
     *     path="/api/courses/{id}",
     *     summary="Редактировать",
     *     operationId="editCourse",
     *     produces={"application/json"},
     *     tags={"course"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Course"),
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
     *         response="404", description="Язык не нейден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function edit($param, $args)
    {
        (new MCourses())->update($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/courses/{id}",
     *     summary="Удалить",
     *     operationId="deleteCourse",
     *     produces={"application/json"},
     *     tags={"course"},
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
     *         response="404", description="Язык не найден",
     *     )
     * )
     */
    public function delete($param, $args)
    {
        (new MCourses())->delete((int)$args['id']);
        return new BaseResponse(true);
    }

}