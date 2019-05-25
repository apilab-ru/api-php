<?php

namespace app\controller;

use app\entity\AttendanceDetail;
use app\entity\BaseResponse;
use app\entity\DateDto;
use app\entity\TimeDto;
use app\model\Attendances as MAttendances;
use app\model\Groups as MGroups;
use app\model\Students as MStudents;

class Groups extends Base
{
    /**
     * @SWG\Get(
     *     path="/api/groups",
     *     summary="Список",
     *     operationId="getGroups",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/GroupStudent")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getList($param, $args): array
    {
        return (new MGroups)->getList($param);
    }

    /**
     * @SWG\Post(
     *     path="/api/groups",
     *     summary="Добавить группу",
     *     operationId="addGroup",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Group"),
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
    public function addGroup($param)
    {
        return (new MGroups())->addGroup($param);
    }

    /**
     * @SWG\Get(
     *     path="/api/groups/{id}",
     *     summary="Запросить группу",
     *     operationId="getGroup",
     *     produces={"application/json"},
     *     tags={"group"},
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
     *         @SWG\Schema(ref="#/definitions/Group")
     *     ),
     *     @SWG\Response(
     *         response="404", description="Не найдено",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function getItem($param, $args)
    {
        return (new MGroups())->getItem((int)$args['id']);
    }

    /**
     * @SWG\Patch(
     *     path="/api/groups/{id}",
     *     summary="Редактировать группу",
     *     operationId="editGroup",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Group"),
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
     *         response="404", description="Не найдено",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function editGroup($param, $args)
    {
        (new MGroups())->updateGroup($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/groups/{id}",
     *     summary="Удалить",
     *     operationId="deleteGroup",
     *     produces={"application/json"},
     *     tags={"group"},
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
     *         response="404", description="Не найдено",
     *     )
     * )
     */
    public function deleteGroup($param, $args)
    {
        (new MGroups())->deleteGroup((int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Get(
     *     path="/api/groups/{id}/students",
     *     summary="Список",
     *     operationId="getGroupsStudents",
     *     produces={"application/json"},
     *     tags={"group"},
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
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Student")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudentsList($param, $args): array
    {
        $ids = (new MGroups)->getStudents((int)$args['id']);
        if (!$ids) {
            return [];
        } else {
            return (new MStudents)->getStudentsByList($ids);
        }
    }

    /**
     * @SWG\Delete(
     *     path="/api/groups/{groupId}/students/{studentId}",
     *     summary="Удалить",
     *     operationId="deleteGroupsStudents",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID группы",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID ученика",
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
     *         response="404", description="Не найдено",
     *     )
     * )
     */
    public function deleteStudent($param, $args)
    {
        (new MGroups())->deleteStudent((int)$args['groupId'], (int)$args['studentId']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Post(
     *     path="/api/groups/{groupId}/students/{studentId}",
     *     summary="Списко посещений",
     *     operationId="getGroupAttendancesByDAte",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID группы",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID ученика",
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
     *         response="404", description="Не найдено",
     *     )
     * )
     */
    public function addStudent($param, $args)
    {
        (new MGroups())->addStudent((int)$args['groupId'], (int)$args['studentId']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Get(
     *     path="/api/groups/{groupId}/attendances/{year}/{month}/{day}",
     *     summary="Список посещений группы",
     *     operationId="addStudentToGroup",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID группы",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="year",
     *         in="path",
     *         description="Год",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="month",
     *         in="path",
     *         description="Месяц",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="day",
     *         in="path",
     *         description="День",
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
     *     @SWG\Response(response=403, description="Нет доступа"),
     *     @SWG\Response(
     *         response="404", description="Не найдено",
     *     )
     * )
     */
    public function getAttendancesByDate($param, $args)
    {
        return (new MAttendances)->getListForDate($args['groupId'], new DateDto($args));
    }

    /**
     * @SWG\Get(
     *     path="/api/groups/{groupId}/attendances/{year}/{month}/{day}/{hour}/{minute}",
     *     summary="Список посещений группы",
     *     operationId="getAttendancesByDateTime",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID группы",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="year",
     *         in="path",
     *         description="Год",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="month",
     *         in="path",
     *         description="Месяц",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="day",
     *         in="path",
     *         description="День",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="hour",
     *         in="path",
     *         description="Час",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="minute",
     *         in="path",
     *         description="Минуты",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/ResponseLesson"),
     *     ),
     *     @SWG\Response(response=403, description="Нет доступа"),
     *     @SWG\Response(
     *         response="404", description="Не найдено",
     *     )
     * )
     */
    public function getAttendancesByDateTime($param, $args)
    {
        return (new MAttendances)->getListForDateTime($args['groupId'], new DateDto($args), new TimeDto($args));
    }

    /**
     * @SWG\Post(
     *     path="/api/groups/{groupId}/attendances/",
     *     summary="Добавить посещение",
     *     operationId="addAttendanceInGroup",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID группы",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="date",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/UpdateStudentAttendance"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     *     @SWG\Response(response=403, description="Нет доступа"),
     *     @SWG\Response(
     *         response="404", description="Не найдено",
     *     )
     * )
     */
    public function addAttendance($param, $args)
    {
        (new MAttendances)->addAttendanceDetail(
            (int)$args['groupId'],
            new DateDto($param['dateTime']),
            new TimeDto($param['dateTime']),
            new AttendanceDetail($param['attendance'])
        );
        return new BaseResponse(true);
    }

    /**
     * @SWG\Patch(
     *     path="/api/groups/{groupId}/status/{status}",
     *     summary="Редактировать статус группы",
     *     operationId="editStatusGroup",
     *     produces={"application/json"},
     *     tags={"group"},
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="status",
     *         in="path",
     *         description="key",
     *         required=true,
     *         type="string",
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
    public function editStatusGroup($param, $args)
    {
        (new MGroups())->updateStatusGroup((int)$args['groupId'], $args['status']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Get(
     *     path="/api/groups/{id}/statistic",
     *     summary="Список",
     *     operationId="getStatisticStudents",
     *     produces={"application/json"},
     *     tags={"group"},
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
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/GroupStudentStatistic")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStatisticStudents($param, $args): array
    {
        $dateStart = $args['date_start'] ? new DateDto($args['date_start']) : null;
        $dateEnd = $args['date_end'] ? new DateDto($args['date_end']) : null;
        return (new MGroups())->getStatisticStudents(
            $args['id'], $dateStart, $dateEnd
        );

    }
}