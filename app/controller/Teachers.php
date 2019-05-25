<?php

namespace app\controller;

use \app\entity\BaseResponse;
use \app\entity\TeacherDetail;
use \app\model\Teachers as MTeachers;
use \app\model\Groups as MGroups;
use \app\model\Attendances as MAttendances;

class Teachers extends Base
{
    /**
     * @SWG\Get(
     *     path="/api/teachers",
     *     summary="Список педагогов",
     *     operationId="getTeachers",
     *     produces={"application/json"},
     *     tags={"teacher"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Teacher")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getTeachers(): array
    {
        return (new MTeachers)->getList();
    }

    /**
     * @SWG\Get(
     *     path="/api/teachers/{id}",
     *     summary="Педагог детально",
     *     operationId="getTeacherDetail",
     *     produces={"application/json"},
     *     tags={"teacher"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Педагога",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/TeacherDetail"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getTeacher($params, $args): TeacherDetail
    {
        return (new MTeachers)->getTeacherDetail((int) $args['id']);
    }

    /**
     * @SWG\Get(
     *     path="/api/teachers/{id}/groups",
     *     summary="Педагог группы",
     *     operationId="getTeacherGroups",
     *     produces={"application/json"},
     *     tags={"teacher"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Педагога",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Group")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getTeacherGroups($params, $args): array
    {
        return (new MGroups)->getGroupsTeacher((int)$args['id']);
    }

    /**
     * @SWG\Get(
     *     path="/api/teachers/{id}/attendances",
     *     summary="Проведённые занятия педагога",
     *     operationId="getTeacherAttendances",
     *     produces={"application/json"},
     *     tags={"teacher"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Педагога",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Attendance")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getTeacherAttendances($params, $args): array
    {
        return (new MAttendances)->getListForTeacher($args['id']);
    }

    /**
     * @SWG\Post(
     *     path="/api/teachers",
     *     summary="Добавить педагога",
     *     operationId="addTeacher",
     *     produces={"application/json"},
     *     tags={"teacher"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Teacher"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="400", description="Ошибка добавления",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function addTeacher($param)
    {
        return (new MTeachers())->addTeacher($param);
    }

    /**
     * @SWG\Patch(
     *     path="/api/teachers/{id}",
     *     summary="Редактировать педагога",
     *     operationId="editTeacher",
     *     produces={"application/json"},
     *     tags={"teacher"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Teacher"),
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Педагога",
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
     *         response="404", description="Не найдено",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function editTeacher($param, $args)
    {
        (new MTeachers())->updateTeacher($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/teachers/{id}",
     *     summary="Удалить педагога",
     *     operationId="deleteTeacher",
     *     produces={"application/json"},
     *     tags={"teacher"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Педагога",
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
     *         response="404", description="Педагог не найден",
     *     )
     * )
     */
    public function deleteTeacher($param, $args)
    {
        (new MTeachers())->deleteTeacher((int)$args['id']);
        return new BaseResponse(true);
    }
}