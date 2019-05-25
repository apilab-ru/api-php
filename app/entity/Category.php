<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Category"))
 */

namespace app\entity;

class Category extends Base
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
     * @SWG\Property(title="Возраст")
     * @var integer
     */
    public $age;

    protected $types = [
        'id' => 'integer',
        'age' => 'integer'
    ];
}