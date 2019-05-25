<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="AttendanceStatus"))
 */

namespace app\entity;

class AttendanceStatus extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(title="Статус")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(title="Оплачиваемое")
     * @var real
     */
    public $charge;


    protected $types = [
        'id' => 'integer',
        'charge' => 'boolean'
    ];
}