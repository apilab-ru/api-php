<?php

/**
 * @SWG\Definition( type="object", @SWG\Xml(name="TimeDto"))
 */

namespace app\entity;

class TimeDto extends Base
{
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

    public function serializeToBd() {
        return $this->timeToString($this);
    }

    protected $types = [
        'hour' => 'integer',
        'minute' => 'integer',
    ];
}