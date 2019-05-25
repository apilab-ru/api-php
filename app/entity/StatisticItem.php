<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="StatisticItem"))
 */

namespace app\entity;

class StatisticItem extends Base
{
    /**
     * @SWG\Property(title="Всего")
     * @var integer
     */
    public $total = 0;

    /**
     * @SWG\Property(title="Маркер")
     * @var string
     */
    public $marker;

    /**
     * @SWG\Property(title="Дата")
     * @var DateDto
     */
    public $date;


    protected $types = [
        'total' => 'integer',
        'date' => 'date'
    ];
}