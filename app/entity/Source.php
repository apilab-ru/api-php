<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Source"))
 */

namespace app\entity;

class Source extends Base
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

    protected $types = [
        'id' => 'integer'
    ];
}