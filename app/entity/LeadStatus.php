<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="LeadStatus"))
 */

namespace app\entity;

class LeadStatus extends Base
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
	 * @SWG\Property(title="Ключ")
	 * @var string
	 */
	//public $key;

	/**
	 * @SWG\Property(format="int64")
	 * @var integer
	 */
	public $parent;

	protected $types = [
		"id" => "integer",
		"parent" => "integer",
	];

}