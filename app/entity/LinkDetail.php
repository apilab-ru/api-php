<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="LinkDetail"))
 */

namespace app\entity;

class LinkDetail extends Base
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

    /**
     * @SWG\Property(title="Сущность")
     * @var string
     */
    public $entity;

    /**
     * @SWG\Property(title="ID Сущностьи")
     * @var integer
     */
    public $entity_id;
}