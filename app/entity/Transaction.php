<?php

/**
 * @SWG\Definition(required={"type", "entity_type", "entity_id", "value"}, type="object", @SWG\Xml(name="Transaction"))
 */

namespace app\entity;

class Transaction extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(title="Тип",  enum={"deposit", "payment", "withdrawal"})
     * @var string
     */
    public $type;

    /**
     * @SWG\Property(title="Объект", enum={"student", "user"})
     * @var string
     */
    public $entity_type;

    /**
     * @SWG\Property(title="ID объекта")
     * @var integer
     */
    public $entity_id;

    /**
     * @SWG\Property(title="ID посещения")
     * @var integer
     */
    public $attendee_id;

    /**
     * @SWG\Property(title="Величина")
     * @var float
     */
    public $value;

    /**
     * @SWG\Property(ref="#/definitions/DateTimeDto", title="Дата создания")
     * @var date
     */
    public $date_create;

    /**
     * @SWG\Property(title="Описание")
     * @var string
     */
    public $description;

    protected $types = [
        'entity_id' => 'integer',
        'id' => 'integer',
        'date_create' => 'date-time',
        'attendee_id' => 'integer',
        'value' => 'real'
    ];
}