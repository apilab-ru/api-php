<?php

/**
 * @SWG\Definition( type="object", @SWG\Xml(name="DeliveryDetails"))
 */

namespace app\entity;

class DeliveryDetails extends Base {

	/**
	 * @SWG\Property(format="int64")
	 * @var integer
	 */
	public $id;

	/**
	 * @SWG\Property(title="Тип контакта", enum={"students", "leads"})
	 * @var string
	 */
	public $contact_type;

	/**
	 * @SWG\Property(title="Фильтр")
	 * @var string
	 */
	public $filter;

	/**
	 * @SWG\Property(title="Кол-во писем")
	 * @var integer
	 */
	public $count;

	/**
	 * @SWG\Property(title="Активна")
	 * @var boolean
	 */
	public $active;

	/**
	 * @SWG\Property(title="Название")
	 * @var string
	 */
	public $name;

	/**
	 * @SWG\Property(title="Статус", enum={"planned", "process", "completed", "canceled".})
	 * @var string
	 */
	public $status;

	/**
	 * @SWG\Property(ref="#/definitions/DateTimeDto", title="Дата рассылки")
	 * @var date
	 */
	public $date;

	/**
	 * @SWG\Property(title="Сообщение")
	 * @var string
	 */
	public $message;

	protected $types = [
		'id' => 'integer',
		'count' => 'integer',
		'date' => 'date-time',
	];
}