<?php
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="StatisticLeadFilter"))
 */

namespace app\entity\request;

use app\entity\DateDto;

class StatisticLeadFilter {

	public $from; // DateDto

	public $to; // DateDto

	public $mode; // string

	public $source_list; // number[]

	public $status_list; // number[]

	public function __construct(array $param)
	{
		if ($param['from']) {
			$this->from = new DateDto($param['from']);
		}

		if ($param['to']) {
			$this->to = new DateDto($param['to']);
		}

		if ($param['mode']) {
			$this->mode = $param['mode'];
		}

		if ($param['source_list']) {
			$this->source_list = json_decode($param['source_list'], true);
		}

		if ($param['status_list']) {
			$this->status_list = json_decode($param['status_list'], true);
		}
	}

}