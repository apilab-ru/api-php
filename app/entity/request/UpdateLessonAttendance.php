<?php
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="UpdateLessonAttendance"))
 */

namespace app\entity\request;

class UpdateLessonAttendance
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(title="Группа")
     * @var integer
     */
    public $group_id;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="Дата")
     * @var date
     */
    public $date;

    /**
     * @SWG\Property(ref="#/definitions/TimeDto", title="Время")
     * @var time
     */
    public $time;

    /**
     * @SWG\Property(title="Домашнее задание")
     * @var integer
     */
    public $home_work;

}