<?php

namespace app\services;

class DeliverySmsBy extends DeliveryAbstract {

	private $api;

	public function send(string $phone, string $message): SmsResponse {
		$message = $this->api->createSMSMessage($message);
		$res = $this->api->sendSms($message[0]->message_id, $phone);
		return new SmsResponse($res->sms_id, $res->status);
	}

	/*
	 	"status":"new", // статус сообщения, отправка СМС возможна только если статус == moderated
		"parts":1, // количество частей в СМС сообщении
		"alphaname":"SYSTEM" // альфа-имя
	*/
	public function getState(int $messageId)
	{
		$state = $this->api->checkSMSMessageStatus($messageId);
		return $state;
	}

	protected function init() {
		$this->api = new SmsBy($this->set['token']);
	}

}

class SmsResponse {

	public $sms_id;
	public $status;

	public function __construct(string $sms_id, string $status)
	{
		$this->status = $status;
		$this->sms_id = $sms_id;
	}
}