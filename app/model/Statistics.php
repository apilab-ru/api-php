<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Statistic;

class Statistics extends Base
{
    public function getTotalStatistic(): Statistic
    {
        $data = $this->db->selectRow("SELECT 
            (SELECT COUNT(*) FROM `groups` where status != 'archive') as groups,
            (SELECT COUNT(*) FROM `students`) as students,
            (SELECT COUNT(*) FROM `leads`) as leads,
            (SELECT COUNT(*) FROM `leads` where WEEK(date_create) = WEEK(NOW())) as leadsWeek");
        return new Statistic($data);
    }

}