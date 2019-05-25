<?php

/**
 * @SWG\Definition(required={"is_regular", "time_start", "time_end"}, type="object", @SWG\Xml(name="Lesson"))
 */

namespace app\entity;

class Lesson extends Base
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
     * @SWG\Property(title="Регулярное")
     * @var boolean
     */
    public $is_regular;

    /**
     * @SWG\Property(title="День недели")
     * @var integer
     */
    public $day_week;

    /**
     * @SWG\Property(ref="#/definitions/TimeDto", title="Время начала")
     * @var time
     */
    public $time_start;

    /**
     * @SWG\Property(ref="#/definitions/TimeDto", title="Время окончания")
     * @var time
     */
    public $time_end;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="Дата")
     * @var date
     */
    public $date;


    protected $types = [
        'id' => 'integer',
        'group_id'=> 'integer',
        'is_regular'=> 'boolean',
        'day_week'=> 'integer',
        'time_start' => 'time',
        'time_end' => 'time',
        'date' => 'date'
    ];
}