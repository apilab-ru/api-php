<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="AttendanceStudent"))
 */

namespace app\entity;

class AttendanceStudent extends Base
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
     * @SWG\Property(title="Статус")
     * @var integer
     */
    public $status_id;

    /**
     * @SWG\Property(title="Стоимость")
     * @var real
     */
    public $cost;

    /**
     * @SWG\Property(title="Домашняя работа")
     * @var string
     */
    public $home_work;

    /**
     * @SWG\Property(title="Оценка")
     * @var string
     */
    public $rating;

    /**
     * @SWG\Property(title="Рекомендация")
     * @var string
     */
    public $comment;

    /**
     * @SWG\Property(title="Статус выполнения ДЗ", enum={"complete","part","not_ready"})
     * @var string
     */
    public $homework_status;


    protected $types = [
        'id' => 'integer',
        'group_id' => 'integer',
        'date' => 'date',
        'time' => 'time',
        'status_id' => 'integer',
        'rating' => 'integer'
    ];
}