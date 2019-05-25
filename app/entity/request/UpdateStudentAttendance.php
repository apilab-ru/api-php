<?php
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="UpdateAttendance"))
 */

namespace app\entity\request;

class UpdateStudentAttendance
{

    /**
     * @SWG\Property(ref="#/definitions/DateTimeDto", title="Дата и время")
     */
    public $dateTime;

    /**
     * @SWG\Property(ref="#/definitions/AttendanceDetail", title="Посещение ученика")
     */
    public $attendance;

}