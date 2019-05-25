<?php

declare(strict_types=1);

namespace app\model;


class Migrate extends Base
{
	public function migrateLeads()
	{
		$leads = $this->select("select * from leads");
		$sources = [];

		foreach ($leads as $lead) {
			if ($lead['sources']) {
				$sc = explode(',', $lead['sources']);
				foreach ($sc as $s) {
					$sources[] = [
						'source_id' => $s,
						'lead_id' => $lead['id']
					];
				}
			}
		}

		foreach ($sources as $s) {
			$this->addObject('leads_sources', $s);
		}

		pr($sources);
	}
}