<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Lead;
use app\entity\LeadStatus;
use app\entity\request\StatisticLeadFilter;

class Leads extends Base
{

    public function getList(): ?array
    {
        $data = $this->db->select("select * from leads order by date_create DESC");
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
		$this->logStatus($leadId, (int)$lead->status);
		return $leadId;
	}

    public function update(array $data, $id)
    {
        $lead = (new Lead($data, true));
		$lead->date_change = $this->getNowDto();

		$oldLead = $this->getById($id);
        $this->updateObject('leads', $lead->serializeToBd(), $id);
        if ($oldLead->status != $lead->status) {
			$this->logStatus($id, (int)$lead->status);
		}
        return $id;
    }

    public function getById(int $id):? Lead {
    	$data = $this->selectRow('select * from leads where id=?d', $id);
    	return new Lead($data);
	}

    public function delete($id)
    {
        return $this->deleteObject('leads', $id);
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
			where DATE_FORMAT(lta.date_change, '%Y-%m-%d') >= ? && DATE_FORMAT(lta.date_change, '%Y-%m-%d') <= ?
				{ && lta.status in (?a)}
				{ && l.sources in (?a)}
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

    private function findItem($new, $complete, $work, $cancel): array
    {
        return $new ? $new :
            ($complete ? $complete :
                ($work ? $work : $cancel));
    }

    private function logStatus(int $leadId, int $statusId)
	{
		return $this->addObject('leads_to_status', [
			'lead_id' => $leadId,
			'status_id' => $statusId,
			'user_id' => $_SESSION['user']['id']
		]);
	}

}