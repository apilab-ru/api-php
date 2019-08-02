<?php

namespace app\services;

abstract class DeliveryAbstract {

	protected $set;

	public function __construct($set)
	{
		$this->set = $set;
		$this->init();
	}

	abstract protected function init();

	abstract protected function send(string $phone, string $message);

}
