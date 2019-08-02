<?php

declare(strict_types=1);

namespace app\model;

use app\App;
use app\entity\Delivery as DeliveryDto;
use app\entity\DeliveryDetails;
use app\services\DeliverySmsBy;

class Delivery extends Base
{

    public function addDelivery(array $deliveryData): Int {
		$deliveryData['active'] = true;
    	$delivery = new DeliveryDetails($deliveryData, true);
    	return $this->addObject('delivery', $delivery->serializeToBd());
	}

	public function updateDelivery(int $deliveryId, array $deliveryData): Int {
		$deliveryData['active'] = true;
		$delivery = new DeliveryDetails($deliveryData, true);
		return $this->updateObject('delivery', $delivery->serializeToBd(), $deliveryId);
	}

	public function updateDeliveryActive(int $deliveryId, array $deliveryActiveData)
	{
		$active = $deliveryActiveData['active'];
		$update = ['active' => $active ? 1 : 0];
		if (!$active) {
			$delivery = $this->loadDelivery($deliveryId);
			if ($delivery->status === 'process') {
				$this->stopProcess($deliveryId);
				$update['status'] = 'canceled';
			}
		}
		$this->updateObject('delivery', $update, $deliveryId);
	}

	public function loadDelivery(int $deliveryId): DeliveryDetails {
    	$data = $this->selectRow('select * from delivery where id=?d', $deliveryId);
		return new DeliveryDetails($data);
	}

	public function getList(): array {
    	$data = $this->select('select id, contact_type, `count`, `name`, status, `date`, `active`, `statistic`
				from delivery order by `date` DESC');
    	$list = [];
    	foreach ($data as $item) {
    		$list[] = new DeliveryDto($item);
		}
    	return $list;
	}

	public function checkDelivery()
	{
		$period = App::$param['delivery']['period'];
		$dateStart = date(
			'Y-m-d H:i:s',
			(int) time() + ($period / 2)
		);
		$list = $this->select("select * from delivery 
			where status='planned' && `date` <= ? && active=1", $dateStart);
		foreach ($list as $delivery) {
			$this->startProcessDelivery(new DeliveryDetails($delivery));
			$this->updateObject('delivery', [
				'status' => 'process'
			], $delivery['id']);
		}
	}

	public function sendDelivery()
	{
		set_time_limit(240);
		$limit = App::$param['delivery']['count'];
		$messages = $this->select("select * from delivery_message
			where status ='planned' 
			&& delivery_id in(select id from delivery where status = 'process' && active=1) limit ?d",
			$limit
		);
		$deliveryUpdatedMap = [];
		$api = new DeliverySmsBy(App::$param['delivery']['set']);
		foreach ($messages as $message) {
			$deliveryUpdatedMap[$message['delivery_id']] = [];
			try {
				$res = $api->send($message['contact'], $message['message']);
				$this->updateObject('delivery_message', [
					'status' => 'completed',
					'response' => json_encode($res)
				], $message['id']);
			} catch (\Exception $error) {
				$res = $error->getMessage();
				$this->updateObject('delivery_message', [
					'status' => 'error',
					'response' => json_encode($res)
				], $message['id']);
			}
		}

		$completedDelivery = $this->select("select delivery.*
			from delivery 
				where status ='process' && active=1 
				&& (select count(*) from delivery_message 
					where delivery_id=delivery.id && delivery_message.status = 'planned') < 1");

		foreach ($completedDelivery as $delivery) {
			$this->updateObject('delivery', [
				'status' => 'completed'
			], $delivery['id']);
		}

		$statList = $this->select("SELECT delivery_id, status, count(*) as count FROM `delivery_message` 
			where delivery_id in (?a)
			group by `delivery_id`,`status`", array_keys($deliveryUpdatedMap));

		foreach ($statList as $stat) {
			$deliveryUpdatedMap[$stat['delivery_id']][$stat['status']] = (int) $stat['count'];
		}

		foreach ($deliveryUpdatedMap as $deliveryId => $stat) {
			$this->updateObject('delivery', [
				'statistic' => json_encode($stat)
			], $deliveryId);
		}
	}

	private function startProcessDelivery(DeliveryDetails $delivery)
	{
		$parsedMessage = $this->parseMessage($delivery);
		$contacts = $this->getContacts($delivery);

		$add = [];
		foreach ($contacts as $contact) {
			$add[] = [
				'delivery_id' => $delivery->id,
				'message' => $parsedMessage($contact),
				'contact' => $this->preparePhone($contact->phone),
				'status' => 'planned',
				'response' => null
			];
		}
		foreach ($add as $item) {
			$this->addObject('delivery_message', $item);
		}
	}

	private function preparePhone(string $phone) {
    	return preg_replace('/[^0-9]/', '', $phone);
	}

	private function parseMessage(DeliveryDetails $delivery)
	{
		return function($contact) use ($delivery) {
			return str_replace('#name', $contact->name, $delivery->message);
		};
	}

	private function getContacts(DeliveryDetails $delivery)
	{
		$filter = json_decode($delivery->filter, true);
		if ($delivery->contact_type === 'leads') {
			return (new Leads())->getList($filter);
		}
		if ($delivery->contact_type === 'students') {
			return (new Students())->getList($filter);
		}
	}

	private function stopProcess(int $deliveryId) {
    	$this->db->query("delete from delivery_message where delivery_id=?d && status='planned'", $deliveryId);
	}

}