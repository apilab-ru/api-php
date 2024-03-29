<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Lead;
use app\entity\LeadStatus;
use app\entity\request\StatisticLeadFilter;

class Leads extends Base
{

    public function getList(array $filter = null): ?array
    {
        $data = $this->db->select("SELECT l.*, GROUP_CONCAT(s.source_id) as sources
			FROM `leads` as l 
			left join leads_sources as s on s.lead_id = l.id 
			where 1=1 "
			. ($filter['havePhone'] ? "&& l.phone is not null && l.phone != '' ": '')
			. " 
				{ && l.name like ? }
				{ && l.status in (?a) }
				{ && s.source_id in (?a) }
				{ && l.date_change >= ? }
				{ && l.date_change <= ? }
			group by l.id 
				order by date_create DESC",
			$filter['name'] ? ("%" . $filter['name'] . "%")  : DBSIMPLE_SKIP,
			$filter['status_list'] ? array_map(intval, $filter['status_list']) : DBSIMPLE_SKIP,
			$filter['source_list'] ? array_map(intval, $filter['source_list']) : DBSIMPLE_SKIP,
			$filter['from'] ? $this->dateToString($filter['from']) : DBSIMPLE_SKIP,
			$filter['to'] ? $this->dateToString($filter['to']) : DBSIMPLE_SKIP
		);
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Lead($item);
            }
            return $list;
        } else {
            return [];
        }
    }

	public function add(array $data)
	{
		$lead = (new Lead($data, true));
		$leadId = $this->addObject('leads', $lead->serializeToBd());
		if ($lead->sources) {
			$this->setLeadSources($leadId, $lead->sources);
		}
		$this->logStatus($leadId, (int)$lead->status);
		return $leadId;
	}

	private function setLeadSources(int $leadId, ?array $sources)
	{
		$this->db->query('delete from leads_sources where lead_id =?d', $leadId);
		foreach ($sources as $source) {
			$this->addObject('leads_sources', [
				'lead_id' => $leadId,
				'source_id' => (int)$source
			]);
		}
	}

    public function update(array $data, $id)
    {
        $lead = (new Lead($data, true));
		$lead->date_change = $this->getNowDto();

		$oldLead = $this->getById($id);
        $this->updateObject('leads', $lead->serializeToBd(), $id);
        $this->setLeadSources($id, $lead->sources);
        if ($oldLead->status != $lead->status) {
			$this->logStatus($id, (int)$lead->status);
		}
        return $id;
    }

    public function getById(int $id):? Lead {
    	$data = $this->selectRow('SELECT l.*, GROUP_CONCAT(s.source_id) as sources
			FROM `leads` as l 
				left join leads_sources as s on s.lead_id = l.id 
				where l.id =?d
				group by l.id', $id);
    	return new Lead($data);
	}

    public function delete($id)
    {
        $stat = $this->deleteObject('leads', $id);
        $this->db->query('delete from leads_sources where lead_id =?d', $id);
        return $stat;
    }

    public function getStatisticByDate(StatisticLeadFilter $filter)
    {
        $dateFromString = $filter->from->serializeToBd();
        $dateToString = $filter->to->serializeToBd();

        switch($filter->mode) {
            case 'day':
                $format = "%Y-%m-%d";
                break;

            case 'week':
                $format = "%Y-%u";
                break;

            case 'month':
                $format = "%Y-%m";
                break;

            case 'year':
                $format = "%Y";
                break;
        }

		$data = $this->select("select 
			lta.date_change as date, count(*) as total, DATE_FORMAT(lta.date_change, '$format') as marker, 
				lta.status_id
			from leads_to_status as lta
				left join leads as l on l.id = lta.lead_id
				left join leads_sources as s on s.lead_id = lta.lead_id
			where DATE_FORMAT(lta.date_change, '%Y-%m-%d') >= ? && DATE_FORMAT(lta.date_change, '%Y-%m-%d') <= ?
				{ && lta.status_id in (?a)}
				{ && s.source_id in (?a)}
			group by DATE_FORMAT(lta.date_change, '$format'), lta.status_id
			order by lta.date_change",
			$dateFromString,
			$dateToString,
			$filter->status_list ? $filter->status_list : DBSIMPLE_SKIP,
			$filter->source_list ? $filter->source_list : DBSIMPLE_SKIP
		);

        $total = $this->aggregateTotalStatus($data);

        return [
        	'total' => $total,
        	'chart' => $this->genChartStatistic($data),
			'table' => $this->aggregateChangeStatusStatistic($total)
		];
    }

    private function aggregateTotalStatus($data) {
		$map = [];
		foreach ($data as $item) {
			$map[$item['status_id']] += $item['total'];
		}
		return $map;
	}

    private function genChartStatistic($data)
	{
		$statusList = [];
		$map = [];
		foreach ($data as $item) {
			$statusId = (int)$item['status_id'];
			$statusList[$statusId] = $statusId;
			$map[$item['marker']]['date'] = $item['date'];
			$map[$item['marker']]['list'][$statusId] = (int)$item['total'];
		}

		$statusList = array_values($statusList);

		$dataSet = [];
		foreach ($map as $marker => $unit) {
			foreach ($statusList as $num => $status) {
				$dataSet[$num]['label'] = $status;
				$dataSet[$num]['data'][] = (int)$unit['list'][$status];
				$dataSet[$num]['meta'][] = [
					'date' => $unit['date'],
					'label' => $marker
				];
			}
		}

		return $dataSet;
	}

	private function aggregateChangeStatusStatistic($map)
	{
		$statusList = $this->getStatusList();

		$result = [];

		foreach ($statusList as $status) {
			$parentId = (int)$status->parent;
			$statusId = (int)$status->id;
			if ($parentId  && $map[$parentId]) {
				$result[] = [
					'from' => $parentId,
					'fromCount' => $map[$parentId],
					'to' => $statusId,
					'toCount' => (int)$map[$statusId]
				];
			}
		}

		return $result;
	}

	public function getStatusList(): ?array
	{
		$data = $this->select("select * from lead_statuses order by id ASC");
		$list = [];
		foreach ($data as $item) {
			$list[] = new LeadStatus($item);
		}
		return $list;
	}

	public function deleteStatus(int $id)
	{
		return $this->deleteObject('lead_statuses', $id);
	}

	public function addStatus($form): ?int
	{
		$leadStatus = new LeadStatus($form, true);
		return $this->updateObject('lead_statuses', $leadStatus->serializeToBd());
	}

	public function updateStatus($form, int $id): ?int
	{
		$leadStatus = new LeadStatus($form, true);
		return $this->updateObject('lead_statuses', $leadStatus->serializeToBd(), $id);
	}

    private function logStatus(int $leadId, int $statusId)
	{
		return $this->addObject('leads_to_status', [
			'lead_id' => $leadId,
			'status_id' => $statusId,
			'user_id' => $_SESSION['user']['id']
		]);
	}

	private function dateToString(array $date): string
	{
		$month = str_pad("".$date['month'], 2, "0", STR_PAD_LEFT);
		$day = str_pad("".$date['day'], 2, "0", STR_PAD_LEFT);
		return "{$date['year']}-{$month}-{$day}";
	}

}