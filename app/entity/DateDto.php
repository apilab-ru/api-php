<?php

/**
 * @SWG\Definition( type="object", @SWG\Xml(name="DateDto"))
 */

namespace app\entity;

class DateDto extends Base
{
    public function __construct($date = null)
    {
        if(is_string($date)) {
            $d = $this->stringToDate($date);
            $this->year = $d->year;
            $this->month = $d->month;
            $this->day = $d->day;
        } else {
            return parent::__construct($date);
        }
    }
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

    protected $types = [
        'year' => 'integer',
        'month' => 'integer',
        'day' => 'integer',
    ];

    public function serializeToBd() {
        return $this->dateToString($this);
    }
}