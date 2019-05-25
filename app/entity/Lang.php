<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Lang"))
 */

namespace app\entity;

class Lang extends Base
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
     * @SWG\Property(title="Название в дательном падеже")
     * @var string
     */
    public $name_dative;

    /**
     * @SWG\Property(title="Цвет")
     * @var string
     */
    public $color;

    protected $types = [
        'id' => 'integer'
    ];
}