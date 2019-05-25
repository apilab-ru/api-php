<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="StudentScore"))
 */

namespace app\entity;

class StudentScore extends Base
{
    /**
     * @SWG\Property(title="Педагог")
     * @var integer
     */
    public $teacher_id;

    /**
     * @SWG\Property(title="Оценка")
     * @var integer
     */
    public $loyalty;


    protected $types = [
        'teacher_id' => 'integer',
        'loyalty'=> 'integer',
    ];
}