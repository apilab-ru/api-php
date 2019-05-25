<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Lead"))
 */

namespace app\entity;

class Lead extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="Дата создания")
     * @var date
     */
    public $date_create;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="Дата изменения")
     * @var date
     */
    public $date_change;

    /**
     * @SWG\Property(title="Ученик")
     * @var string
     */
    public $student_id;

    /**
     * @SWG\Property(title="Имя")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(title="Источники")
     * @var string
     */
    public $sources;

    /**
     * @SWG\Property(title="Комментарий")
     * @var string
     */
    public $comment;

    /**
     * @SWG\Property(title="Статус", enum={"new", "work", "cancel", "complete"})
     * @var string
     */
    public $status;

    /**
     * @SWG\Property(title="Телефон")
     * @var string
     */
    public $phone;

    protected $types = [
        "id" => "integer",
		"status" => "integer",
        "date_create" => "date",
        "date_change" => "date",
        "student_id" => "integer",
        "sources" => "ids",
    ];

    public function serializeToBd() {
		$data = parent::serializeToBd();
		unset($data['sources']);
		return $data;
	}
}