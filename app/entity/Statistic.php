<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Statistic"))
 */

namespace app\entity;

class Statistic extends Base
{
    /**
     * @SWG\Property(title="Лиды")
     * @var integer
     */
    public $leads;

    /**
     * @SWG\Property(title="Лиды недели")
     * @var integer
     */
    public $leadsWeek;

    /**
     * @SWG\Property(title="Ученики")
     * @var integer
     */
    public $students;

    /**
     * @SWG\Property(title="Группы")
     * @var integer
     */
    public $groups;


    protected $types = [
        'leads'=> 'integer',
        'leadsWeek'=> 'integer',
        'students'=> 'integer',
        'groups'=> 'integer',
    ];
}