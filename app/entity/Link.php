<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Link"))
 */

namespace app\entity;

class Link extends Base
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
     * @SWG\Property(title="Ссылка")
     * @var string
     */
    public $link;

    protected $types = [
        'id' => 'integer'
    ];
}