<?php

namespace app\controller;

use \app\model\Lessons as MLessons;
use \app\entity\BaseResponse;

class Lessons extends Base {

    /**
     * @SWG\Get(
     *     path="/api/lessons/{id}",
     *     summary="Занятие",
     *     operationId="getLesson",
     *     produces={"application/json"},
     *     tags={"lesson"},
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
     *         @SWG\Schema(ref="#/definitions/Lesson"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getItem($param, $args)
    {
        return (new MLessons())->getItem((int)$args['id']);
    }

    /**
     * @SWG\Get(
     *     path="/api/lessons/group/{groupId}",
     *     summary="Расписание группы",
     *     operationId="getLessonsForGroup",
     *     produces={"application/json"},
     *     tags={"lesson"},
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Lesson")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getListGroup($param, $args)
    {
        return (new MLessons())->getListForGroup((int)$args['groupId']);
    }

    /**
     * @SWG\Get(
     *     path="/api/lessons/teacher/{teacherId}",
     *     summary="Расписание педагога",
     *     operationId="getLessonsForTeacher",
     *     produces={"application/json"},
     *     tags={"lesson"},
     *     @SWG\Parameter(
     *         name="teacherId",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Lesson")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getLessonsTeacher($param, $args)
    {
        return (new MLessons())->getListForTeacher((int)$args['teacherId']);
    }

    /**
     * @SWG\Post(
     *     path="/api/lessons/group/{groupId}",
     *     summary="Добавить занятие",
     *     operationId="addLesson",
     *     produces={"application/json"},
     *     tags={"lesson"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Lesson"),
     *     ),
     *     @SWG\Parameter(
     *         name="groupId",
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
     *         response="403",
     *         description="Нет доступа",
     *     )
     * )
     */
    public function addLesson($param, $args)
    {
        $id = (new MLessons())->add($param, (int)$args['groupId']);
        return new BaseResponse(true, null, $id);
    }

    /**
     * @SWG\Patch(
     *     path="/api/lessons/{id}",
     *     summary="Редактировать занятие",
     *     operationId="editStudent",
     *     produces={"application/json"},
     *     tags={"lesson"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Lesson"),
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
    public function editLesson($param, $args)
    {
        (new MLessons())->update($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/lessons/{id}",
     *     summary="Удалить занятие",
     *     operationId="deleteLesson",
     *     produces={"application/json"},
     *     tags={"lesson"},
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
    public function deleteLesson($param, $args)
    {
        (new MLessons())->delete((int)$args['id']);
        return new BaseResponse(true);
    }


}