<?php

/**
 * @SWG\Definition( type="object", @SWG\Xml(name="DateTimeDto"))
 */

namespace app\entity;

class DateTimeDto extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $year;

    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $month;

    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $day;

    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $hour;

    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $minute;

    protected $types = [
        'year' => 'integer',
        'month' => 'integer',
        'day' => 'integer',
        'hour' => 'integer',
        'minute' => 'integer',
    ];
}