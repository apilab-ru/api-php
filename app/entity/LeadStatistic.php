<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="LeadStatistic"))
 */

namespace app\entity;

class LeadStatistic extends Base
{
    /**
     * @SWG\Property(title="Метки")
     */
    public $marks = [];

    /**
     * @SWG\Property(title="Новые")
     */
    public $new = [];

    /**
     * @SWG\Property(title="Завершённые")
     */
    public $complete = [];

    /**
     * @SWG\Property(title="В работе")
     */
    public $work = [];

    /**
     * @SWG\Property(title="Отменёные")
     */
    public $cancel = [];

    public $keys = [];


    protected $types = [
    ];
}