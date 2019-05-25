<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Course"))
 */

namespace app\entity;

class Course extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(title="Название")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(title="Описание")
     * @var string
     */
    public $description;

    /**
     * @SWG\Property(title="Язык")
     * @var integer
     */
    public $lang_id;

    /**
     * @SWG\Property(title="Занятий")
     * @var integer
     */
    public $lessons;

    /**
     * @SWG\Property(title="Цена")
     * @var float
     */
    public $total_price;

    protected $types = [
        'id' => 'integer',
        'lang_id' => 'integer',
        'lessons' => 'integer',
        'total_price' => 'real'
    ];
}