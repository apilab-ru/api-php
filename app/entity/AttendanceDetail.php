<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="AttendanceDetail"))
 */

namespace app\entity;

class AttendanceDetail extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(title="Статус")
     * @var integer
     */
    public $status_id;

    /**
     * @SWG\Property(title="Ученик")
     * @var integer
     */
    public $student_id;

    /**
     * @SWG\Property(title="Id занятия")
     * @var integer
     */
    public $attendance_id;

    /**
     * @SWG\Property(title="Оценка")
     * @var integer
     */
    public $rating;

    /**
     * @SWG\Property(title="Рекомендация")
     * @var integer
     */
    public $comment;

    /**
     * @SWG\Property(title="Статус выполнения ДЗ", enum={"complete","part","not_ready"})
     * @var string
     */
    public $homework_status;

    protected $types = [
        'id' => 'integer',
        'status_id' => 'integer',
        'attendance_id' => 'integer',
        'student_id' => 'integer',
        'rating' => 'integer'
    ];
}