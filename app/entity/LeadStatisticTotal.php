<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="LeadStatisticTotal"))
 */

namespace app\entity;

class LeadStatisticTotal extends Base
{
    /**
     * @SWG\Property(title="Новых")
     */
    public $new = 0;

    /**
     * @SWG\Property(title="В работе")
     */
    public $work = 0;

    /**
     * @SWG\Property(title="Отменёные")
     */
    public $cancel = 0;

    /**
     * @SWG\Property(title="Завершённые")
     */
    public $complete = 0;

    /**
     * @SWG\Property(title="Всего")
     */
    public $total = 0;

    protected $types = [
        'new' => 'integer',
        'work' => 'integer',
        'cancel' => 'integer',
        'complete' => 'integer',
        'total' => 'integer'
    ];
}