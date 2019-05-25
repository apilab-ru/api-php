<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Attendance"))
 */

namespace app\entity;

class Attendance extends Base
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
     * @SWG\Property(
     *    title="Ученики",
     *    type="array",
     *    @SWG\Items(ref="#/definitions/AttendanceDetail")
     * )
     * @var array
     */
    public $students;

    /**
     * @SWG\Property(title="Домашнее задание")
     * @var integer
     */
    public $home_work;

    public function serializeToBd()
    {
        $data = parent::serializeToBd();
        unset($data['students']);
        return $data;
    }

    protected $types = [
        'id' => 'integer',
        'group_id' => 'integer',
        'date' => 'date',
        'time' => 'time'
    ];
}