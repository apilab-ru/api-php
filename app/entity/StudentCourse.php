<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="StudentCourse"))
 */

namespace app\entity;

class StudentCourse extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $student_id;

    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $course_id;


    protected $types = [
        'student_id' => 'integer',
        'course_id' => 'integer'
    ];
}