<?php

/**
 * @SWG\Definition(required={}, type="object", @SWG\Xml(name="GroupStudentStatistic"))
 */

namespace app\entity;

class GroupStudentStatistic extends Base {

    /**
     * @SWG\Property(format="int64", title="ID ученика")
     * @var integer
     */
    public $student_id;

    /**
     * @SWG\Property(format="int64", title="Средняя оценка")
     * @var integer
     */
    public $rating;

    /**
     * @SWG\Property(format="int64", title="Кол-во посещённый занятий")
     * @var integer
     */
    public $visited_lesson;

    /**
     * @SWG\Property(format="int64", title="Общее кол-во занятий")
     * @var integer
     */
    public $total_lesson;

    protected $types = [
        'student_id' => 'integer',
        'rating' => 'integer',
        'visited_lesson' => 'integer',
        'total_lesson' => 'integer'
    ];

}