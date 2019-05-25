<?php

namespace app\controller;

use \app\model\Attendances as MAttendances;

class Attendances extends Base {

    /**
     * @SWG\Get(
     *     path="/api/attendances/statuses",
     *     summary="Список статусов",
     *     operationId="getAttendanceStatuses",
     *     produces={"application/json"},
     *     tags={"attendance"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/AttendanceStatus")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStatuses()
    {
        return (new MAttendances())->getStatuses();
    }

    /**
     * @SWG\Post(
     *     path="/api/attendances",
     *     summary="Обновить / Добавить занятие",
     *     operationId="updateLessonAttendee",
     *     produces={"application/json"},
     *     tags={"attendance"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/UpdateLessonAttendance"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function updateLessonAttendee($param)
    {
        return (new MAttendances())->updateLessonAttendee($param);
    }
}